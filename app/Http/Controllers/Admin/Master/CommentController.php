<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\CommentRequest;
use App\Services\Master\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private $service;

    public function __construct(
        CommentService $service
    )
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $url = $request->url();
        $param = str_replace($url, '', $request->fullUrl());

        $data['comments'] = $this->service->getCommentList($request);
        $data['no'] = $data['comments']->firstItem();
        $data['comments']->withPath(url()->current().$param);

        return view('backend.master.comments.index', compact('data'), [
            'title' => __('mod/master.comment.title'),
            'breadcrumbs' => [
                __('mod/master.mod_title') => 'javascript:;',
                __('mod/master.comment.title') => '',
            ]
        ]);
    }

    public function detail($id)
    {
        $data['comment'] = $this->service->find($id);
        $data['replies'] = $data['comment']->reply;

        return view('backend.master.comments.detail', compact('data'), [
            'title' => __('mod/master.comment.caption').' - '.__('mod/master.comment.reply'),
            'routeBack' => route('comment.index'),
            'breadcrumbs' => [
                __('mod/master.mod_title') => 'javascript:;',
                __('mod/master.comment.caption') => route('comment.index'),
                __('mod/master.comment.reply') => '',
            ]
        ]);
    }

    public function update(CommentRequest $request, $id)
    {
        $this->service->update($request, $id);

        return back()->with('success', __('alert.update_success', [
            'attribute' => __('mod/master.comment.caption')
        ]));
    }

    public function updateReply(CommentRequest $request, $id)
    {
        $this->service->updateReply($request, $id);

        return back()->with('success', __('alert.update_success', [
            'attribute' => __('mod/master.comment.caption')
        ]));
    }

    public function flags($id)
    {
        $this->service->flags($id);

        return back()->with('success', __('alert.update_success', [
            'attribute' => __('mod/master.comment.caption')
        ]));
    }

    public function flagsReply($id)
    {
        $this->service->flagsReply($id);

        return back()->with('success', __('alert.update_success', [
            'attribute' => __('mod/master.comment.caption')
        ]));
    }

    public function destroy($id)
    {
        $delete = $this->service->delete($id);

        if ($delete == true) {

            return response()->json([
                'success' => 1,
                'message' => ''
            ], 200);
            
        } else {

            return response()->json([
                'success' => 0,
                'message' => __('alert.delete_failed_used', [
                    'attribute' => __('mod/master.comment.caption')
                ])
            ], 200);
            
        }
    }

    public function destroyReply($id)
    {
        $this->service->deleteReply($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }
}
