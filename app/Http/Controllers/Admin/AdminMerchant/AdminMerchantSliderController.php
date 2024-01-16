<?php

namespace App\Http\Controllers\Admin\AdminMerchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\StoreMerchantSliderRequest;
use App\Models\Merchant\MagMerchantSlider;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMerchantSliderController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $merchantSlider = MagMerchantSlider::where('merchant_id', $this->merchant_id);
        if ($request->only('search') && $request->only('col')) {
            $merchantSlider = $merchantSlider->where($request->get('col'), 'like', '%' . $request->get('search') . '%');
        }
        if ($request->only('sort')) {
            $merchantSlider = $merchantSlider->orderBy($request->get('sort'), $request->get('dir'));
        } else {
            $merchantSlider = $merchantSlider->orderBy('id', 'ASC');
        }
        $merchantSlider = $merchantSlider->paginate(env('PER_PAGE_ADMIN', 15));

        $response = [
            'success' => true,
            'data' => $merchantSlider,
            'message' => 'index MagMerchantSlider success'
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @param StoreMerchantSliderRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StoreMerchantSliderRequest $request, $id): JsonResponse
    {
        try {
            $formData = $request->all();
            MagMerchantSlider::where('id', $id)->where('merchant_id',  $this->merchant_id)
                ->update($formData);
            $response = [
                'success' => true,
                'data' => MagMerchantSlider::find($id),
                'message' => 'update MagMerchantSlider success',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param StoreMerchantSliderRequest $request
     * @return JsonResponse
     */
    public function store(StoreMerchantSliderRequest $request): JsonResponse
    {
        try {
            $formData = $request->all();
            $formData['merchant_id'] = $this->merchant_id;
            $merchantSlider = MagMerchantSlider::create($formData);

            $response = [
                'success' => true,
                'data' => $merchantSlider,
                'message' => 'MagMerchantSlider store success',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        try {
            $formData = $request->all();

            if (\is_array($formData['id']))
                $delete = MagMerchantSlider::whereIn('id', $formData['id'])->where('merchant_id', $this->merchant_id)
                    ->delete();
            else
                $delete = MagMerchantSlider::where('id', $formData['id'])->where('merchant_id', $this->merchant_id)
                    ->delete();

            $response = [
                'success' => $delete ? true : false,
                'message' => $delete ? 'Deleted' : 'Not Found'
            ];

            return response()->json($response, Response::HTTP_OK);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
