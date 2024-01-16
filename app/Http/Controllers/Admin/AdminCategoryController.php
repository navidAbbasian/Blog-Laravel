<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Post;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminCategoryController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $category = Category::query();
        if ($request->only('search') && $request->only('col')) {
            $category = $category->where($request->get('col'), 'like', '%' . $request->get('search') . '%');
        }
        if ($request->only('sort')) {
            $category = $category->orderBy($request->get('sort'), $request->get('dir'));
        } else {
            $category = $category->orderBy('id', 'ASC');
        }
        $category = $category->paginate(env('PER_PAGE_ADMIN', 15));

        $response = [
            'success' => true,
            'data' => $category,
            'message' => 'index Category success'
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @param StoreCategoryRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StoreCategoryRequest $request, $id): JsonResponse
    {
        try {
            $formData = $request->all();
            Category::where('id', $id)
                ->update($formData);
            $response = [
                'success' => true,
                'data' => Category::find($id),
                'message' => 'update Category success',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param StoreCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        try {
            $formData = $request->all();
            $category = Category::create($formData);

            $response = [
                'success' => true,
                'data' => $category,
                'message' => 'Category store success',
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
                $delete = Category::whereIn('id', $formData['id'])
                    ->delete();
            else
                $delete = Category::where('id', $formData['id'])
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
     * @param $slug
     * @param Request $request
     * @return JsonResponse
     */
    public function show($slug, Request $request): JsonResponse
    {
        $result = [
            'category' => $this->category($slug),
            'banner'=> $this->banner(),
            'post' => $this->sortPost($slug, $request)
        ];

        return response()->json($result, Response::HTTP_OK);
    }

    /**
     * @param $slug
     * @return mixed
     */
    private function category($slug)
    {
        return Category::where('slug', $slug)->first();
    }

    /**
     * @param $slug
     * @param Request $request
     * @return LengthAwarePaginator
     */
    private function sortPost($slug, Request $request): LengthAwarePaginator
    {
        $posts = Post::whereHas('categories', function ($q) use ($slug) {
            $q->where('slug', $slug);
        });
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

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function banner()
    {
        return Banner::all();
    }
}
