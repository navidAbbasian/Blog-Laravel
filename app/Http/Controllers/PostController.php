<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $result = [
            'posts' => Post::with('tags', 'categories:id,title', 'authors','products', 'comments')->
                where('id', $id)->first()
        ];
        return response()->json($result, Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return void
     */
    public function share($id): void
    {
        {
            Post::where('id', $id)->increment('share');
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function sort($id, Request $request)
    {
        $result = [
            'sortListPosts' => $this->sortPost($id, $request)
        ];
        return response()->json($result, Response::HTTP_OK);
    }


    /**
     * @param $id
     * @param $request
     * flag set pivot table functions (tags,categories , ...)
     * @return LengthAwarePaginator
     */
    private function sortPost($id, $request): LengthAwarePaginator
    {
        if ($request->get('flag')) {
            $posts = Post::whereHas($request->get('flag'), function ($q) use ($id) {
                $q->where('id', $id);
            });
        } else {
            $posts = Post::where('id', $id);
        }


        if ($request->get('sort') == 'newest') {
            $posts = $posts->orderBy('created_at', 'desc');
        }
        if ($request->get('sort') == 'view') {
            $posts = $posts->orderBy('view', 'desc');
        }
        if ($request->get('sort') == 'chief_select') {
            $posts = $posts->orderBy('chief_select', 'desc');
        }
        return $posts->paginate('12');
    }
}
