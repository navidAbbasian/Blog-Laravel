<?php

namespace App\Http\Controllers\Admin\AdminMerchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\StoreMerchantSettingRequest;
use App\Models\Merchant\MagMerchantSetting;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMerchantSettingController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $merchantSetting = MagMerchantSetting::where('merchant_id',  $this->merchant_id);
        if ($request->only('search') && $request->only('col')) {
            $merchantSetting = $merchantSetting->where($request->get('col'), 'like', '%' . $request->get('search') . '%');
        }
        if ($request->only('sort')) {
            $merchantSetting = $merchantSetting->orderBy($request->get('sort'), $request->get('dir'));
        } else {
            $merchantSetting = $merchantSetting->orderBy('id', 'ASC');
        }
        $merchantSetting = $merchantSetting->paginate(env('PER_PAGE_ADMIN', 15));

        $response = [
            'success' => true,
            'data' => $merchantSetting,
            'message' => 'index setting success'
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @param StoreMerchantSettingRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StoreMerchantSettingRequest $request, $id): JsonResponse
    {
        try {
            $formData = $request->all();
            MagMerchantSetting::where('id', $id)->where('merchant_id',  $this->merchant_id)
                ->update($formData);
            $response = [
                'success' => true,
                'data' => MagMerchantSetting::all(),
                'message' => 'update Slider success',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
