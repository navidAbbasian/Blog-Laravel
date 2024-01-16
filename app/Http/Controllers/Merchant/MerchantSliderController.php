<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Merchant\MagMerchantSlider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MerchantSliderController extends Controller
{
    /**
     * @param Request $request
     * send request for each position
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $result = [
            'sliders' => MagMerchantSlider::where('position', $request->get('position'))->
                where('merchant_id', $this->merchant_id)->get()
        ];
        return response()->json($result, Response::HTTP_OK);
    }
}
