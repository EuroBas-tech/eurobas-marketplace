<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\CategoryType;
use Illuminate\Http\Request;
use function App\CPU\translate;

class CategoryTypeController extends Controller
{
    public function index()
    {
        $category_types = CategoryType::latest()->paginate(25);
        return view('admin-views.category-type.view', compact('category_types'));
    }

    public function fetch()
    {
        $category_types = CategoryType::latest()->paginate(25);
        return response()->json([
            'view' => view('admin-views.category-type._table', compact('category_types'))->render(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:category_types',
        ]);

        CategoryType::create([
            'name' => $request->name,
            'status' => 1,
        ]);

        return response()->json(['message' => translate('category_type_added_successfully')]);
    }

    public function edit($id)
    {
        $category_type = CategoryType::findOrFail($id);
        return view('admin-views.category-type.edit', compact('category_type'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:category_types,name,' . $id,
        ]);

        $category_type = CategoryType::findOrFail($id);
        $category_type->update([
            'name' => $request->name,
        ]);

        return response()->json(['message' => translate('category_type_updated_successfully')]);
    }

    public function delete(Request $request)
    {
        CategoryType::findOrFail($request->id)->delete();
        return response()->json(['message' => translate('category_type_deleted_successfully')]);
    }

    public function status(Request $request)
    {
        $category_type = CategoryType::findOrFail($request->id);
        $category_type->status = !$category_type->status;
        $category_type->save();
        return response()->json(['message' => translate('status_updated_successfully')]);
    }
}
