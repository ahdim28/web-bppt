<?php

namespace App\Services\Content;

use App\Models\Content\Post\Post;
use App\Models\Content\Post\PostFile;
use App\Models\Content\Post\PostProfile;
use App\Services\LanguageService;
use App\Services\Master\Field\FieldCategoryService;
use App\Services\Master\TagService;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostService
{
    private $model, $modelFile, $modelProfile, $lang, $tag, $field, $section;

    public function __construct(
        Post $model,
        PostFile $modelFile,
        PostProfile $modelProfile,
        LanguageService $lang,
        TagService $tag,
        FieldCategoryService $field,
        SectionService $section
    )
    {
        $this->model = $model;
        $this->modelFile = $modelFile;
        $this->modelProfile = $modelProfile;
        $this->lang = $lang;
        $this->tag = $tag;
        $this->field = $field;
        $this->section = $section;
    }

    public function getPostList($request, int $sectionId)
    {
        $section = $this->section->find($sectionId);

        $query = $this->model->query();

        $query->where('section_id', $sectionId);
        $query->when($request, function ($query, $req) {
            if ($req->c != '') {
                $query->where('category_id', $req->c);
            }
        })->when($request, function ($query, $req) {
            if ($req->s != '') {
                $query->where('publish', $req->s);
            }
        })->when($request, function ($query, $req) {
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

        $result = $query->orderBy($section->order_field, $section->order_by)
            ->paginate($limit);

        return $result;
    }

    public function getPost($request = null, $withPaginate = null, $limit = null, 
        $type = null, $idType = null)
    {
        $orderField = 'created_at';
        $orderBy = 'DESC';

        $query = $this->model->query();

        if ($type == 'section') {
            $section = $this->section->find($idType);
            $query->where('section_id', $idType);

            $orderField = $section->order_field;
            $orderBy = $section->order_by;
        }

        if ($type == 'category') {
            $query->where('category_id', $idType);
        }

        $query->publish();
        if (Auth::guard()->check() == false) {
            $query->public();
        }

        if (!empty($request)) {
            $this->search($query, $request);
        }

        if (!empty($withPaginate)) {
            $result = $query->orderBy($orderField, $orderBy)->paginate($limit);
        } else {
            if (!empty($limit)) {
                $result = $query->orderBy($orderField, $orderBy)->limit($limit)->get();
            } else {
                $result = $query->orderBy($orderField, $orderBy)->get();
            }

        }

        return $result;
    }

    public function latestPost(int $id, $limit = 8, $content = null)
    {
        $find = $this->find($id);

        $query = $this->model->query();

        $query->publish();
        if (Auth::guard()->check() == false) {
            $query->public();
        }

        if ($content == 'all') {
            $query->where('section_id', $find->section_id)->where('category_id', $find->category_id);
        }

        if ($content == 'section') {
            $query->where('section_id', $find->section_id);
        }

        if ($content == 'category') {
            $query->where('category_id', $find->category_id);
        }

        $query->whereNotIn('id', [$id]);

        $result = $query->inRandomOrder()->limit($limit)->get();

        return $result;
    }

    public function postPrevNext(int $id, $limit = 1, $type, $content = null)
    {
        $find = $this->find($id);

        $query = $this->model->query();

        $query->publish();
        if (Auth::guard()->check() == false) {
            $query->public();
        }

        if ($content == 'all') {
            $query->where('section_id', $find->section_id)->where('category_id', $find->category_id);
        }

        if ($content == 'section') {
            $query->where('section_id', $find->section_id);
        }

        if ($content == 'category') {
            $query->where('category_id', $find->category_id);
        }

        if ($type == 'prev') {
            $query->where('position', '<', $id);
        }

        if ($type == 'next') {
            $query->where('position', '>', $id);
        }

        $query->whereNotIn('id', [$id]);

        $result = $query->inRandomOrder()->limit($limit)->get();

        return $result;
    }

    public function search($query, $request)
    {
        $query->when($request->section_id, function ($query, $section_id) {
            $query->where('section_id', $section_id);
        })->when($request->category_id, function ($query, $category_id) {
            $query->where('category_id', $category_id);
        })->when($request->keyword, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('title->'.App::getLocale(), 'like', '%'.$q.'%')
                    ->orWhere('intro->'.App::getLocale(), 'like', '%'.$q.'%')
                    ->orWhere('content->'.App::getLocale(), 'like', '%'.$q.'%')
                    ->orWhere('meta_data->title', 'like', '%'.$q.'%')
                    ->orWhere('meta_data->description', 'like', '%'.$q.'%')
                    ->orWhere('meta_data->keywords', 'like', '%'.$q.'%');
            });
        });
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

    public function findFile(int $id)
    {
        return $this->modelFile->findOrFail($id);
    }

    public function store($request, int $sectionId)
    {
        $section = $this->section->find($sectionId);

        $post = new Post;
        $post->section_id = $sectionId;
        $this->setField($request, $post);
        $post->position = $this->model->where('section_id', $sectionId)->max('position') + 1;
        $post->created_by = Auth::user()->id;
        $post->save();

        if ($section->extra == 1) {
            if ($request->hasFile('files')) {

                foreach ($request->file('files') as $key => $value) {

                    $fileName = Str::random(3).'-'.Str::replace(' ', '-', 
                        $value->getClientOriginalName());

                    $file = new PostFile;
                    $file->post_id = $post->id;
                    $file->file = $fileName;
                    $file->file_type = $value->getClientOriginalExtension();
                    $file->file_size = $value->getSize();
                    $file->caption = [
                        'title' => $request->input('file_title_'.$key),
                        'description' => $request->input('file_decsription_'.$key),
                    ];
                    $file->save();

                    Storage::put(config('custom.files.post_files.path').$post->id.'/'.
                        $fileName, file_get_contents($value));
                }

            }
        }

        if ($section->extra == 2) {
            $profile = new PostProfile;
            $profile->post_id = $post->id;
            $field = [];
            foreach (config('custom.columns.profile_posts') as $key => $value) {
                $field[$value['name']] = $request->input('profile_'.$value['name']) ?? null;
            }
            $profile->fields = $field;
            $profile->save();
        }

        if (!empty($request->tags)) {
            $this->tag->wipeStore($request, $post);
        }

        return $post;
    }

    public function update($request, int $id)
    {
        $post = $this->find($id);
        $this->setField($request, $post);
        $post->updated_by = Auth::user()->id;
        $post->save();

        if ($post->section->extra == 1) {
            
            if ($post->files->count() > 0) {
                foreach ($request->file_id as $keyF => $valueF) {
                    
                    $updateFile = $this->findFile($valueF);
                    $updateFile->caption = [
                        'title' => $request->input('file_title_'.$valueF),
                        'description' => $request->input('file_description_'.$valueF),
                    ];
                    $updateFile->save();
                }
            }

            if ($request->hasFile('files')) {

                foreach ($request->file('files') as $key => $value) {

                    $fileName = Str::random(3).'-'.Str::replace(' ', '-', 
                    $value->getClientOriginalName());

                    $file = new PostFile;
                    $file->post_id = $post->id;
                    $file->file = $fileName;
                    $file->file_type = $value->getClientOriginalExtension();
                    $file->file_size = $value->getSize();
                    $file->caption = [
                        'title' => $request->input('file_title_'.$key),
                        'description' => $request->input('file_decsription_'.$key),
                    ];
                    $file->save();

                    Storage::put(config('custom.files.post_files.path').$post->id.'/'.
                        $fileName, file_get_contents($value));
                }

            }
        }

        if ($post->section->extra == 2) {
            $profile = $post->profile;
            $field2 = [];
            foreach (config('custom.columns.profile_posts') as $key => $value) {
                $field2[$value['name']] = $request->input('profile_'.$value['name']) ?? null;
            }
            $profile->fields = $field2;
            $profile->save();
        }

        if (!empty($request->tags)) {
            $this->tag->wipeStore($request, $post);
        }

        if (!empty($request->old_tags) && empty($request->tags)) {
            $post->tags()->delete();
        }

        return $post;
    }

    public function setField($request, $post)
    {
        foreach ($this->lang->getLang(false, true) as $key => $value) {
            $title[$value->iso_codes] = ($request->input('title_'.$value->iso_codes) == null) ?
                $request->input('title_'.config('custom.language.default')) : $request->input('title_'.$value->iso_codes);
            $intro[$value->iso_codes] = ($request->input('intro_'.$value->iso_codes) == null) ?
                $request->input('intro_'.config('custom.language.default')) : $request->input('intro_'.$value->iso_codes);
            $content[$value->iso_codes] = ($request->input('content_'.$value->iso_codes) == null) ?
                $request->input('content_'.config('custom.language.default')) : $request->input('content_'.$value->iso_codes);
        }

        $post->category_id = $request->category_id;
        $post->slug = Str::limit(Str::slug($request->slug, '-'), 50);
        $post->title = $title;
        $post->intro = $intro;
        $post->content = $content;
        $post->cover = [
            'file_path' => Str::replace(url('storage/'), '',  $request->cover_file) ?? null,
            'title' => $request->cover_title ?? null,
            'alt' => $request->cover_alt ?? null,
        ];

        $post->banner = [
            'file_path' => Str::replace(url('storage/'), '',  $request->banner_file) ?? null,
            'title' => $request->banner_title ?? null,
            'alt' => $request->banner_alt ?? null,
        ];

        $post->publish_year = Carbon::parse($request->created_at)->format('Y');
        $post->publish_month = Carbon::parse($request->created_at)->format('m');
        $post->publish = (bool)$request->publish;
        $post->public = (bool)$request->public;
        $post->is_detail = (bool)$request->is_detail;
        $post->custom_view_id = $request->custom_view_id ?? null;
        $post->meta_data = [
            'title' => $request->meta_title ?? null,
            'description' => $request->meta_description ?? null,
            'keywords' => $request->meta_keywords ?? null,
        ];

        $post->field_category_id = $request->field_category_id ?? null;
        if (!empty($request->field_category_id)) {

            $field = $this->field->find($request->field_category_id);
            foreach ($field->fields as $key => $value) {
                $custom_field[$key] = [
                    $value->name => $request->input('field_'.$value->name) ?? null
                ];
            }

            $post->custom_field = $custom_field;
        } else {
            $post->custom_field = null;
        }

        $post->created_at = $request->created_at;

        return $post;
    }

    public function publish(int $id)
    {
        $post = $this->find($id);
        $post->publish = !$post->publish;
        $post->updated_by = Auth::user()->id;
        $post->save();

        return $post;
    }

    public function selection(int $id)
    {
        $post = $this->find($id);
        $total = $this->model->where('section_id', $post->section_id)->selection()->count();
        $select = $post->section->post_selection;

        if ($post->selection == 0) {
            $check = (empty($select) || !empty($select) && $total < $select);
        } else {
            $check = (empty($select) || !empty($select));
        }

        if ($check) {

            $post->selection = !$post->selection;
            $post->updated_by = Auth::user()->id;
            $post->save();

            return true;

        } else {

            return false;

        }
    }

    public function position(int $id, int $position)
    {
        if ($position >= 1) {

            $post = $this->find($id);
            $this->model->where('section_id', $post->section_id)
                ->where('position', $position)->update([
                'position' => $post->position,
            ]);
            $post->position = $position;
            $post->updated_by = Auth::user()->id;
            $post->save();

            return $post;
        }
    }

    public function recordViewer(int $id)
    {
        $post = $this->find($id);
        $post->viewer = ($post->viewer+1);
        $post->save();

        return $post;
    }

    public function delete(int $id)
    {
        $post = $this->find($id);

        $menu = $post->menu()->count();

        if ($menu == 0) {
            
            $post->media()->delete();
            if ($post->files()->count() > 0) {
                foreach ($post->files as $file) {
                    Storage::delete(config('custom.files.post_files.path').$id.'/'.$file->file);
                }
            }
    
            Storage::deleteDirectory(config('custom.files.post_files.path').$id);
    
            $post->files()->delete();
            $post->profile()->delete();
            $post->tags()->delete();
            $post->delete();
            return true;
            
        } else {
            return false;
        }
    }

    public function deleteFile(int $id)
    {
        $file = $this->findFile($id);
        Storage::delete(config('custom.files.post_files.path').$file->post_id.'/'.$file->file);
        $file->delete();

        return $file;
    }
}