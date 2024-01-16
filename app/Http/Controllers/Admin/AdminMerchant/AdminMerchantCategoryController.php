<?php

namespace App\Http\Controllers\Admin\AdminMerchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\StoreMerchantCategoryRequest;
use App\Models\Merchant\MagMerchantCategory;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMerchantCategoryController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $merchantCategory = MagMerchantCategory::where('merchant_id', $this->merchant_id);
        if ($request->only('search') && $request->only('col')) {
            $merchantCategory = $merchantCategory->where($request->get('col'), 'like', '%' . $request->get('search') . '%');
        }
        if ($request->only('sort')) {
            $merchantCategory = $merchantCategory->orderBy($request->get('sort'), $request->get('dir'));
        } else {
            $merchantCategory = $merchantCategory->orderBy('id', 'ASC');
        }
        $merchantCategory = $merchantCategory->paginate(env('PER_PAGE_ADMIN', 15));

        $response = [
            'success' => true,
            'data' => $merchantCategory,
            'message' => 'index MagMerchantCategory success'
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @param StoreMerchantCategoryRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StoreMerchantCategoryRequest $request, $id): JsonResponse
    {
        try {
            $formData = $request->all();
            $merchantCategory = MagMerchantCategory::where('id', $id)
                ->where('merchant_id', $this->merchant_id)
                ->update($formData);
            if ($merchantCategory){
                $response = [
                    'success' => true,
                    'data' => MagMerchantCategory::find($id),
                    'message' => 'update MagMerchantCategory success',
                ];
                return response()->json($response, Response::HTTP_OK);
            }else{
                $response = [
                    'success' => false,
                    'message' => 'MagMerchantCategory not found',
                ];
                return response()->json($response, Response::HTTP_NOT_FOUND);
            }

        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param StoreMerchantCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreMerchantCategoryRequest $request): JsonResponse
    {
        try {
            $formData = $request->all();
            $formData['merchant_id'] = $this->merchant_id;
            $merchantCategory = MagMerchantCategory::create($formData);

            $response = [
                'success' => true,
                'data' => $merchantCategory,
                'message' => 'MagMerchantCategory store success',
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
                $delete = MagMerchantCategory::whereIn('id', $formData['id'])->where('merchant_id', $this->merchant_id)
                    ->delete();
            else
                $delete = MagMerchantCategory::where('id', $formData['id'])->where('merchant_id', $this->merchant_id)
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
