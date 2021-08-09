<?php

namespace App\Services\Master;

use App\Models\Master\Comments\Comment;
use App\Models\Master\Comments\CommentReply;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    private $model, $modelReply;

    public function __construct(
        Comment $model,
        CommentReply $modelReply
    )
    {
        $this->model = $model;
        $this->modelReply = $modelReply;
    }

    public function getCommentList($request)
    {
        $query = $this->model->query();

        $query->when($request, function ($query, $f) {
            if ($f->f != '') {
                $query->where('flags', $f->f);
            }
        })->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('name', 'like', '%'.$q.'%');
            });
        });

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->orderBy('created_at', 'DESC')->paginate($limit);

        return $result;
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function findReply(int $id)
    {
        return $this->modelReply->findOrFail($id);
    }

    public function store($request, $model = null)
    {
        $comment = new Comment;
        $comment->user_id = Auth::user()->id;
        $comment->comment = $request->comment;
        if ($model != null) {
            $comment->commentable()->associate($model);
        }
        $comment->save();

        return $comment;
    }

    public function storeReply($request, int $commentId)
    {
        $comment = new Comment;
        $comment->comment_id = $commentId;
        $comment->user_id = Auth::user()->id;
        $comment->comment = $request->comment;
        $comment->save();

        return $comment;
    }

    public function update($request, int $id)
    {
        $comment = $this->find($id);
        $comment->comment = $request->comment;
        $comment->save();

        return $comment;
    }

    public function updateReply($request, int $id)
    {
        $comment = $this->findReply($id);
        $comment->comment = $request->comment;
        $comment->save();

        return $comment;
    }

    public function flags(int $id)
    {
        $comment = $this->find($id);
        $comment->flags = !$comment->flags;
        $comment->save();

        return $comment;
    }

    public function flagsReply(int $id)
    {
        $commentReply = $this->findReply($id);
        $commentReply->flags = !$commentReply->flags;
        $commentReply->save();

        return $commentReply;
    }

    public function delete(int $id)
    {
        $comment = $this->find($id);

        $reply = $comment->reply->count();
        
        if ($reply == 0) {

            $comment->delete();
            return true;

        } else {
            return false;
        }
    }

    public function deleteReply(int $id)
    {
        $commentReply = $this->findReply($id);
        $commentReply->delete();

        return true;
    }
}