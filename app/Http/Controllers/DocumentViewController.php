<?php

namespace App\Http\Controllers;

use App\Services\ConfigurationService;
use App\Services\Document\DocumentCategoryService;
use App\Services\Document\DocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DocumentViewController extends Controller
{
    private $serviceCategory, $serviceDocument, $config;

    public function __construct(
        DocumentCategoryService $serviceCategory,
        DocumentService $serviceDocument,
        ConfigurationService $config
    )
    {
        $this->serviceCategory = $serviceCategory;
        $this->serviceDocument = $serviceDocument;
        $this->config = $config;
    }

    public function list(Request $request)
    {
        // return redirect()->route('home');
        
        $data['banner'] = $this->config->getFile('banner_default');
        $limit = $this->config->getValue('content_limit');
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $data['categories'] = $this->serviceCategory->getCategory($request, true, $limit);
        $data['documents'] = $this->serviceDocument->getDocument($request, true, $limit);

        return view('frontend.document.index', compact('data'), [
            'title' => __('common.document_caption'),
            'breadcrumbs' => [
                __('common.document_caption') => ''
            ],
        ]);
    }

    public function readCategory(Request $request)
    {
        $slug = $request->route('slugCategory');

        $data['read'] = $this->serviceCategory->findBySlug($slug);

        //check
        if (empty($slug)) {
            return abort(404);
        }

        if ($data['read']->publish == 0 || empty($data['read'])) {
            return redirect()->route('home');
        }

        if ($data['read']->public == 0 && auth()->guard()->check() == false) {
            return redirect()->route('home')->with('warning', 'You must login first');
        }

        $this->serviceCategory->recordViewer($data['read']->id);

        $limit = $this->config->getValue('content_limit');

        $data['childs'] = $data['read']->childPublish;
        $data['documents'] = $this->serviceDocument->getDocument($request, true, $limit, $data['read']->id);

        // meta data
        $data['meta_title'] = $data['read']->fieldLang('name');
        $data['meta_description'] = $this->config->getValue('meta_description');
        if (!empty($data['read']->fieldLang('description'))) {
            $data['meta_description'] = Str::limit(strip_tags($data['read']->fieldLang('description')), 155);
        }

        //images
        $data['creator'] = $data['read']->createBy->name;
        $data['banner'] = $data['read']->bannerSrc($data['read']);

        return view('frontend.document.category', compact('data'), [
            'title' => $data['read']->fieldLang('name'),
            'breadcrumbs' => [
                __('common.document_caption') => '',
                Str::limit($data['read']->fieldLang('name'), 15) => ''
            ],
        ]);
    }

    public function readDocument(Request $request)
    {
        $slug = $request->route('slugDocument');

        $data['read'] = $this->serviceDocument->findBySlug($slug);

        //check
        if (empty($slug)) {
            return abort(404);
        }

        if ($data['read']->publish == 0 || empty($data['read'])) {
            return redirect()->route('home');
        }

        if ($slug != $data['read']->slug) {
            return redirect()->route('document.read', ['slugCategory' => $data['read']->category->slug, 'slugDocument' => $data['read']->slug]);
        }

        if ($data['read']->public == 0 && auth()->guard()->check() == false) {
            return redirect()->route('home')->with('warning', 'You must login first');
        }

        $this->serviceDocument->recordViewer($data['read']->id);

        // meta data
        $data['meta_title'] = $data['read']->fieldLang('title');
        $data['meta_description'] = $this->config->getValue('meta_description');
        if (!empty($data['read']->fieldLang('description'))) {
            $data['meta_description'] = Str::limit(strip_tags($data['read']->fieldLang('description')), 155);
        }

        //images
        $data['creator'] = $data['read']->createBy->name;
        if (!empty($data['read']->cover['file_path'])) {
            $data['cover'] = $data['read']->coverSrc($data['read']);
        }

        return view('frontend.document.document', compact('data'), [
            'title' => $data['read']->fieldLang('title'),
            'breadcrumbs' => [
                __('common.document_caption') => '',
                Str::limit($data['read']->category->fieldLang('name'), 15) => route('document.category.read', ['slugCategory' => $data['read']->category->slug]),
                Str::limit($data['read']->fieldLang('title'), 15) => ''
            ],
        ]);
    }

    public function download($id)
    {
        $document = $this->serviceDocument->find($id);
        
        if ($document->from == 1) {
            $file = $document->document_url;
            $respon = $file;
        } else {
            $file = config('custom.files.edocman.path').$document->file;
            $respon = response()->download(storage_path('app/'.$file));
        }

        $this->serviceDocument->recordDownload($id);

        return $respon;
    }
}
