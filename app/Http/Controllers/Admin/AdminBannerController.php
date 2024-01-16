<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBannerRequest;
use App\Models\Banner;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminBannerController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $banner = Banner::query();
        if ($request->only('search') && $request->only('col')) {
            $banner = $banner->where($request->get('col'), 'like', '%' . $request->get('search') . '%');
        }
        if ($request->only('sort')) {
            $banner = $banner->orderBy($request->get('sort'), $request->get('dir'));
        } else {
            $banner = $banner->orderBy('id', 'ASC');
        }
        $banner = $banner->paginate(env('PER_PAGE_ADMIN', 15));

        $response = [
            'success' => true,
            'data' => $banner,
            'message' => 'index Banner success'
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @param StoreBannerRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StoreBannerRequest $request, $id): JsonResponse
    {
        try {
            $formData = $request->all();
            Banner::where('id', $id)
                ->update($formData);
            $response = [
                'success' => true,
                'data' => Banner::find($id),
                'message' => 'update Banner success',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param StoreBannerRequest $request
     * @return JsonResponse
     */
    public function store(StoreBannerRequest $request): JsonResponse
    {
        try {
            $formData = $request->all();
            $banner = Banner::create($formData);

            $response = [
                'success' => true,
                'data' => $banner,
                'message' => 'Banner store success',
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
                $delete = Banner::whereIn('id', $formData['id'])
                    ->delete();
            else
                $delete = Banner::where('id', $formData['id'])
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
