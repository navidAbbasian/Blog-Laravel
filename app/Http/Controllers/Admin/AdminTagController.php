<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Models\Banner;
use App\Models\Post;
use App\Models\Tag;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminTagController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $tag = Tag::query();
        if ($request->only('search') && $request->only('col')) {
            $tag = $tag->where($request->get('col'), 'like', '%' . $request->get('search') . '%');
        }
        if ($request->only('sort')) {
            $tag = $tag->orderBy($request->get('sort'), $request->get('dir'));
        } else {
            $tag = $tag->orderBy('id', 'ASC');
        }
        $tag = $tag->paginate(env('PER_PAGE_ADMIN', 15));

        $response = [
            'success' => true,
            'data' => $tag,
            'message' => 'index Tag success'
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @param StoreTagRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StoreTagRequest $request, $id): JsonResponse
    {
        try {
            $formData = $request->all();
            Tag::where('id', $id)
                ->update($formData);
            $response = [
                'success' => true,
                'data' => Tag::find($id),
                'message' => 'update Tag success',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param StoreTagRequest $request
     * @return JsonResponse
     */
    public function store(StoreTagRequest $request): JsonResponse
    {
        try {
            $formData = $request->all();
            $tag = Tag::create($formData);

            $response = [
                'success' => true,
                'data' => $tag,
                'message' => 'Tag store success',
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
                $delete = Tag::whereIn('id', $formData['id'])
                    ->delete();
            else
                $delete = Tag::where('id', $formData['id'])
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
            'tag' => $this->tag($slug),
            'banner'=> $this->banner(),
            'post' => $this->sortPost($slug, $request)
        ];

        return response()->json($result, Response::HTTP_OK);
    }

    /**
     * @param $slug
     * @return mixed
     */
    private function tag($slug)
    {
        return Tag::where('slug', $slug)->first();
    }

    /**
     * @param $slug
     * @param Request $request
     * @return LengthAwarePaginator
     */


    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function banner()
    {
        return Banner::all();
    }
}
