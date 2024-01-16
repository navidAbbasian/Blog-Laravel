<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Merchant\MagMerchantFaq;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MerchantFaqController extends Controller
{
    public function index()
    {
        $result = [
            'faq' => MagMerchantFaq::with('faqsItem')->
                where('merchant_id', $this->merchant_id)->first()
        ];
        return response()->json($result, Response::HTTP_OK);
    }
}
