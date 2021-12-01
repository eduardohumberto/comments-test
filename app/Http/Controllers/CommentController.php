<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListCommentsRequest;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function show()
    {
        return view('app');;
    }

    public function store(StoreCommentRequest $request)
    {
        $validated = $request->validated();
        $comment = Comment::create($validated);

        return response($comment, 200);
    }

    public function index(ListCommentsRequest $request) {
        return Comment::withCount('comments')
            ->when($request->get('comment_id'),function ($query, $comment_id) {
                return $query->where('comment_id', $comment_id);
            })
            ->when(!$request->get('comment_id'),function ($query, $comment_id) {
                return $query->whereNull('comment_id');
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(config('comments.items_per_page'));
    }
}
