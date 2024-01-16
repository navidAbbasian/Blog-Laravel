<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Symfony\Component\HttpFoundation\Response;

class FaqController extends Controller
{
    public function index()
    {
        $result = [
            'faq' => Faq::with('faqsItem')->first()
        ];
        return response()->json($result, Response::HTTP_OK);
    }
}
