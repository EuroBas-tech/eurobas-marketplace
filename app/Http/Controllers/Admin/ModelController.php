<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\Model\Admin;
use App\Model\Brand;
use App\Model\Category;
use App\CPU\ImageManager;
use App\Model\Translation;
use App\Model\VehicleModel;
use Illuminate\Http\Request;
use App\Exports\BrandListExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;

class ModelController extends Controller
{
    public function add_new()
    {
        $br = VehicleModel::latest()->paginate(Helpers::pagination_limit());

        $brands = Brand::with('categories:id')->get()->map(function ($brand) {
            return [
                'id' => $brand->id,
                'name' => $brand->name,
                'categories' => $brand->categories->pluck('id')->toArray(), // Always an array
            ];
        });

        $categories = Category::where('category_type', 'vehicles')->get();

        return view('admin-views.model.add-new', compact('br', 'brands', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:brands,name',
            'categories' => 'required|array',
            'brand' => 'required|integer'
        ]);

        $model = new VehicleModel;
        $model->name = $request->name;
        $model->brand_id = $request->brand;
        $model->status = 1;
        $model->save();
    
        $model->categories()->attach($request->categories);

        Toastr::success(translate('model_added_successfully'));
        return redirect()->route('admin.model.list');
    }

    /**
     * Brand list show, search
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function list(Request $request)
    {
        $search      = $request['search'];
        $query_param = $search ? ['search' => $request['search']] : '';

        $models = VehicleModel::with('brand')
            ->when($request['search'], function ($q) use($request){
                $key = explode(' ', $request['search']);
                foreach ($key as $value) {
                    $q->Where('name', 'like', "%{$value}%")
                      ->orWhere('id', $value);
                }
            })
            ->latest()->paginate(Helpers::pagination_limit())->appends($query_param);

        return view('admin-views.model.list', compact('models','search'));
    }

    /**
     * Export brand list by excel
     * @return string|\Symfony\Component\HttpFoundation\StreamedResponse
     * @throws \Box\Spout\Common\Exception\IOException
     * @throws \Box\Spout\Common\Exception\InvalidArgumentException
     * @throws \Box\Spout\Common\Exception\UnsupportedTypeException
     * @throws \Box\Spout\Writer\Exception\WriterNotOpenedException
     */
    public function export(Request $request){
        $search = $request['search'];
        $brands = Brand::withCount('brandAllProducts')
            ->with(['brandAllProducts'=> function($query){
                $query->withCount('order_details');
            }])
            ->when($search, function ($q) use($search){
                $key = explode(' ', $search);
                foreach ($key as $value) {
                    $q->Where('name', 'like', "%{$value}%")
                      ->orWhere('id', $value);
                }
            })->orderBy('id', 'DESC')->get();

        // $data = array();
        // foreach($brands as $brand){
        //     $data[] = array(
        //         'Brand Name'      => $brand->name,
        //         'Total Product'   => $brand->brand_all_products_count,
        //         'Total Order' => $brand->brandAllProducts->sum('order_details_count'),
        //     );
        // }
        // dd($brands);
        $active = $brands->where('status',1)->count();
        $inactive = $brands->where('status',0)->count();
        $data = [
            'brands'=>$brands,
            'search' =>$search ,
            'active' => $active,
            'inactive' => $inactive,
        ];
        return Excel::download(new BrandListExport($data), 'Brand-list.xlsx') ;
        // return (new FastExcel($data))->download('brand_list.xlsx');
    }

    public function edit($id)
    {
        $m = VehicleModel::with('brand.categories')->find($id);        
        $categories = Category::where('category_type', 'vehicles')->get();

        $brands = Brand::with('categories:id')->get()->map(function ($brand) {
            return [
                'id' => $brand->id,
                'name' => $brand->name,
                'categories' => $brand->categories->pluck('id')->toArray(), // Always an array
            ];
        });

        $modelCategoriesIds = $m->categories->pluck('id')->toArray();
        $initialCategories = $m->brand?->categories?->pluck('id')->toArray() ?? [];

        return view('admin-views.model.edit', compact('m', 'brands', 'categories', 'modelCategoriesIds', 'initialCategories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'categories' => 'required|array',
            'brand' => 'required|integer'
        ]);

        $model = VehicleModel::find($id);
        $model->name = $request->name;
        $model->brand_id = $request->brand;
        $model->save();
        
        $model->categories()->sync($request['categories']);
        
        Toastr::success(translate('model_updated_successfully'));
        return redirect()->route('admin.model.list');
    }

    public function status_update(Request $request)
    {
        $model = VehicleModel::find($request['id']);
        $model->status = $request['status'] ?? 0;

        if($model->save()){
            $success = 1;
        }else{
            $success = 0;
        }
        return response()->json([
            'success' => $success,
        ], 200);
    }

    public function delete(Request $request)
    {
        $translation = Translation::where('translationable_type','App\Model\Brand')
        ->where('translationable_id',$request->id);
        $translation->delete();
        $brand = Brand::find($request->id);
        ImageManager::delete('/brand/' . $brand['image']);
        $brand->delete();
        return response()->json();
    }
}
