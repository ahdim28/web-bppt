@extends('layouts.backend.layout')

@section('styles')
<script src="{{ asset('assets/backend/wysiwyg/tinymce.min.js') }}"></script>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="card mb-4 col-md-10">
        <h6 class="card-header">
            @lang('lang.form_attr', [
                'attribute' => __('mod/master.tag.caption')
            ])
        </h6>
        <form action="{{ !isset($data['tag']) ? route('tag.store') : route('tag.update', ['id' => $data['tag']->id]) }}" method="POST">
            @csrf
            @isset ($data['tag'])
                @method('PUT')
            @endisset
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/master.tag.label.field1')</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ !isset($data['tag']) ? old('name') : old('name', $data['tag']->name)}}" placeholder="@lang('mod/master.tag.placeholder.field1')">
                    @include('components.field-error', ['field' => 'name'])
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-2 text-md-right">
                    <label class="col-form-label text-sm-right">@lang('mod/master.tag.label.field2')</label>
                    </div>
                    <div class="col-md-10">
                        <textarea class="form-control tiny-mce @error('description') is-invalid @enderror" name="description" placeholder="@lang('mod/master.tag.placeholder.field2')">{!! !isset($data['tag']) ? old('description') : old('description', $data['tag']->description) !!}</textarea>
                        @include('components.field-error', ['field' => 'description'])
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary" name="action" value="back" title="{{ isset($data['tag']) ? __('lang.save_change') : __('lang.save') }}">
                    <i class="las la-save"></i> {{ isset($data['tag']) ? __('lang.save_change') : __('lang.save') }}
                </button>&nbsp;&nbsp;
                <button type="submit" class="btn btn-danger" name="action" value="exit" title="{{ isset($data['tag']) ? __('lang.save_change_exit') : __('lang.save_exit') }}">
                    <i class="las la-save"></i> {{ isset($data['tag']) ? __('lang.save_change_exit') : __('lang.save_exit') }}
                </button>&nbsp;&nbsp;
                <button type="reset" class="btn btn-secondary" title="{{ __('lang.reset') }}">
                <i class="las la-redo-alt"></i> {{ __('lang.reset') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('jsbody')
@include('includes.tinymce')
@endsection
