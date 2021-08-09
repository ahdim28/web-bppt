@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="card mb-4 col-md-10">
        <h6 class="card-header">
            @lang('lang.form_attr', [
                'attribute' => __('mod/master.template.caption')
            ])
        </h6>
        <form action="{{ !isset($data['template']) ? route('template.store') : route('template.update', ['id' => $data['template']->id]) }}" method="POST">
            @csrf
            @isset ($data['template'])
                @method('PUT')
            @endisset
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/master.template.label.field1')</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" 
                        value="{{ !isset($data['template']) ? old('name') : old('name', $data['template']->name) }}" placeholder="@lang('mod/master.template.placeholder.field1')">
                    @include('components.field-error', ['field' => 'name'])
                    </div>
                </div>
                @if (!isset($data['template']))
                <div class="form-group row">
                    <div class="col-md-2 text-md-right">
                    <label class="col-form-label text-sm-right">@lang('mod/master.template.label.field2')</label>
                    </div>
                    <div class="col-md-10">
                    <select id="module" class="selectpicker show-tick @error('module') is-invalid @enderror" name="module" data-style="btn-default">
                        <option value="" disabled selected>@lang('lang.select')</option>
                        @foreach (config('custom.templates.module') as $key => $val)
                        <option value="{{ $key }}">{{ Str::replace('_', ' ', ucfirst($val)) }}</option>
                        @endforeach
                    </select>
                    @error('module')
                    <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block; color:red;">{!! $message !!}</label>
                    @enderror
                    </div>
                </div>
                <div class="form-group row" id="template-type">
                    <div class="col-md-2 text-md-right">
                    <label class="col-form-label text-sm-right">@lang('mod/master.template.label.field3')</label>
                    </div>
                    <div class="col-md-10">
                        <select id="type" class="custom-select" name="type" data-style="btn-default">

                        </select>
                        @error('type')
                        <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block; color:red;">{!! $message !!}</label>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/master.template.label.field5')</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control @error('filename') is-invalid @enderror" name="filename" value="{{ old('filename') }}" 
                        placeholder="@lang('mod/master.template.placeholder.field5')">
                    @include('components.field-error', ['field' => 'filename'])
                    </div>
                </div>
                @else
                <div class="form-group row">
                    <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/master.template.label.field2')</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ config('custom.templates.module.'.$data['template']->module) }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/master.template.label.field3')</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ config('custom.templates.type.'.$data['template']->type) }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/master.template.label.field4')</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $data['template']->file_path }}" readonly>
                    </div>
                </div>
                @endif
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary" name="action" value="back" title="{{ isset($data['template']) ? __('lang.save_change') : __('lang.save') }}">
                    <i class="las la-save"></i> {{ isset($data['template']) ? __('lang.save_change') : __('lang.save') }}
                </button>&nbsp;&nbsp;
                <button type="submit" class="btn btn-danger" name="action" value="exit" title="{{ isset($data['template']) ? __('lang.save_change_exit') : __('lang.save_exit') }}">
                    <i class="las la-save"></i> {{ isset($data['template']) ? __('lang.save_change_exit') : __('lang.save_exit') }}
                </button>&nbsp;&nbsp;
                <button type="reset" class="btn btn-secondary" title="{{ __('lang.reset') }}">
                <i class="las la-redo-alt"></i> {{ __('lang.reset') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/backend/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
@endsection

@section('jsbody')
<script>
    $('#template-type').hide();
    $('#module').on('change', function() {
        
        $('#template-type').show();
        $(".type-val").remove();
        if (this.value == 1 || this.value == 2) {
            $("#type").append(`
                <option value="1" class="type-val">List View</option>
                <option value="2" class="type-val">Detail View</option>
            `);
        } else {
            $("#type").append(`
                <option value="0" class="type-val">Custom View</option>
            `);
        }

    });
</script>
@endsection