<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BannerController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $result = [
            'banner' => $this->getBanner($request)
        ];
        return response()->json($result, Response::HTTP_OK);
    }

    /**
     * @param $request
     * send request for each page,row and col
     * @return mixed
     */
    private function getBanner($request)
    {
        return Banner::where('landing_page', $request->get('page'))->
                where('row', $request->get('row'))->
                    where('col', $request->get('col'))->get();
    }
}
