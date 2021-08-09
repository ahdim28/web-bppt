<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\MediaRequest;
use App\Services\Content\PostService;
use App\Services\Master\MediaService;
use App\Services\Page\PageService;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    private $service, $servicePage, $servicePost;

    public function __construct(
        MediaService $service,
        PageService $servicePage,
        PostService $servicePost
    )
    {
        $this->service = $service;
        $this->servicePage = $servicePage;
        $this->servicePost = $servicePost;
    }

    public function index(Request $request, $id, $module)
    {
        $data['module'] = $this->checkModule($id, $module);

        if ($module == 'post') {

            $data['routeStore'] = route('media.store', [
                'moduleId' => $request->segment(3),
                'moduleName' => $request->segment(4),
                'sectionId' => $request->get('sectionId'),
            ]);

            $data['routeBack'] = route($request->segment(4).'.index', 
                ['sectionId' => $request->get('sectionId')]);

        } else {

            $data['routeStore'] = route('media.store', [
                'moduleId' => $request->segment(3),
                'moduleName' => $request->segment(4),
            ]);

            $data['routeBack'] = route($request->segment(4).'.index');

        }

        return view('backend.master.medias.index', compact('data'), [
            'title' => __('mod/master.media.title'),
            'routeBack' => $data['routeBack'],
            'breadcrumbs' => [
                ucfirst($request->segment(4)) => $data['routeBack'],
                __('mod/master.media.title') => '',
            ]
        ]);
    }

    public function create(Request $request, $id, $module)
    {
        if ($module == 'post') {

            $data['routeStore'] = route('media.store', [
                'moduleId' => $request->segment(3),
                'moduleName' => $request->segment(4),
                'sectionId' => $request->get('sectionId'),
            ]);

            $data['routeBack'] = route('media.index', ['moduleId' => $id, 
                'moduleName' => $module, 
                'sectionId' => $request->get('sectionId')]);

        } else {

            $data['routeStore'] = route('media.store', [
                'moduleId' => $request->segment(3),
                'moduleName' => $request->segment(4),
            ]);

            $data['routeBack'] = route('media.index', ['moduleId' => $id, 
                'moduleName' => $module]);

        }

        return view('backend.master.medias.form', compact('data'), [
            'title' => __('lang.add_attr_new', [
                'attribute' => __('mod/master.media.caption')
            ]),
            'routeBack' => $data['routeBack'],
            'breadcrumbs' => [
                __('mod/master.media.caption') => $data['routeBack'],
                __('lang.add') => '',
            ]
        ]);
    }

    public function store(MediaRequest $request, $id, $module)
    {
        $model = $this->checkModule($id, $module);

        $this->service->store($request, $id, $model, $module);

        $redir = $this->redirectForm($request, $id, $module);
        return $redir->with('success', __('alert.create_success', [
            'attribute' => __('mod/master.media.caption')
        ]));
    }

    public function edit(Request $request, $moduleId, $module, $id)
    {
        $data['media'] = $this->service->find($id);

        if ($module == 'post') {

            $data['routeUpdate'] = route('media.update', [
                'moduleId' => $request->segment(3),
                'moduleName' => $request->segment(4),
                'id' => $id,
                'sectionId' => $request->get('sectionId'),
            ]);

            $data['routeBack'] = route('media.index', ['moduleId' => $moduleId, 
                'moduleName' => $module, 
                'sectionId' => $request->get('sectionId')]);

        } else {

            $data['routeUpdate'] = route('media.update', [
                'moduleId' => $request->segment(3),
                'moduleName' => $request->segment(4),
                'id' => $id,
            ]);

            $data['routeBack'] = route('media.index', ['moduleId' => $moduleId, 'moduleName' => $module]);

        }

        return view('backend.master.medias.form', compact('data'), [
            'title' => __('lang.edit_attr', [
                'attribute' => __('mod/master.media.caption')
            ]),
            'routeBack' => $data['routeBack'],
            'breadcrumbs' => [
                __('mod/master.template.caption') => $data['routeBack'],
                __('lang.edit') => '',
            ]
        ]);
    }

    public function update(MediaRequest $request, $moduleId, $module, $id)
    {
        $this->service->update($request, $id);

        $redir = $this->redirectForm($request, $moduleId, $module);
        return $redir->with('success', __('alert.update_success', [
            'attribute' => __('mod/master.media.caption')
        ]));
    }

    public function sort()
    {
        $i = 0;

        foreach ($_POST['datas'] as $value) {
            $i++;
            $this->service->sort($value, $i);
        }
    }

    public function destroy($moduleId, $module, $id)
    {
        $this->service->delete($id);

        return response()->json([
            'success' => 1,
            'message' => ''
        ], 200);
    }

    public function checkModule($id, $module)
    {
        if ($module == 'page') {
            $model = $this->servicePage->find($id);
        }

        if ($module == 'post') {
            $model = $this->servicePost->find($id);
        }

        return $model;
    }

    public function redirectForm($request, $id, $module)
    {
        $redir = redirect()->route('media.index', ['moduleId' => $id, 'moduleName' => $module, 
            'sectionId' => $request->get('sectionId')]);
        if ($request->action == 'back') {
            $redir = back();
        }

        return $redir;
    }
}
