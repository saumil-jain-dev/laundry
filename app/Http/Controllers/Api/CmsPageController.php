<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PageResource;
use App\Models\CmsPage;
use Exception;
use Illuminate\Http\Request;

class CmsPageController extends Controller
{
    //
    public function privacyPolicy(){
        try {

            $page = CmsPage::where('slug', 'privacy-policy')
            ->where('status', true)
            ->first();
            if (!$page) {
                return fail([], trans('messages.not_found', ['attribute' => 'Page']), config('code.NO_RECORD_CODE'));
            }
            return success(
                new PageResource($page),
                trans('messages.view', ['attribute' => 'Page']),
                config('code.SUCCESS_CODE')
            );
        }  catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }
}
