<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFaqRequest;
use App\Models\Faq;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminFaqController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $faq = Faq::query();
        if ($request->only('search') && $request->only('col')) {
            $faq = $faq->where($request->get('col'), 'like', '%' . $request->get('search') . '%');
        }
        if ($request->only('sort')) {
            $faq = $faq->orderBy($request->get('sort'), $request->get('dir'));
        } else {
            $faq = $faq->orderBy('id', 'ASC');
        }
        $faq = $faq->paginate(env('PER_PAGE_ADMIN', 15));

        $response = [
            'success' => true,
            'data' => $faq,
            'message' => 'index Faq success'
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @param StoreFaqRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StoreFaqRequest $request, $id): JsonResponse
    {
        try {
            $formData = $request->all();
            Faq::where('id', $id)
                ->update($formData);
            $response = [
                'success' => true,
                'data' => Faq::find($id),
                'message' => 'update Faq success',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param StoreFaqRequest $request
     * @return JsonResponse
     */
    public function store(StoreFaqRequest $request): JsonResponse
    {
        try {
            $formData = $request->all();
            $faq = Faq::create($formData);

            $response = [
                'success' => true,
                'data' => $faq,
                'message' => 'Faq store success',
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
                $delete = Faq::whereIn('id', $formData['id'])
                    ->delete();
            else
                $delete = Faq::where('id', $formData['id'])
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
