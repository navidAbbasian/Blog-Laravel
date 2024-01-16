<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Merchant\MagMerchantTag;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MerchantTagController extends Controller
{
    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $result = [
            'tag' => MagMerchantTag::where('id', $id)->where('merchant_id',  $this->merchant_id)->get()
        ];
        return response()->json($result, Response::HTTP_OK);
    }
}
