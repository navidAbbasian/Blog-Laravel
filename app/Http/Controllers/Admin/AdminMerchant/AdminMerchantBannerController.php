<?php

namespace App\Http\Controllers\Admin\AdminMerchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\StoreMerchantBannerRequest;
use App\Models\Merchant\MagMerchantBanner;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMerchantBannerController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $merchantBanner = MagMerchantBanner::where('merchant_id', $this->merchant_id);
        if ($request->only('search') && $request->only('col')) {
            $merchantBanner = $merchantBanner->where($request->get('col'), 'like', '%' . $request->get('search') . '%');
        }
        if ($request->only('sort')) {
            $merchantBanner = $merchantBanner->orderBy($request->get('sort'), $request->get('dir'));
        } else {
            $merchantBanner = $merchantBanner->orderBy('id', 'ASC');
        }
        $merchantBanner = $merchantBanner->paginate(env('PER_PAGE_ADMIN', 15));

        $response = [
            'success' => true,
            'data' => $merchantBanner,
            'message' => 'index MagMerchantBanner success'
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @param StoreMerchantBannerRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StoreMerchantBannerRequest $request, $id): JsonResponse
    {
        try {
            $formData = $request->all();
            $merchantBanner = MagMerchantBanner
                ::where('id', $id)->where('merchant_id', $this->merchant_id)
                ->update($formData);
            if ($merchantBanner){
                $response = [
                    'success' => true,
                    'data' => MagMerchantBanner::find($id),
                    'message' => 'update MagMerchantBanner success',
                ];
                return response()->json($response, Response::HTTP_OK);
            } else{
                $response = [
                    'success' => false,
                    'message' => 'MagMerchantBanner not found',
                    ];
                return response()->json($response, Response::HTTP_NOT_FOUND);
            }


        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param StoreMerchantBannerRequest $request
     * @return JsonResponse
     */
    public function store(StoreMerchantBannerRequest $request): JsonResponse
    {
        try {
            $formData = $request->all();
            $formData['merchant_id'] = $this->merchant_id;
            $merchantBanner = MagMerchantBanner::create($formData);

            $response = [
                'success' => true,
                'data' => $merchantBanner,
                'message' => 'MagMerchantBanner store success',
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
                $delete = MagMerchantBanner
                    ::whereIn('id', $formData['id'])->
                        where('merchant_id', $this->merchant_id)
                            ->delete();
            else
                $delete = MagMerchantBanner
                    ::where('id', $formData['id'])->
                    where('merchant_id', $this->merchant_id)
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
