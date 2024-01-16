<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
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
        $comment = Comment::where('post_id',  $Post_id);

        if ($request->get('sort') == 'newest') {
            $comment = $comment->orderBy('created_at', 'desc');
        }
        if ($request->get('sort') == 'oldest') {
            $comment = $comment->orderBy('created_at', 'asc');
        }
        if ($request->get('sort') == 'most-liked') {
            $comment = $comment->orderBy('like', 'desc');
        }
        return $comment->paginate('6');
    }
}
