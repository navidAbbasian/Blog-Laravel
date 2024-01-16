<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Merchant\MagMerchantCategory;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MerchantCategoryController extends Controller
{
    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $result = [
            'category' => MagMerchantCategory::where('id', $id)->
                where('merchant_id', $this->merchant_id)->get()
        ];
        return response()->json($result, Response::HTTP_OK);
    }
}
