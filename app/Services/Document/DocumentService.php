<?php

namespace App\Services\Document;

use App\Models\Document\Document;
use App\Services\LanguageService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentService
{
    private $model, $lang;

    public function __construct(
        Document $model,
        LanguageService $lang
    )
    {
        $this->model = $model;
        $this->lang = $lang;
    }

    public function getDocumentList($request, int $categoryId)
    {
        $query = $this->model->query();

        $query->where('category_id', $categoryId);
        $query->when($request, function ($query, $req) {
            if ($req->s != '') {
                $query->where('publish', $req->s);
            }
            if ($req->p != '') {
                $query->where('public', $req->p);
            }
        })->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('title->'.App::getLocale(), 'like', '%'.$q.'%');
            });
        });

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->orderBy('position', 'ASC')->paginate($limit);

        return $result;
    }

    public function getDocument($request = null, $withPaginate = false, $limit = null, $categoryId = null)
    {
        $query = $this->model->query();

        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        $query->publish();
        if (Auth::guard()->check() == false) {
            $query->public();
        }

        if (!empty($request)) {
            $query->when($request->keyword, function ($query, $q) {
                $query->where(function ($query) use ($q) {
                    $query->where('name->'.App::getLocale(), 'like', '%'.$q.'%')
                        ->orWhere('description->'.App::getLocale(), 'like', '%'.$q.'%');;
                });
            });
        }

        $query->orderBy('created_at', 'DESC');
        if ($withPaginate == true) {
            $result = $query->paginate($limit);
        } else {
            if (!empty($limit)) {
                $result = $query->limit($limit)->get();
            } else {
                $result = $query->get();
            }
        }

        return $result;
    }

    public function count()
    {
        $query = $this->model->query();

        $query->publish();
        $result = $query->count();

        return $result;
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function findBySlug($slug)
    {
        $query = $this->model->query();

        $query->where('slug', $slug);
        $result = $query->first();

        return $result;
    }

    public function store($request, int $categoryId)
    {
        $document = new Document;
        $document->category_id = $categoryId;
        $document->from = (bool)$request->from;

        if ($request->from == 0) {
            
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = $file->getClientOriginalName();
                if (file_exists(storage_path('app/public/edocman/'.$fileName))) {
                    $fileName = Str::random(3).'-'.$file->getClientOriginalName();
                }

                Storage::put(config('custom.files.edocman.path').
                    $fileName, file_get_contents($file));

                $document->file = $fileName;
                $document->file_type = $file->getClientOriginalExtension();
                $document->file_size = $file->getSize();
            }
            
        } else {
            $document->document_url = Str::replace(url('/'), '', $request->document_url);
        }

        $this->setField($request, $document);
        $document->position = $this->model->where('category_id', $categoryId)->max('position') + 1;
        $document->created_by = Auth::user()->id;
        $document->save();

        return $document;
    }

    public function update($request, int $id)
    {
        $document = $this->find($id);

        if ($document->from == 0) {

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = $file->getClientOriginalName();
                if (file_exists(storage_path('app/public/edocman/'.$fileName))) {
                    $fileName = Str::random(3).'-'.$file->getClientOriginalName();
                }

                Storage::delete(config('custom.files.edocman.path').$request->old_file);

                Storage::put(config('custom.files.edocman.path').
                    $fileName, file_get_contents($file));

                $document->file = $fileName;
                $document->file_type = $file->getClientOriginalExtension();
                $document->file_size = $file->getSize();
            }

        } else {
            $document->document_url = Str::replace(url('/'), '', $request->document_url);
        }

        $this->setField($request, $document);
        $document->updated_by = Auth::user()->id;
        $document->save();

        return $document;
    }

    public function setField($request, $document)
    {
        foreach ($this->lang->getLang(false, true) as $key => $value) {
            $title[$value->iso_codes] = ($request->input('title_'.$value->iso_codes) == null) ?
                $request->input('title_'.config('custom.language.default')) : $request->input('title_'.$value->iso_codes);
            $description[$value->iso_codes] = ($request->input('description_'.$value->iso_codes) == null) ?
                $request->input('description_'.config('custom.language.default')) : $request->input('description_'.$value->iso_codes);
        }

        // $category->slug = Str::limit(Str::slug($request->slug, '-'), 50);
        $document->slug = Str::slug($request->slug, '-');
        $document->title = $title;
        $document->description = $description;
        $document->publish = (bool)$request->publish;
        $document->public = (bool)$request->public;
        $document->cover = [
            'file_path' => Str::replace(url('storage/'), '', $request->cover_file) ?? null,
            'title' => $request->cover_title ?? null,
            'alt' => $request->cover_alt ?? null,
        ];

        return $document;
    }

    public function position(int $id, int $position)
    {
        if ($position >= 1) {

            $document = $this->find($id);

            $this->model->where('category_id', $document->category_id)->where('position', $position)->update([
                'position' => $document->position,
            ]);

            $document->position = $position;
            $document->updated_by = Auth::user()->id;
            $document->save();

            return $document;
        }
    }

    public function publish(int $id)
    {
        $document = $this->find($id);
        $document->publish = !$document->publish;
        $document->updated_by = Auth::user()->id;
        $document->save();

        return $document;
    }

    public function recordViewer(int $id)
    {
        $document = $this->find($id);
        $document->viewer = ($document->viewer+1);
        $document->save();

        return $document;
    }

    public function recordDownload(int $id)
    {
        $document = $this->find($id);
        $document->download = ($document->download+1);
        $document->save();

        return $document;
    }

    public function delete(int $id)
    {
        $document = $this->find($id);
    
        if (!empty($document->file)) {
            Storage::delete(config('custom.files.edocman.path').$document->file);
        }

        $document->delete();

        return true;
    }
}