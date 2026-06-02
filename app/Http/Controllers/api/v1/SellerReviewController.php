<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\SellerReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function App\CPU\translate;

/**
 * Milestone 3 — Seller Rating System (API).
 */
class SellerReviewController extends Controller
{
    /** GET v1/users/{id}/reviews — public list of a seller's reviews + summary. */
    public function list(Request $request, $id)
    {
        $reviews = SellerReview::with(['customer' => fn($q) => $q->select('id', 'name', 'image')])
            ->where('seller_id', $id)
            ->where('status', 1)
            ->latest()
            ->paginate($request->input('limit', 10));

        $summary = SellerReview::summaryFor($id);

        return response()->json([
            'summary' => $summary,
            'reviews' => $reviews,
        ], 200);
    }

    /** POST v1/customer/seller-review — create/update the caller's review of a seller. */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'seller_id' => 'required|numeric',
            'rating'    => 'required|integer|min:1|max:5',
            'comment'   => 'nullable|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        $me = $request->user()->id;

        if ($me == $request->seller_id) {
            return response()->json(['message' => translate('you_can_not_review_yourself')], 422);
        }

        SellerReview::updateOrCreate(
            ['seller_id' => $request->seller_id, 'customer_id' => $me],
            ['rating' => $request->rating, 'comment' => $request->comment, 'status' => 1]
        );

        return response()->json([
            'message' => translate('thanks_for_your_review'),
            'summary' => SellerReview::summaryFor($request->seller_id),
        ], 200);
    }
}
