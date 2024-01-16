<?php

namespace App\Http\Controllers\Admin\AdminMerchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\StoreMerchantPageRequest;
use App\Models\Merchant\MagMerchantPage;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMerchantPageController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $merchantPage = MagMerchantPage::where('merchant_id', $this->merchant_id);
        if ($request->only('search') && $request->only('col')) {
            $merchantPage = $merchantPage->where($request->get('col'), 'like', '%' . $request->get('search') . '%');
        }
        if ($request->only('sort')) {
            $merchantPage = $merchantPage->orderBy($request->get('sort'), $request->get('dir'));
        } else {
            $merchantPage = $merchantPage->orderBy('id', 'ASC');
        }
        $merchantPage = $merchantPage->paginate(env('PER_PAGE_ADMIN', 15));

        $response = [
            'success' => true,
            'data' => $merchantPage,
            'message' => 'index MagMerchantPage success'
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @param StoreMerchantPageRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StoreMerchantPageRequest $request, $id): JsonResponse
    {
        try {
            $formData = $request->all();
            MagMerchantPage::where('id', $id)->where('merchant_id',$this->merchant_id)
                ->update($formData);
            $response = [
                'success' => true,
                'data' => MagMerchantPage::find($id),
                'message' => 'update MagMerchantPage success',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param StoreMerchantPageRequest $request
     * @return JsonResponse
     */
    public function store(StoreMerchantPageRequest $request): JsonResponse
    {
        try {
            $formData = $request->all();
            $formData['merchant_id'] = $this->merchant_id;
            $merchantPage = MagMerchantPage::create($formData);

            $response = [
                'success' => true,
                'data' => $merchantPage,
                'message' => 'MagMerchantPage store success',
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
                $delete = MagMerchantPage::whereIn('id', $formData['id'])->where('merchant_id', $this->merchant_id)
                    ->delete();
            else
                $delete = MagMerchantPage::where('id', $formData['id'])->where('merchant_id', $this->merchant_id)
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
