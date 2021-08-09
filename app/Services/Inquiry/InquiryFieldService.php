<?php

namespace App\Services\Inquiry;

use App\Models\Inquiry\InquiryField;
use App\Services\LanguageService;
use Illuminate\Support\Facades\App;

class InquiryFieldService
{
    private $model, $lang;

    public function __construct(
        InquiryField $model,
        LanguageService $lang
    )
    {
        $this->model = $model;
        $this->lang = $lang;
    }

    public function getFieldList($request, int $inquiryId)
    {
        $query = $this->model->query();

        $query->where('inquiry_id', $inquiryId);
        $query->when($request->q, function ($query, $q) {
            $query->where(function ($query) use ($q) {
                $query->where('label->'.App::getLocale(), 'like', '%'.$q.'%')
                    ->orWhere('name', 'like', '%'.$q.'%');
            });
        });

        $result = $query->orderBy('position', 'ASC')->get();

        return $result;
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function store($request, $inquiryId)
    {
        $field = new InquiryField;
        $field->inquiry_id = $inquiryId;
        $this->setField($request, $field);
        $field->position = $this->model->where('inquiry_id', $inquiryId)
            ->max('position') + 1;
        $field->created_by = auth()->user()->id;
        $field->save();

        return $field;
    }

    public function update($request, int $id)
    {
        $field = $this->find($id);
        $this->setField($request, $field);
        $field->save();

        return $field;
    }

    public function setField($request, $field)
    {
        foreach ($this->lang->getLang(false, true) as $key => $value) {
            $label[$value->iso_codes] = ($request->input('label_'.$value->iso_codes) == null) ?
                $request->input('label_'.config('custom.language.default')) : $request->input('label_'.$value->iso_codes);
        }

        $field->label = $label;
        $field->name = str_replace(' ', '_', strtolower($request->name));
        $field->type = $request->type;
        $field->properties = [
            'type' => $request->inp_type ?? null,
            'id' => $request->inp_id ?? null,
            'class' => $request->inp_class ?? null,
            'attr' => $request->inp_attr ?? null,
        ];
        $field->validation = $request->validation ?? 'nullable';
        
        $field->updated_by = auth()->user()->id;

        return $field;
    }

    public function position(int $id, int $position)
    {
        if ($position >= 1) {

            $field = $this->find($id);
            $this->model->where('inquiry_id', $field->inquiry_id)
                ->where('position', $position)->update([
                'position' => $field->position,
            ]);
            $field->position = $position;
            $field->save();

            return $field;
        }
    }

    public function delete(int $id)
    {
        $field = $this->find($id);
        $field->delete();

        return $field;
    }
}