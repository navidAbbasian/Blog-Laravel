<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSliderRequest;
use App\Models\Slider;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminSliderController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $slider = Slider::query();
        if ($request->only('search') && $request->only('col')) {
            $slider = $slider->where($request->get('col'), 'like', '%' . $request->get('search') . '%');
        }
        if ($request->only('sort')) {
            $slider = $slider->orderBy($request->get('sort'), $request->get('dir'));
        } else {
            $slider = $slider->orderBy('id', 'ASC');
        }
        $slider = $slider->paginate(env('PER_PAGE_ADMIN', 15));

        $response = [
            'success' => true,
            'data' => $slider,
            'message' => 'index Slider success'
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @param StoreSliderRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StoreSliderRequest $request, $id): JsonResponse
    {
        try {
            $formData = $request->all();
            Slider::where('id', $id)
                ->update($formData);
            $response = [
                'success' => true,
                'data' => Slider::find($id),
                'message' => 'update Slider success',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param StoreSliderRequest $request
     * @return JsonResponse
     */
    public function store(StoreSliderRequest $request): JsonResponse
    {
        try {
            $formData = $request->all();
            $slider = Slider::create($formData);

            $response = [
                'success' => true,
                'data' => $slider,
                'message' => 'Slider store success',
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
                $delete = Slider::whereIn('id', $formData['id'])
                    ->delete();
            else
                $delete = Slider::where('id', $formData['id'])
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
