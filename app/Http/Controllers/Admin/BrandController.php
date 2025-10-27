<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\Model\Admin;
use App\Model\Brand;
use App\Model\Category;
use App\CPU\ImageManager;
use App\Model\Translation;
use Illuminate\Http\Request;
use App\Exports\BrandListExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Cache;

class BrandController extends Controller
{
    public function add_new()
    {
        $br = Brand::latest()->paginate(Helpers::pagination_limit());
        $categories = Category::where('category_type', 'vehicles')->get();

        return view('admin-views.brand.add-new', compact('br', 'categories'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:brands,name',
        ]);

        $brand = new Brand;
        $brand->name = $request->name;
        $brand->image = ImageManager::upload('brand/', 'webp', $request->file('image'), 'def.jpg');
        $brand->status = 1;
        $brand->save();

        $brand->categories()->attach($request->categories);

        Cache::forget('active_brands');
        Cache::forget('brands');

        Toastr::success(translate('brand_added_successfully'));
        return redirect()->route('admin.brand.list');
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

        $br = Brand::withCount('brandAllAds')
            ->with('brandAllAds')
            ->when($request['search'], function ($q) use($request){
                $key = explode(' ', $request['search']);
                foreach ($key as $value) {
                    $q->Where('name', 'like', "%{$value}%")
                      ->orWhere('id', $value);
                }
            })
            ->latest()->paginate(Helpers::pagination_limit())->appends($query_param);

        return view('admin-views.brand.list', compact('br','search'));
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
        $b = Brand::where(['id' => $id])->withoutGlobalScopes()->first();
        $categories = Category::where('category_type', 'vehicles')->get();

        $brandCategoriesIds = $b['categories']->pluck('id')->toArray();

        return view('admin-views.brand.edit', compact('b', 'categories', 'brandCategoriesIds'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:brands,name,'.$id,
        ]);

        $brand = Brand::find($id);
        $brand->name = $request->name;
        if ($request->has('image')) {
            $brand->image = ImageManager::update('brand/', $brand['image'], 'webp', $request->file('image'));
        }

        $brand->categories()->sync($request['categories']);
        $brand->save();

        Cache::forget('active_brands');
        Cache::forget('brands');

        Toastr::success(translate('brand_updated_successfully'));
        return redirect()->route('admin.brand.list');
    }

    public function status_update(Request $request)
    {
        $brand = Brand::find($request['id']);
        $brand->status = $request['status'] ?? 0;

        if($brand->save()){
            $success = 1;
        }else{
            $success = 0;
        }

        Cache::forget('active_brands');
        Cache::forget('brands');

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

        Cache::forget('active_brands');
        Cache::forget('brands');

        return response()->json();
    }
}
