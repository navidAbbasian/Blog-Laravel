<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Merchant\MagMerchantPost;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MerchantPostController extends Controller
{
    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id, Request $request): JsonResponse
    {
        $result = [
            'posts' => MagMerchantPost::with('tags', 'categories:id,title', 'authors', 'products', 'comments')->
            where('id', $id)->where('merchant_id', $this->merchant_id)->first()
        ];
        return response()->json($result, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param $id
     * @return void
     */
    public function addFavorite(Request $request, $id): void
    {
        $favoritePost = MagMerchantPost::where('merchant_id', $this->merchant_id)->where('id', $id)->first();
        $favoritePost->favorites()->attach($request->customer_id);
    }

    public function addBookmark(Request $request, $id): void
    {
        $favoritePost = MagMerchantPost::where('merchant_id', $this->merchant_id)->where('id', $id)->first();
        $favoritePost->bookmarks()->attach($request->customer_id);
    }


    /**
     * @return mixed
     */
    public function latest(): mixed
    {
        return MagMerchantPost::where('merchant_id', $this->merchant_id)->orderBy('created_at', 'desc')->get();
    }

    /**
     * @param $id
     * @return void
     */
    public function share($id): void
    {
        {
            MagMerchantPost::where('id', $id)->where('merchant_id', $this->merchant_id)->increment('share');
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function sort($id, Request $request): JsonResponse
    {
        $result = [
            'sortListPosts' => $this->sortPost($id, $request)
        ];
        return response()->json($result, Response::HTTP_OK);
    }

    /**
     * @param $relationId
     * @param $request
     * @return mixed
     */
    private function sortPost($relationId, $request): mixed
    {
        if ($request->get('flag')) {
            $posts = MagMerchantPost::whereHas($request->get('flag'), function ($q) use ($relationId) {
                $q->where('id', $relationId)->where('merchant_id', $this->merchant_id);
            });
        } else {
            $posts = MagMerchantPost::where('id', $relationId)->where('merchant_id', $this->merchant_id);
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
