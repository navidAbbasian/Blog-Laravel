<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminCommentController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $comment = Comment::query();
        if ($request->only('search') && $request->only('col')) {
            $comment = $comment->where($request->get('col'), 'like', '%' . $request->get('search') . '%');
        }
        if ($request->only('sort')) {
            $comment = $comment->orderBy($request->get('sort'), $request->get('dir'));
        } else {
            $comment = $comment->orderBy('id', 'ASC');
        }
        $comment = $comment->paginate(env('PER_PAGE_ADMIN', 15));

        $response = [
            'success' => true,
            'data' => $comment,
            'message' => 'index Comment success'
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @param StoreCommentRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StoreCommentRequest $request, $id): JsonResponse
    {
        try {
            $formData = $request->all();
            Comment::where('id', $id)
                ->update($formData);
            $response = [
                'success' => true,
                'data' => Comment::find($id),
                'message' => 'update Comment success',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param StoreCommentRequest $request
     * @return JsonResponse
     */
    public function store(StoreCommentRequest $request): JsonResponse
    {
        try {
            $formData = $request->all();
            $comment = Comment::create($formData);

            $response = [
                'success' => true,
                'data' => $comment,
                'message' => 'Comment store success',
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
                $delete = Comment::whereIn('id', $formData['id'])
                    ->delete();
            else
                $delete = Comment::where('id', $formData['id'])
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
        Comment::find($id)->increment('like');
    }

    /**
     * @param $id
     * @return void
     */
    public function dislike($id): void
    {
        Comment::find($id)->increment('dislike');
    }
}
