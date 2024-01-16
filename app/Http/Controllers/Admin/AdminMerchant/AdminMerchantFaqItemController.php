<?php

namespace App\Http\Controllers\Admin\AdminMerchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\StoreMerchantFaqItemRequest;
use App\Models\Merchant\MagMerchantFaqItem;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMerchantFaqItemController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $merchantFaqItem = MagMerchantFaqItem::where('merchant_id', $this->merchant_id);
        if ($request->only('search') && $request->only('col')) {
            $merchantFaqItem = $merchantFaqItem->where($request->get('col'), 'like', '%' . $request->get('search') . '%');
        }
        if ($request->only('sort')) {
            $merchantFaqItem = $merchantFaqItem->orderBy($request->get('sort'), $request->get('dir'));
        } else {
            $merchantFaqItem = $merchantFaqItem->orderBy('id', 'ASC');
        }
        $merchantFaqItem = $merchantFaqItem->paginate(env('PER_PAGE_ADMIN', 15));

        $response = [
            'success' => true,
            'data' => $merchantFaqItem,
            'message' => 'index MagMerchantFaqItem success'
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @param StoreMerchantFaqItemRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StoreMerchantFaqItemRequest $request, $id): JsonResponse
    {
        try {
            $formData = $request->all();
            MagMerchantFaqItem::where('id', $id)->where('merchant_id',  $this->merchant_id)
                ->update($formData);
            $response = [
                'success' => true,
                'data' => MagMerchantFaqItem::find($id),
                'message' => 'update MagMerchantFaqItem success',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param StoreMerchantFaqItemRequest $request
     * @return JsonResponse
     */
    public function store(StoreMerchantFaqItemRequest $request): JsonResponse
    {
        try {
            $formData = $request->all();
            $formData['merchant_id'] = $this->merchant_id;
            $merchantFaqItem = MagMerchantFaqItem::create($formData);

            $response = [
                'success' => true,
                'data' => $merchantFaqItem,
                'message' => 'MagMerchantFaqItem store success',
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
                $delete = MagMerchantFaqItem::whereIn('id', $formData['id'])->where('merchant_id', $this->merchant_id)
                    ->delete();
            else
                $delete = MagMerchantFaqItem::where('id', $formData['id'])->where('merchant_id', $this->merchant_id)
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
