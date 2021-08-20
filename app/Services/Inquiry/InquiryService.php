<?php

namespace App\Services\Inquiry;

use App\Models\Inquiry\Inquiry;
use App\Models\Inquiry\InquiryField;
use App\Models\Inquiry\InquiryForm;
use App\Services\IndexUrlService;
use App\Services\LanguageService;
use App\Services\Master\Field\FieldCategoryService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class InquiryService
{
    private $model, $modelForm, $modelField, $lang, $field, $index;

    public function __construct(
        Inquiry $model,
        InquiryField $modelField,
        InquiryForm $modelForm,
        LanguageService $lang,
        FieldCategoryService $field,
        IndexUrlService $index
    )
    {
        $this->model = $model;
        $this->modelForm = $modelForm;
        $this->modelField = $modelField;
        $this->lang = $lang;
        $this->field = $field;
        $this->index = $index;
    }

    public function getInquiryList($request)
    {
        $query = $this->model->query();

        $query->when($request, function ($query, $req) {
            if ($req->s != '') {
                $query->where('publish', $req->s);
            }
        })->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('name->'.App::getLocale(), 'like', '%'.$q.'%')
                    ->orWhere('body->'.App::getLocale(), 'like', '%'.$q.'%');
            });
        });

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->orderBy('position', 'ASC')->paginate($limit);

        return $result;
    }

    public function getInquiry($request = null, $withPaginate = false, $limit = null)
    {
        $query = $this->model->query();

        $query->publish();

        if (!empty($request)) {
            $query->when($request->q, function ($query, $q) {
                $query->where(function ($query) use ($q) {
                    $query->where('name->'.App::getLocale(), 'like', '%'.$q.'%')
                        ->orWhere('body->'.App::getLocale(), 'like', '%'.$q.'%');
                });
            });
        }

        $query->orderBy('position', 'ASC');
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

    public function store($request)
    {
        $inquiry = new Inquiry;
        $this->setField($request, $inquiry);

        $path = resource_path('views/frontend/inquiries/'.
            Str::slug($request->slug, '-').'.blade.php');
        File::put($path, '');

        $inquiry->position = $this->model->max('position') + 1;
        $inquiry->created_by = auth()->user()->id;
        $inquiry->save();

        // $slug = Str::limit(Str::slug($request->slug, '-'), 50);
        $slug = Str::slug($request->slug, '-');
        $this->index->store($slug, $inquiry);

        return $inquiry;
    }

    public function update($request, int $id)
    {
        $inquiry = $this->find($id);
        $this->setField($request, $inquiry);

        if ($request->slug != $request->old_slug) {

            // $pathOld = resource_path('views/frontend/inquiries/'.
            //     $request->old_slug.'.blade.php');
            // File::delete($pathOld);

            // $path = resource_path('views/frontend/inquiries/'.
            //     Str::slug($request->slug, '-').'.blade.php');
            // File::put($path, '');
        }

        $inquiry->save();

        // $slug = Str::limit(Str::slug($request->slug, '-'), 50);
        $slug = Str::slug($request->slug, '-');
        $this->index->update($request->url_id, $slug);

        return $inquiry;
    }

    public function setField($request, $inquiry)
    {
        foreach ($this->lang->getLang(false, true) as $key => $value) {
            $name[$value->iso_codes] = ($request->input('name_'.$value->iso_codes) == null) ?
                $request->input('name_'.config('custom.language.default')) : $request->input('name_'.$value->iso_codes);
            $body[$value->iso_codes] = ($request->input('body_'.$value->iso_codes) == null) ?
                $request->input('body_'.config('custom.language.default')) : $request->input('body_'.$value->iso_codes);
            $afterBody[$value->iso_codes] = ($request->input('after_body_'.$value->iso_codes) == null) ?
                $request->input('after_body_'.config('custom.language.default')) : $request->input('after_body_'.$value->iso_codes);
        }

        $inquiry->slug = Str::slug($request->slug, '-');
        $inquiry->name = $name;
        $inquiry->body = $body;
        $inquiry->after_body = $afterBody;
        $inquiry->publish = (bool)$request->publish;
        $inquiry->is_detail = (bool)$request->is_detail;
        $inquiry->show_form = (bool)$request->show_form;
        $inquiry->email = !empty($request->email) ? explode(",", $request->email) : null;
        $inquiry->show_map = (bool)$request->show_map;

        if ((bool)$request->show_map == 1) {
            $inquiry->longitude = $request->longitude;
            $inquiry->latitude = $request->latitude;
        } else {
            $inquiry->longitude = null;
            $inquiry->latitude = null;
        }

        $inquiry->banner = [
            'file_path' => str_replace(url('/storage'), '', $request->banner_file) ?? null,
            'title' => $request->banner_title ?? null,
            'alt' => $request->banner_alt ?? null,
        ];

        $inquiry->meta_data = [
            'title' => $request->meta_title ?? null,
            'description' => $request->meta_description ?? null,
            'keywords' => $request->meta_keywords ?? null,
        ];

        $inquiry->field_category_id = $request->field_category_id ?? null;
        if (!empty($request->field_category_id)) {

            $field = $this->field->find($request->field_category_id);
            foreach ($field->fields as $key => $value) {
                $custom_field[$key] = [
                    $value->name => $request->input('field_'.$value->name) ?? null
                ];
            }

            $inquiry->custom_field = $custom_field;
        } else {
            $inquiry->custom_field = null;
        }

        $inquiry->updated_by = auth()->user()->id;

        return $inquiry;
    }

    public function publish(int $id)
    {
        $inquiry = $this->find($id);
        $inquiry->publish = !$inquiry->publish;
        $inquiry->save();

        return $inquiry;
    }

    public function position(int $id, int $position)
    {
        if ($position >= 1) {

            $inquiry = $this->find($id);
            $this->model->where('position', $position)->update([
                'position' => $inquiry->position,
            ]);
            $inquiry->position = $position;
            $inquiry->save();

            return $inquiry;
        }
    }

    public function recordViewer(int $id)
    {
        $inquiry = $this->find($id);
        $inquiry->viewer = ($inquiry->viewer+1);
        $inquiry->save();

        return $inquiry;
    }

    public function delete(int $id)
    {
        $inquiry = $this->find($id);

        if ($inquiry->forms->count() == 0 && $inquiry->inquiryField->count() == 0 && $inquiry->menu()->count() == 0) {

            $path = resource_path('views/frontend/inquiries/'.
                $inquiry->slug.'.blade.php');
            File::delete($path);

            $inquiry->indexing->delete();
            $inquiry->delete();
            return true;

        } else {
            return false;
        }

    }

    /**
     * forms
     */
    public function getFormList($request, int $inquiryId)
    {
        $query = $this->modelForm->query();

        $query->where('inquiry_id', $inquiryId);
        $query->when($request, function ($query, $req) {
            if ($req->s != '') {
                $query->where('status', $req->s);
            }
        })->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('ip_address', 'like', '%'.$q.'%');
                foreach ($this->modelField->where('inquiry_id', request()->segment(3))
                    ->get() as $key => $value) {
                    $query->orWhere('fields->'.$value->name, 'like', '%'.$q.'%');
                }
            });
        });

        $limit = 20;
        if (!empty($request->l)) {
            $limit = $request->l;
        }

        $result = $query->orderBy('submit_time', 'DESC')->paginate($limit);

        return $result;
    }

    public function exportForm($request, int $inquiryId)
    {
        $query = $this->modelForm->query();

        $query->where('inquiry_id', $inquiryId);

        if ((bool)$request->default == 0) {
            if (!empty($request->status)) {
                $query->where('status', $request->status);
            }
            if (!empty($request->exported)) {
                $query->where('exported', $request->exported);
            }
    
            if (!empty($request->limit)) {
                $query->limit($request->limit);
            }
        }

        $result = $query->orderBy('submit_time', 'DESC')->get();

        return $result;
    }

    public function latestForm()
    {
        $query = $this->modelForm->query();

        $result = $query->orderBy('submit_time', 'DESC')->limit(5)->get();

        return $result;
    }
    
    public function deleteForm(int $id)
    {
        $form = $this->findForm($id);
        $form->delete();

        return $form;
    }

    public function findForm(int $id)
    {
        return $this->modelForm->findOrFail($id);
    }

    public function statusForm(int $id, $status)
    {
        $inquiry = $this->findForm($id);
        $inquiry->status = $status;
        $inquiry->save();

        return $inquiry;
    }

    public function submitForm($request, int $inquiryId)
    {
        $inquiry = $this->find($inquiryId);

        foreach ($inquiry->inquiryField as $key => $value) {
            $fields[$value->name] = strip_tags($request->input($value->name)) ?? null;
        }

        $form = new InquiryForm;
        $form->inquiry_id = $inquiryId;
        $form->ip_address = request()->ip();
        $form->fields = $fields;
        $form->submit_time = now();
        $form->save();

        return $form;
    }
}