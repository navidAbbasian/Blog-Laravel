<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TagController extends Controller
{
    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $result = [
            'tag' => Tag::where('id', $id)->get()
        ];
        return response()->json($result, Response::HTTP_OK);
    }
}
