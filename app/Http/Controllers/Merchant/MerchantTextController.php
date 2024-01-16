<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Merchant\MagMerchantText;
use App\Models\Text;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MerchantTextController extends Controller
{
    public function show(Request $request)
    {
        $result = [
            'text' => MagMerchantText::where('landing_page', $request->get('page'))->
                where('merchant_id', $this->merchant_id)->get()
        ];
        return response()->json($result, Response::HTTP_OK);
    }
}
