<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Banner;
use App\Models\Post;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminPostController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $post = Post::query();
        if ($request->only('search') && $request->only('col')) {
            $post = $post->where($request->get('col'), 'like', '%' . $request->get('search') . '%');
        }
        if ($request->only('sort')) {
            $post = $post->orderBy($request->get('sort'), $request->get('dir'));
        } else {
            $post = $post->orderBy('id', 'ASC');
        }
        $post = $post->paginate(env('PER_PAGE_ADMIN', 15));

        $response = [
            'success' => true,
            'data' => $post,
            'message' => 'index Post success'
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @param StorePostRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StorePostRequest $request, $id): JsonResponse
    {
        try {
            $formData = $request->except(['tag_id','category_id','product_id']);
            $post = Post::where('id', $id)->first();
            $post->tags()->detach();
            $post->categories()->detach();
            $post->products()->detach();
            $post->tags()->attach($request->tag_id);
            $post->products()->attach($request->product_id);
            $post->categories()->attach($request->category_id);

            $post->update($formData);
            $response = [
                'success' => true,
                'data' => Post::find($id),
                'message' => 'update Post success',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param StorePostRequest $request
     * type->default 0 = post, 1 = video
     * @return JsonResponse
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        try {
            $formData = $request->except(['tag_id','category_id','product_id']);
            $post = Post::create($formData);
            $post->tags()->attach($request->tag_id);
            $post->categories()->attach($request->category_id);
            $post->products()->attach($request->product_id);

            $response = [
                'success' => true,
                'data' => $post,
                'message' => 'Post store success',
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
                $delete = Post::whereIn('id', $formData['id'])
                    ->delete();
            else
                $delete = Post::where('id', $formData['id'])
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
