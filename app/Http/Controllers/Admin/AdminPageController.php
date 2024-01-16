<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePageRequest;
use App\Models\Page;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminPageController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $page = Page::query();
        if ($request->only('search') && $request->only('col')) {
            $page = $page->where($request->get('col'), 'like', '%' . $request->get('search') . '%');
        }
        if ($request->only('sort')) {
            $page = $page->orderBy($request->get('sort'), $request->get('dir'));
        } else {
            $page = $page->orderBy('id', 'ASC');
        }
        $page = $page->paginate(env('PER_PAGE_ADMIN', 15));

        $response = [
            'success' => true,
            'data' => $page,
            'message' => 'index Page success'
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @param StorePageRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StorePageRequest $request, $id): JsonResponse
    {
        try {
            $formData = $request->all();
            Page::where('id', $id)
                ->update($formData);
            $response = [
                'success' => true,
                'data' => Page::find($id),
                'message' => 'update Page success',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param StorePageRequest $request
     * @return JsonResponse
     */
    public function store(StorePageRequest $request): JsonResponse
    {
        try {
            $formData = $request->all();
            $page = Page::create($formData);

            $response = [
                'success' => true,
                'data' => $page,
                'message' => 'Page store success',
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
                $delete = Page::whereIn('id', $formData['id'])
                    ->delete();
            else
                $delete = Page::where('id', $formData['id'])
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
