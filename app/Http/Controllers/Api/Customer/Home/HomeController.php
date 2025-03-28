<?php

namespace App\Http\Controllers\Api\Customer\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Customer\BookmarkListRequest;
use App\Http\Requests\Api\Customer\BookmarkRequest;
use App\Http\Requests\Api\Customer\BusinessDetailRequest;
use App\Http\Requests\Api\Customer\MostPopularBusinessRequest;
use App\Http\Requests\Api\Customer\NearByMeRequest;
use App\Http\Requests\Api\Customer\RecentViewDetailRequest;
use App\Http\Requests\Api\Customer\RecentViewRequest;
use App\Http\Requests\Api\Customer\SearchRequest;
use App\Http\Requests\Api\Customer\ServiceBusinessRequest;
use App\Http\Resources\Api\Customer\Home\BusinessDetailsResource;
use App\Http\Resources\Api\Customer\Home\BusinessListResource;
use App\Http\Resources\Api\Customer\Home\BusinessResource;
use App\Http\Resources\Api\Customer\Home\OfferResource;
use App\Http\Resources\Api\Customer\Home\ServiceListResource;
use App\Models\BusinessDetail;
use Illuminate\Http\Request;
use App\Services\Api\HomeService;
use Exception;
use PhpParser\Builder\FunctionLike;

class HomeController extends Controller
{
    //
    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function storeRecentView(RecentViewRequest $request){

        try{
            $reRecentView = $this->homeService->storeRecentView($request);
            return success([], trans('messages.recent_view_add'), config('code.SUCCESS_CODE'));
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function getRecentViewList(RecentViewDetailRequest $request) {

        try {

            $businessData =  $this->homeService->getRecentViewList($request);
            if($businessData){
                return success(
                    pagination(BusinessListResource::class, $businessData),
                    trans('messages.list', ['attribute' => 'Recent view']),
                    config('code.SUCCESS_CODE')
                );
            }
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function getServiceList(Request $request) {
        try {

            $businessData =  $this->homeService->getServiceList($request);
            if($businessData){
                return success(
                    pagination(ServiceListResource::class, $businessData),
                    trans('messages.list', ['attribute' => 'Service']),
                    config('code.SUCCESS_CODE')
                );
            }
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function getBusinessDetails(BusinessDetailRequest $request) {

        try{
            $businessDetails = BusinessDetail::find($request->business_id);
            return success(new BusinessDetailsResource($businessDetails),trans('messages.view',['attribute'=>'Business details']));
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function getServiceBusinessList(ServiceBusinessRequest $request) {

        try {

            $businessData =  $this->homeService->getServiceBusinessList($request);
            if($businessData){
                return success(
                    pagination(BusinessResource::class, $businessData),
                    trans('messages.list', ['attribute' => 'Recent view']),
                    config('code.SUCCESS_CODE')
                );
            }
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function getMostPopularBusinessList(MostPopularBusinessRequest $request) {
        try {

            $businessData =  $this->homeService->getMostPopularBusinessList($request);
            if($businessData){
                return success(
                    pagination(BusinessResource::class, $businessData),
                    trans('messages.list', ['attribute' => 'Recent view']),
                    config('code.SUCCESS_CODE')
                );
            }
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function storeBookmark(BookmarkRequest $request){
        try{
            $reRecentView = $this->homeService->storeBookmark($request);
            return success([], trans('messages.bookmark_add'), config('code.SUCCESS_CODE'));
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function getBookmarkList(BookmarkListRequest $request) {
        try {

            $businessData =  $this->homeService->getBookmarkList($request);
            if($businessData){
                return success(
                    pagination(BusinessListResource::class, $businessData),
                    trans('messages.list', ['attribute' => 'Bookmark']),
                    config('code.SUCCESS_CODE')
                );
            }
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function destroyBookmark(BookmarkRequest $request) {
        try{
            $reRecentView = $this->homeService->destroyBookmark($request);
            return success([], trans('messages.bookmark_remove'), config('code.SUCCESS_CODE'));
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function getSearchBusinessList(SearchRequest $request) {
        try {
            $searchResult = $this->homeService->getSearchBusinessList($request);
            if ($searchResult) {
                return success($searchResult, trans('messages.search_result'), config('code.SUCCESS_CODE'));
            } else {
                return fail([], trans('messages.not_found', ['attribute' => 'data   ']), config('code.NO_RECORD_CODE'));
            }
        } catch(Exception $e){
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function getOffersList(Request $request){
        try {

            $offersData =  $this->homeService->getOffersList($request);
            if($offersData){
                return success(
                    pagination(OfferResource::class, $offersData),
                    trans('messages.list', ['attribute' => 'Offers']),
                    config('code.SUCCESS_CODE')
                );
            }
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public Function getNearBymeList(NearByMeRequest $request){
        try {
            $nearBymeData =  $this->homeService->getNearBymeList($request);
            if($nearBymeData){
                return success(
                    pagination(BusinessResource::class, $nearBymeData),
                    trans('messages.list', ['attribute' => 'Near By Me']),
                    config('code.SUCCESS_CODE')
                );
            }
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }

    }
}
