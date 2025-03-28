<?php

namespace App\Services\Api;

use App\Http\Resources\Api\Customer\Home\BusinessResource;
use App\Http\Resources\Api\Customer\Home\ServiceListResource;
use App\Models\BookMark;
use App\Models\BusinessDetail;
use App\Models\Offer;
use App\Models\RecentView;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class HomeService {

    public function storeRecentView($request) {
        $userId = $request->user_id;
        $deviceId = $request->device_id;
        $businessId = $request->business_id;


        RecentView::updateOrCreate(
            [
                'user_id'     => $userId,
                'device_id'   => $userId ? null : $deviceId, // If user exists, ignore device_id
                'business_id' => $businessId
            ],
    ['viewed_at' => now()]
        );

        return true;
    }

    public function getRecentViewList($request) {

        $perPage = $request->input('per_page', 10);
        return RecentView::
        when($request->user_id, function ($query) use ($request) {
            return $query->where('user_id', $request->user_id);
        })
        ->when(!$request->user_id && $request->device_id, function ($query) use ($request) {
            return $query->where('device_id', $request->device_id);
        })
        ->orderBy('viewed_at', 'desc')
        ->paginate($perPage)->withQueryString();
    }

    public function getServiceList($request) {
        $perPage = $request->input('per_page', 10);
        $services = Service::where('status',1)->orderBy('id','DESC')->paginate($perPage)->withQueryString();
        return $services;
    }

    public function getServiceBusinessList($request) {

        $perPage = $request->input('per_page', 10);
        $serviceId = $request->service_id;
        $businesses = BusinessDetail::where('status', 1)
        ->whereRaw("FIND_IN_SET(?, services)", [$serviceId])
        ->paginate($perPage)->withQueryString();

        return $businesses;
    }

    public function getMostPopularBusinessList($request) {
        $perPage = $request->input('per_page', 10);
        return BusinessDetail::where('city',$request->city)->where('status',1)->orderBy('id','DESC')->paginate($perPage)->withQueryString();

    }

    public function storeBookmark($request) {
        $userId = $request->user_id;
        $deviceId = $request->device_id;
        $businessId = $request->business_id;


        BookMark::updateOrCreate(
            [
                'user_id'     => $userId,
                'device_id'   => $userId ? null : $deviceId, // If user exists, ignore device_id
                'business_id' => $businessId
            ],
    ['updated_at' => now()]
        );

        return true;

    }

    public function getBookmarkList($request) {
        $perPage = $request->input('per_page', 10);
        return Bookmark::
        when($request->user_id, function ($query) use ($request) {
            return $query->where('user_id', $request->user_id);
        })
        ->when(!$request->user_id && $request->device_id, function ($query) use ($request) {
            return $query->where('device_id', $request->device_id);
        })
        ->orderBy('id', 'desc')
        ->paginate($perPage)->withQueryString();

    }

    public function destroyBookmark($request) {
        $userId = $request->user_id;
        $deviceId = $request->device_id;
        $businessId = $request->business_id;

        return Bookmark::
        when($request->user_id, function ($query) use ($request) {
            return $query->where('user_id', $request->user_id);
        })
        ->when(!$request->user_id && $request->device_id, function ($query) use ($request) {
            return $query->where('device_id', $request->device_id);
        })
        ->where('business_id', $businessId)->delete();
    }

    public function getSearchBusinessList($request) {
        $perPage = $request->input('per_page', 10);
        $query = $request->input('query');

        $serviceData = Service::when(!empty($query), function ($q) use ($query) {
            return $q->where('name', 'LIKE', "%$query%");
        })
        ->where('status', 1)
        ->orderBy('id', 'desc')
        ->get();

        $businessData =  BusinessDetail::where('business_name', 'LIKE', "%$query%")->orderBy('id', 'desc')
        ->paginate($perPage)->withQueryString();
        return [
            'services' => ServiceListResource::collection($serviceData),
            'businesses' => pagination(BusinessResource::class, $businessData)
        ];
    }

    public function getOffersList($request) {
        $perPage = $request->input('per_page', 10);
        $offers = Offer::where('status',1)->orderBy('id','DESC')->paginate($perPage)->withQueryString();
        return $offers;
    }

    public function getNearBymeList($request) {
        $perPage = $request->input('per_page', 10);
        $latitude = $request->input('lattitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius', 10); // Default radius is 10 km

        $businesses = BusinessDetail::selectRaw(
            "*, (6371 * acos(cos(radians(?))
            * cos(radians(lattitude))
            * cos(radians(longitude) - radians(?))
            + sin(radians(?))
            * sin(radians(lattitude)))) AS distance",
            [$latitude, $longitude, $latitude]
        )
        ->having('distance', '<=', $radius)
        ->where('status', 1)->where('is_verified',1)
        // Filter by radius
        ->orderBy('distance', 'asc') // Sort by nearest first
        ->paginate($perPage)->withQueryString();

        return $businesses;
    }
}
