<?php

namespace App\Services\Api;

use App\Models\BusinessDetail;
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
}
