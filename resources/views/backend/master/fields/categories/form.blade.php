@extends('layouts.backend.layout')

@section('content')
<div class="row justify-content-center">
    <div class="card mb-4 col-md-10">
        <h6 class="card-header">
            @lang('lang.form_attr', [
                'attribute' => __('mod/master.field.category.title')
            ])
        </h6>
        <form action="{{ !isset($data['category']) ? route('field.category.store') : route('field.category.update', ['id' => $data['category']->id]) }}" method="POST">
            @csrf
            @isset ($data['category'])
                @method('PUT')
            @endisset
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/master.field.category.label.field1')</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" 
                        value="{{ !isset($data['category']) ? old('name') : old('name', $data['category']->name) }}" placeholder="@lang('mod/master.field.category.placeholder.field1')">
                    @include('components.field-error', ['field' => 'name'])
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/master.field.category.label.field2')</label>
                    <div class="col-sm-10">
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" placeholder="@lang('mod/master.field.category.placeholder.field2')">{{ !isset($data['category']) ? old('description') : old('description', $data['category']->description) }}</textarea>
                    @include('components.field-error', ['field' => 'description'])
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary" name="action" value="back" title="{{ isset($data['category']) ? __('lang.save_change') : __('lang.save') }}">
                    <i class="las la-save"></i> {{ isset($data['category']) ? __('lang.save_change') : __('lang.save') }}
                </button>&nbsp;&nbsp;
                <button type="submit" class="btn btn-danger" name="action" value="exit" title="{{ isset($data['category']) ? __('lang.save_change_exit') : __('lang.save_exit') }}">
                    <i class="las la-save"></i> {{ isset($data['category']) ? __('lang.save_change_exit') : __('lang.save_exit') }}
                </button>&nbsp;&nbsp;
                <button type="reset" class="btn btn-secondary" title="{{ __('lang.reset') }}">
                <i class="las la-redo-alt"></i> {{ __('lang.reset') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection