<?php

namespace App\Http\Controllers\Admin\AdminMerchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\StoreMerchantFaqRequest;
use App\Models\Merchant\MagMerchantFaq;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMerchantFaqController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $merchantFaq = MagMerchantFaq::where('merchant_id', $this->merchant_id);
        if ($request->only('search') && $request->only('col')) {
            $merchantFaq = $merchantFaq->where($request->get('col'), 'like', '%' . $request->get('search') . '%');
        }
        if ($request->only('sort')) {
            $merchantFaq = $merchantFaq->orderBy($request->get('sort'), $request->get('dir'));
        } else {
            $merchantFaq = $merchantFaq->orderBy('id', 'ASC');
        }
        $merchantFaq = $merchantFaq->paginate(env('PER_PAGE_ADMIN', 15));

        $response = [
            'success' => true,
            'data' => $merchantFaq,
            'message' => 'index MagMerchantFaq success'
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @param StoreMerchantFaqRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StoreMerchantFaqRequest $request, $id): JsonResponse
    {
        try {
            $formData = $request->all();
            MagMerchantFaq::where('id', $id)->where('merchant_id', $this->merchant_id)
                ->update($formData);
            $response = [
                'success' => true,
                'data' => MagMerchantFaq::find($id),
                'message' => 'update MagMerchantFaq success',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param StoreMerchantFaqRequest $request
     * @return JsonResponse
     */
    public function store(StoreMerchantFaqRequest $request): JsonResponse
    {
        try {
            $formData = $request->all();
            $formData['merchant_id'] = $this->merchant_id;
            $merchantFaq = MagMerchantFaq::create($formData);

            $response = [
                'success' => true,
                'data' => $merchantFaq,
                'message' => 'MagMerchantFaq store success',
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
                $delete = MagMerchantFaq::whereIn('id', $formData['id'])->where('merchant_id', $this->merchant_id)
                    ->delete();
            else
                $delete = MagMerchantFaq::where('id', $formData['id'])->where('merchant_id', $this->merchant_id)
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
