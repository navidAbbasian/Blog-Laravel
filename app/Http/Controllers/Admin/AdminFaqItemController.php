<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFaqItemRequest;
use App\Models\FaqItem;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminFaqItemController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $faq_item = FaqItem::query();
        if ($request->only('search') && $request->only('col')) {
            $faq_item = $faq_item->where($request->get('col'), 'like', '%' . $request->get('search') . '%');
        }
        if ($request->only('sort')) {
            $faq_item = $faq_item->orderBy($request->get('sort'), $request->get('dir'));
        } else {
            $faq_item = $faq_item->orderBy('id', 'ASC');
        }
        $faq_item = $faq_item->paginate(env('PER_PAGE_ADMIN', 15));

        $response = [
            'success' => true,
            'data' => $faq_item,
            'message' => 'index FaqItem success'
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @param StoreFaqItemRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StoreFaqItemRequest $request, $id): JsonResponse
    {
        try {
            $formData = $request->all();
            FaqItem::where('id', $id)
                ->update($formData);
            $response = [
                'success' => true,
                'data' => FaqItem::find($id),
                'message' => 'update FaqItem success',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param StoreFaqItemRequest $request
     * @return JsonResponse
     */
    public function store(StoreFaqItemRequest $request): JsonResponse
    {
        try {
            $formData = $request->all();
            $faq_item = FaqItem::create($formData);

            $response = [
                'success' => true,
                'data' => $faq_item,
                'message' => 'FaqItem store success',
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
                $delete = FaqItem::whereIn('id', $formData['id'])
                    ->delete();
            else
                $delete = FaqItem::where('id', $formData['id'])
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
