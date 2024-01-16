<?php

namespace App\Http\Controllers\Admin\AdminMerchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\StoreMerchantTagRequest;
use App\Models\Merchant\MagMerchantTag;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMerchantTagController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $merchantTag = MagMerchantTag::where('merchant_id', $this->merchant_id);
        if ($request->only('search') && $request->only('col')) {
            $merchantTag = $merchantTag->where($request->get('col'), 'like', '%' . $request->get('search') . '%');
        }
        if ($request->only('sort')) {
            $merchantTag = $merchantTag->orderBy($request->get('sort'), $request->get('dir'));
        } else {
            $merchantTag = $merchantTag->orderBy('id', 'ASC');
        }
        $merchantTag = $merchantTag->paginate(env('PER_PAGE_ADMIN', 15));

        $response = [
            'success' => true,
            'data' => $merchantTag,
            'message' => 'index MagMerchantTag success'
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @param StoreMerchantTagRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StoreMerchantTagRequest $request, $id): JsonResponse
    {
        try {
            $formData = $request->all();
            $merchantTag = MagMerchantTag::where('id', $id)->where('merchant_id', $this->merchant_id)
                ->update($formData);
            if ($merchantTag) {
                $response = [
                    'success' => true,
                    'data' => MagMerchantTag::find($id),
                    'message' => 'update MagMerchantTag success',
                ];
                return response()->json($response, Response::HTTP_OK);
            } else {
                $response = [
                    'success' => false,
                    'message' => 'MagMerchantTag not found',
                ];
                return response()->json($response, Response::HTTP_NOT_FOUND);
            }

        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param StoreMerchantTagRequest $request
     * @return JsonResponse
     */
    public function store(StoreMerchantTagRequest $request): JsonResponse
    {
        try {
            $formData = $request->all();
            $formData['merchant_id'] = $this->merchant_id;
            $merchantTag = MagMerchantTag::create($formData);

            $response = [
                'success' => true,
                'data' => $merchantTag,
                'message' => 'MagMerchantTag store success',
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
                $delete = MagMerchantTag::whereIn('id', $formData['id'])->where('merchant_id', $this->merchant_id)
                    ->delete();
            else
                $delete = MagMerchantTag::where('id', $formData['id'])->where('merchant_id', $this->merchant_id)
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
