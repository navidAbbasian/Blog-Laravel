<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $result = [
            'category' => Category::where('id', $id)->get()
        ];
        return response()->json($result, Response::HTTP_OK);
    }
}
