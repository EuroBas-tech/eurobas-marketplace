<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Model\Ad;
use App\Model\Brand;
use App\Model\VehicleModel;
use Illuminate\Http\Request;

/**
 * Brand / vehicle-model browsing (§6.3). Per-category and uncapped — used by the
 * cascading category → brand → model filter and post-ad flow. Mirrors the
 * website's all_brands / brand_details / model_ads.
 */
class BrandController extends Controller
{
    /**
     * GET v1/brands — all brands (optionally scoped to a category, optionally
     * searched). Each brand carries its category ids; pass with_models=1 to
     * embed each brand's vehicle models for a one-shot cascading dataset.
     */
    public function index(Request $request)
    {
        $brands = Brand::with('categories:id')
            ->when($request->filled('category_id'), fn($q) =>
                $q->whereHas('categories', fn($c) => $c->where('categories.id', $request->category_id)))
            ->when($request->filled('search'), fn($q) =>
                $q->where('name', 'LIKE', '%' . $request->search . '%'))
            ->orderBy('name', 'ASC')
            ->get();

        $withModels = $request->boolean('with_models');

        $models = $withModels
            ? VehicleModel::with('categories:id')->select('id', 'name', 'brand_id', 'category_id', 'status')->get()
            : collect();

        $data = $brands->map(function ($brand) use ($withModels, $models) {
            $row = [
                'id'         => $brand->id,
                'name'       => $brand->name,
                'image'      => $brand->image,
                'categories' => $brand->categories->pluck('id')->toArray(),
            ];
            if ($withModels) {
                $row['models'] = $models->where('brand_id', $brand->id)->map(fn($m) => [
                    'id'         => $m->id,
                    'name'       => $m->name,
                    'category_id'=> $m->category_id,
                    'categories' => $m->categories->pluck('id')->toArray(),
                ])->values();
            }
            return $row;
        });

        return response()->json(['brands' => $data], 200);
    }

    /**
     * GET v1/brands/{id} — a brand and its vehicle models (optionally scoped
     * to a category).
     */
    public function show(Request $request, $id)
    {
        $brand = Brand::with('categories:id')->find($id);
        if (!$brand) {
            return response()->json(['message' => translate('brand_not_found')], 404);
        }

        $models = VehicleModel::with('categories:id')
            ->where('brand_id', $brand->id)
            ->when($request->filled('category_id'), fn($q) =>
                $q->whereHas('categories', fn($c) => $c->where('categories.id', $request->category_id)))
            ->get()
            ->map(fn($m) => [
                'id'         => $m->id,
                'name'       => $m->name,
                'category_id'=> $m->category_id,
                'status'     => $m->status,
                'categories' => $m->categories->pluck('id')->toArray(),
            ]);

        return response()->json([
            'brand'  => [
                'id'         => $brand->id,
                'name'       => $brand->name,
                'image'      => $brand->image,
                'categories' => $brand->categories->pluck('id')->toArray(),
            ],
            'models' => $models,
        ], 200);
    }

    /**
     * GET v1/models/{id}/ads — active ads for a given vehicle model.
     */
    public function model_ads(Request $request, $id)
    {
        $ads = Ad::active()
            ->with(['category', 'brand', 'model', 'sponsor', 'user' => fn($q) => $q->select('id', 'name', 'image')])
            ->where('model_id', $id)
            ->latest()
            ->paginate($request->input('limit', 10));

        return response()->json($ads, 200);
    }
}
