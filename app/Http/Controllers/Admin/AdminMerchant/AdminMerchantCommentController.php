<?php

namespace App\Http\Controllers\Admin\AdminMerchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\StoreMerchantCommentRequest;
use App\Models\Merchant\MagMerchantComment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMerchantCommentController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $merchantComment = MagMerchantComment::where('merchant_id', $this->merchant_id);
        if ($request->only('search') && $request->only('col')) {
            $merchantComment = $merchantComment->where($request->get('col'), 'like', '%' . $request->get('search') . '%');
        }
        if ($request->only('sort')) {
            $merchantComment = $merchantComment->orderBy($request->get('sort'), $request->get('dir'));
        } else {
            $merchantComment = $merchantComment->orderBy('id', 'ASC');
        }
        $merchantComment = $merchantComment->paginate(env('PER_PAGE_ADMIN', 15));

        $response = [
            'success' => true,
            'data' => $merchantComment,
            'message' => 'index MagMerchantComment success'
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @param StoreMerchantCommentRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StoreMerchantCommentRequest $request, $id): JsonResponse
    {
        try {
            $formData = $request->all();
            $merchantComment = MagMerchantComment::where('id', $id)->where('merchant_id', $this->merchant_id)
                ->update($formData);
            if ($merchantComment) {
                $response = [
                    'success' => true,
                    'data' => MagMerchantComment::find($id),
                    'message' => 'update MagMerchantComment success',
                ];
                return response()->json($response, Response::HTTP_OK);
            } else {
                $response = [
                    'success' => false,
                    'message' => 'update MagMerchantComment success',
                ];
                return response()->json($response, Response::HTTP_NOT_FOUND);
            }

        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param StoreMerchantCommentRequest $request
     * @return JsonResponse
     */
    public function store(StoreMerchantCommentRequest $request): JsonResponse
    {
        try {
            $formData = $request->all();
            $formData['merchant_id'] = $this->merchant_id;
            $merchantComment = MagMerchantComment::create($formData);

            $response = [
                'success' => true,
                'data' => $merchantComment,
                'message' => 'MagMerchantComment store success',
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
                $delete = MagMerchantComment::whereIn('id', $formData['id'])->where('merchant_id', $this->merchant_id)
                    ->delete();
            else
                $delete = MagMerchantComment::where('id', $formData['id'])->where('merchant_id', $this->merchant_id)
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

    /**
     * @param $id
     * @return void
     */
    public function like($id): void
    {
        MagMerchantComment::find($id)->increment('like');
    }

    /**
     * @param $id
     * @return void
     */
    public function dislike($id): void
    {
        MagMerchantComment::find($id)->increment('dislike');
    }
}
