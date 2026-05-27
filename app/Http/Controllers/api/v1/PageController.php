<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;

/**
 * Static legal/info pages (§6.6/6.8). Serves all six pages the website exposes,
 * each sourced from its BusinessSetting. GET v1/pages/{slug}
 */
class PageController extends Controller
{
    /**
     * slug => [setting type, is the value a {status,content} JSON wrapper?]
     */
    private const PAGES = [
        'about-us'             => ['about_us', false],
        'about_us'             => ['about_us', false],
        'privacy-policy'       => ['privacy_policy', false],
        'privacy_policy'       => ['privacy_policy', false],
        'terms-conditions'     => ['terms_condition', false],
        'terms_conditions'     => ['terms_condition', false],
        'instructions-for-use' => ['instructions_for_use', false],
        'return-policy'        => ['return-policy', true],
        'cancellation-policy'  => ['cancellation-policy', true],
    ];

    public function show($slug)
    {
        $slug = strtolower($slug);

        if (!isset(self::PAGES[$slug])) {
            return response()->json(['message' => translate('page_not_found')], 404);
        }

        [$type, $isWrapped] = self::PAGES[$slug];

        $value = Helpers::get_business_settings($type);

        if ($isWrapped) {
            // return-policy / cancellation-policy are stored as {status, content}
            $status  = is_array($value) ? ($value['status'] ?? false) : false;
            $content = is_array($value) ? ($value['content'] ?? '') : '';
            if (!$status) {
                return response()->json(['message' => translate('page_not_found')], 404);
            }
        } else {
            $content = is_string($value) ? $value : '';
        }

        return response()->json([
            'slug'    => $slug,
            'title'   => translate($type),
            'content' => $content,
        ], 200);
    }
}
