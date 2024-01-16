<?php

namespace App\Http\Controllers\Admin\AdminMerchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\StoreMerchantPostRequest;
use App\Models\Merchant\MagMerchantPost;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMerchantPostController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $merchantPost = MagMerchantPost::where('merchant_id', $this->merchant_id);
        if ($request->only('search') && $request->only('col')) {
            $merchantPost = $merchantPost->where($request->get('col'), 'like', '%' . $request->get('search') . '%');
        }
        if ($request->only('sort')) {
            $merchantPost = $merchantPost->orderBy($request->get('sort'), $request->get('dir'));
        } else {
            $merchantPost = $merchantPost->orderBy('id', 'ASC');
        }
        $merchantPost = $merchantPost->paginate(env('PER_PAGE_ADMIN', 15));

        $response = [
            'success' => true,
            'data' => $merchantPost,
            'message' => 'index MagMerchantPost success'
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @param StoreMerchantPostRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StoreMerchantPostRequest $request, $id): JsonResponse
    {
        try {
            $formData = $request->except(['tag_id','category_id','product_id']);
            $merchantPost = MagMerchantPost::where('id', $id)->where('merchant_id', $this->merchant_id)->first();
            $merchantPost->tags()->detach();
            $merchantPost->categories()->detach();
            $merchantPost->products()->detach();
            $merchantPost->tags()->attach($request->tag_id);
            $merchantPost->products()->attach($request->product_id);
            $merchantPost->categories()->attach($request->category_id);

            $merchantPost->update($formData);
            if ($merchantPost->id) {
                $response = [
                    'success' => true,
                    'data' => MagMerchantPost::find($id),
                    'message' => 'update MagMerchantPost success',
                ];
                return response()->json($response, Response::HTTP_OK);
            } else {
                $response = [
                    'success' => false,
                    'message' => 'MagMerchantPost not found',
                ];
                return response()->json($response, Response::HTTP_NOT_FOUND);

            }

        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param StoreMerchantPostRequest $request
     * type->default 0 = post, 1 = video
     * @return JsonResponse
     */
    public function store(StoreMerchantPostRequest $request): JsonResponse
    {
        try {
            $formData = $request->except(['tag_id','category_id','product_id']);
            $formData['merchant_id'] = $this->merchant_id;
            $merchantPost = MagMerchantPost::create($formData);
            $merchantPost->tags()->attach($request->tag_id);
            $merchantPost->categories()->attach($request->category_id);
            $merchantPost->products()->attach($request->product_id);

            $response = [
                'success' => true,
                'data' => $merchantPost,
                'message' => 'MagMerchantPost store success',
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
                $delete = MagMerchantPost::whereIn('id', $formData['id'])->where('merchant_id', $this->merchant_id)
                    ->delete();
            else
                $delete = MagMerchantPost::where('id', $formData['id'])->where('merchant_id', $this->merchant_id)
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
