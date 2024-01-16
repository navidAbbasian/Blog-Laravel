<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Merchant\MagMerchantBanner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MerchantBannerController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $result = [
            'banner' => $this->getBanner($request)
        ];
        return response()->json($result, Response::HTTP_OK);
    }

    /**
     * @param $request
     * send request for each page,row and col
     * @return mixed
     */
    private function getBanner($request): mixed
    {
        return MagMerchantBanner::where('landing_page', $request->get('page'))->
                where('row', $request->get('row'))->
                    where('col', $request->get('col'))->where('merchant_id', $this->merchant_id)->get();
    }
}
