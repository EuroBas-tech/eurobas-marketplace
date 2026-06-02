<?php

namespace App\Http\Controllers\Web;

use App\Model\SellerReview;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function App\CPU\translate;

/**
 * Milestone 3 — Seller Rating System (web).
 */
class SellerReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('customer');
    }

    public function store(Request $request)
    {
        $request->validate([
            'seller_id' => 'required|numeric',
            'rating'    => 'required|integer|min:1|max:5',
            'comment'   => 'nullable|string|max:2000',
        ]);

        $me = auth('customer')->id();

        if ($me == $request->seller_id) {
            return response()->json(['error_message' => translate('you_can_not_review_yourself')]);
        }

        SellerReview::updateOrCreate(
            ['seller_id' => $request->seller_id, 'customer_id' => $me],
            ['rating' => $request->rating, 'comment' => $request->comment, 'status' => 1]
        );

        $summary = SellerReview::summaryFor($request->seller_id);

        return response()->json([
            'message' => translate('thanks_for_your_review'),
            'avg'     => $summary['avg'],
            'count'   => $summary['count'],
        ]);
    }
}
