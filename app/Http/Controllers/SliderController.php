<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SliderController extends Controller
{
    /**
     * @param Request $request
     * send request for each position
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $result = [
            'sliders' => Slider::where('position', $request->get('position'))->get()
        ];
        return response()->json($result, Response::HTTP_OK);
    }
}
