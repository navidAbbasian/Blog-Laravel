<?php

namespace App\Http\Controllers;

use App\Models\Text;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TextController extends Controller
{
    public function show(Request $request)
    {
        $result = [
            'text' => Text::where('landing_page', $request->get('page'))->get()
        ];
        return response()->json($result, Response::HTTP_OK);
    }
}
