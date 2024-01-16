<?php

namespace App\Http\Controllers\Admin\AdminMerchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\StoreMerchantTextRequest;
use App\Models\Merchant\MagMerchantText;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMerchantTextController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $merchantText = MagMerchantText::where('merchant_id', $this->merchant_id);
        if ($request->only('search') && $request->only('col')) {
            $merchantText = $merchantText->where($request->get('col'), 'like', '%' . $request->get('search') . '%');
        }
        if ($request->only('sort')) {
            $merchantText = $merchantText->orderBy($request->get('sort'), $request->get('dir'));
        } else {
            $merchantText = $merchantText->orderBy('id', 'ASC');
        }
        $merchantText = $merchantText->paginate(env('PER_PAGE_ADMIN', 15));

        $response = [
            'success' => true,
            'data' => $merchantText,
            'message' => 'index MagMerchantText success'
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @param StoreMerchantTextRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StoreMerchantTextRequest $request, $id): JsonResponse
    {
        try {
            $formData = $request->all();
            MagMerchantText::where('id', $id)->where('merchant_id', $this->merchant_id)
                ->update($formData);
            $response = [
                'success' => true,
                'data' => MagMerchantText::find($id),
                'message' => 'update MagMerchantText success',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param StoreMerchantTextRequest $request
     * @return JsonResponse
     */
    public function store(StoreMerchantTextRequest $request): JsonResponse
    {
        try {
            $formData = $request->all();
            $formData['merchant_id'] = $this->merchant_id;
            $merchantText = MagMerchantText::create($formData);

            $response = [
                'success' => true,
                'data' => $merchantText,
                'message' => 'MagMerchantText store success',
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
                $delete = MagMerchantText::whereIn('id', $formData['id'])->where('merchant_id', $this->merchant_id)
                    ->delete();
            else
                $delete = MagMerchantText::where('id', $formData['id'])->where('merchant_id', $this->merchant_id)
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
