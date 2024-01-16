<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTextRequest;
use App\Models\Text;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminTextController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $text = Text::query();
        if ($request->only('search') && $request->only('col')) {
            $text = $text->where($request->get('col'), 'like', '%' . $request->get('search') . '%');
        }
        if ($request->only('sort')) {
            $text = $text->orderBy($request->get('sort'), $request->get('dir'));
        } else {
            $text = $text->orderBy('id', 'ASC');
        }
        $text = $text->paginate(env('PER_PAGE_ADMIN', 15));

        $response = [
            'success' => true,
            'data' => $text,
            'message' => 'index Text success'
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @param StoreTextRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StoreTextRequest $request, $id): JsonResponse
    {
        try {
            $formData = $request->all();
            Text::where('id', $id)
                ->update($formData);
            $response = [
                'success' => true,
                'data' => Text::find($id),
                'message' => 'update Text success',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param StoreTextRequest $request
     * @return JsonResponse
     */
    public function store(StoreTextRequest $request): JsonResponse
    {
        try {
            $formData = $request->all();
            $text = Text::create($formData);

            $response = [
                'success' => true,
                'data' => $text,
                'message' => 'Text store success',
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
                $delete = Text::whereIn('id', $formData['id'])
                    ->delete();
            else
                $delete = Text::where('id', $formData['id'])
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
