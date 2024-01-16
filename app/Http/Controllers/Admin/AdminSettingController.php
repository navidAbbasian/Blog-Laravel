<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingRequest;
use App\Models\Setting;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminSettingController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $setting = Setting::query();
        if ($request->only('search') && $request->only('col')) {
            $setting = $setting->where($request->get('col'), 'like', '%' . $request->get('search') . '%');
        }
        if ($request->only('sort')) {
            $setting = $setting->orderBy($request->get('sort'), $request->get('dir'));
        } else {
            $setting = $setting->orderBy('id', 'ASC');
        }
        $setting = $setting->paginate(env('PER_PAGE_ADMIN', 15));

        $response = [
            'success' => true,
            'data' => $setting,
            'message' => 'index setting success'
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @param StoreSettingRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(StoreSettingRequest $request, $id): JsonResponse
    {
        try {
            $formData = $request->all();
            Setting::where('id', $id)
                ->update($formData);
            $response = [
                'success' => true,
                'data' => Setting::all(),
                'message' => 'update Slider success',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $e) {
            $message = $e->getMessage();
            return response()->json($message, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param StoreSettingRequest $request
     * @return JsonResponse
     */
    public function store(StoreSettingRequest $request): JsonResponse
    {
        try {
            $formData = $request->all();
            $setting = Setting::create($formData);

            $response = [
                'success' => true,
                'data' => $setting,
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
                $delete = Setting::whereIn('id', $formData['id'])
                    ->delete();
            else
                $delete = Setting::where('id', $formData['id'])
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
