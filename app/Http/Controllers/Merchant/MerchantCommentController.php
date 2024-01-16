<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Merchant\MagMerchantComment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MerchantCommentController extends Controller
{
    public function sort(Request $request, $Post_id)
    {
        $result = [
            'sortComment' => $this->sortComment($request,  $Post_id)
        ];
        return response()->json($result, Response::HTTP_OK);
    }

    private function sortComment($request, $Post_id)
    {
        $sortComment = MagMerchantComment::where('post_id', $Post_id)->
            where('merchant_id',  $this->merchant_id);

        if ($request->get('sort') == 'newest') {
            $sortComment = $sortComment->orderBy('created_at', 'desc');
        }
        if ($request->get('sort') == 'oldest') {
            $sortComment = $sortComment->orderBy('created_at', 'asc');
        }
        if ($request->get('sort') == 'most-liked') {
            $sortComment = $sortComment->orderBy('like', 'desc');
        }
        return $sortComment->paginate('6');
    }
}
