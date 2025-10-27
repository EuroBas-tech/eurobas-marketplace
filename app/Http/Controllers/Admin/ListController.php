<?php

namespace App\Http\Controllers\Admin;

use App\Model\List;
use App\CPU\Helpers;
use App\Model\Admin;
use App\Model\Brand;
use App\CPU\ImageManager;
use App\Model\ListValue;
use App\Model\Translation;
use App\Model\ListAttribute;
use Illuminate\Http\Request;
use App\Exports\BrandListExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;

class ListController extends Controller
{
    public function add_new($type)
    {
        $list = ListAttribute::where('name', $type)->firstOrFail();

        $lists = ListAttribute::all();

        return view('admin-views.lists.add-new', compact('list', 'lists'));
    }

    public function store(Request $request)
    {   
        $request->validate([
            'attribute_id' => 'required|numeric',
            'value' => 'required',
        ]);

        $type = ListAttribute::findOrFail($request->attribute_id);

        // check if value already exist on this type
        $is_value_exist = $type->values()->where('value', $request->value)->first();
        
        if($is_value_exist){
            Toastr::error(translate('this_value_already_exist_on_this_type'));
            return back();
        }
        
        $type->values()->create([
            'list_attribute_id' => $request->attribute_id,
            'value' => $request->value,
            'priority' => $request->priority,
        ]);

        $languages = \App\Model\BusinessSetting::where('type', 'language')->first();
        $wordKey = $request->value;

        foreach (json_decode($languages['value'], true) as $data) {

            $local = $data['code'];
            $lang_path = base_path("resources/lang/{$local}/messages.php");
            $lang_array = file_exists($lang_path) ? include($lang_path) : [];
            $updated = false;

            // ✅ Check if the wordKey exists
            if (!array_key_exists($wordKey, $lang_array)) {
                $lang_array[$wordKey] = $wordKey;
                $updated = true;
            }
            if ($updated) {
                // Save only if changes were made
                $str = "<?php return " . var_export($lang_array, true) . ";";
                file_put_contents($lang_path, $str);

            }
            
        }

        Toastr::success(translate('list_value_added_successfully'));
        return back();
    }

    /**
     * Brand list show, search
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function list(Request $request, $type)
    {
        $list = ListAttribute::with('values')->where('name', $type)->firstOrFail();

        $search      = $request['search'];
        $query_param = $search ? ['search' => $request['search']] : '';

        return view('admin-views.lists.list', compact('list','search'));
    }

    public function edit($id)
    {
        $list_value = ListValue::with('list')->findOrFail($id);

        $lists = ListAttribute::all();

        return view('admin-views.lists.edit', compact('list_value', 'lists'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'attribute_id' => 'required|numeric',
            'value' => 'required',
        ]);

        $type = ListAttribute::findOrFail($request->attribute_id);

        // check if value already exist on this type
        $is_value_repeated = $type->values()
        ->where([
            ['value', $request->value],
            ['list_attribute_id', $request->attribute_id],
        ])
        ->where('id', '!=', $id)
        ->first();
        
        if($is_value_repeated){
            Toastr::error(translate('this_value_already_exist_on_this_type'));
            return back();
        }

        $value = ListValue::findOrFail($id);
        $value->value = $request->value;
        $value->priority = $request->priority;
        $value->save();

        $languages = \App\Model\BusinessSetting::where('type', 'language')->first();
        $wordKey = $request->value;

        foreach (json_decode($languages['value'], true) as $data) {

            $local = $data['code'];
            $lang_path = base_path("resources/lang/{$local}/messages.php");
            $lang_array = file_exists($lang_path) ? include($lang_path) : [];
            $updated = false;

            // ✅ Check if the wordKey exists
            if (!array_key_exists($wordKey, $lang_array)) {
                $lang_array[$wordKey] = $wordKey;
                $updated = true;
            }
            if ($updated) {
                // Save only if changes were made
                $str = "<?php return " . var_export($lang_array, true) . ";";
                file_put_contents($lang_path, $str);

            }
            
        }
    
        Toastr::success(translate('list_value_updated_successfully'));
        return back();
    }


    public function delete(Request $request)
    {
        $value = ListValue::findOrFail($request->id);
        $value->delete();

        return response()->json();
    }
}
