@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="card mb-4 col-md-10">
        <h6 class="card-header">
            @lang('lang.form_attr', [
                'attribute' => __('mod/master.field.caption')
            ])
        </h6>
        <form action="{{ !isset($data['field']) ? route('field.store', ['categoryId' => $data['category']->id]) : route('field.update', ['categoryId' => $data['category']->id, 'id' => $data['field']->id]) }}" method="POST">
            @csrf
            @isset ($data['field'])
                @method('PUT')
            @endisset
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/master.field.label.field1')</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control @error('label') is-invalid @enderror" name="label" 
                        value="{{ !isset($data['field']) ? old('label') : old('label', $data['field']->label) }}" placeholder="@lang('mod/master.field.placeholder.field1')">
                    @include('components.field-error', ['field' => 'label'])
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/master.field.label.field2')</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" 
                    value="{{ !isset($data['field']) ? old('name') : old('name', $data['field']->name) }}" placeholder="@lang('mod/master.field.placeholder.field2')">
                    @include('components.field-error', ['field' => 'name'])
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-2 text-md-right">
                    <label class="col-form-label text-sm-right">@lang('mod/master.field.label.field3')</label>
                    </div>
                    <div class="col-md-10">
                    <select id="type" class="selectpicker show-tick @error('type') is-invalid @enderror" name="type" data-style="btn-default">
                        <option value="" disabled selected>@lang('lang.select')</option>
                        @foreach (config('custom.field.field_module') as $key => $val)
                        <option value="{{ $key }}" {{ isset($data['field']) ? (old('type', $data['field']->type) == $key ? 'selected' : '') : ('') }}>{{ $val['title'] }}</option>
                        @endforeach
                    </select>
                    @error('type')
                    <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block; color:red;">{!! $message !!}</label>
                    @enderror
                    </div>
                </div>
                <div class="form-group row" id="class-field">
                    <div class="col-md-2 text-md-right">
                    <label class="col-form-label text-sm-right">@lang('mod/master.field.label.field4')</label>
                    </div>
                    <div class="col-md-10">
                        <select id="class" class="custom-select" name="classes" data-style="btn-default">

                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary" name="action" value="back" title="{{ isset($data['field']) ? __('lang.save_change') : __('lang.save') }}">
                    <i class="las la-save"></i> {{ isset($data['field']) ? __('lang.save_change') : __('lang.save') }}
                </button>&nbsp;&nbsp;
                <button type="submit" class="btn btn-danger" name="action" value="exit" title="{{ isset($data['field']) ? __('lang.save_change_exit') : __('lang.save_exit') }}">
                    <i class="las la-save"></i> {{ isset($data['field']) ? __('lang.save_change_exit') : __('lang.save_exit') }}
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
    @if (!isset($data['field']))
    <script>
        $('#class-field').hide();
        $('#type').on('change', function() {
            
            $('#class-field').show();
            $(".class-val").remove();
            if (this.value == 0) {
                $("#class").append(`
                    @foreach (config('custom.field.field_module.0.class') as $key => $val)
                        <option value="{{ $key }}" class="class-val">{{ $val }}</option>
                    @endforeach
                `);
            } else {
                $("#class").append(`
                    @foreach (config('custom.field.field_module.1.class') as $key => $val)
                        <option value="{{ $key }}" class="class-val">{{ $val }}</option>
                    @endforeach
                `);
            }

        });
    </script>  
    @else
    <script>

        $("#class").append(`
            @foreach (config('custom.field.field_module.'.$data['field']->type.'.class') as $key => $val)
                <option value="{{ $key }}" class="class-val" {{ isset($data['field']) ? (old('classes', $data['field']->classes) == $key ? 'selected' : '') : ('') }}>{{ $val }}</option>
            @endforeach
        `);

        $('#type').on('change', function() {
            $(".class-val").remove();
            if (this.value == 0) {
                $("#class").append(`
                    @foreach (config('custom.field.field_module.0.class') as $key => $val)
                        <option value="{{ $key }}" class="class-val" {{ isset($data['field']) ? (old('classes', $data['field']->classes) == $key ? 'selected' : '') : ('') }}>{{ $val }}</option>
                    @endforeach
                `);
            } else {
                $("#class").append(`
                    @foreach (config('custom.field.field_module.1.class') as $key => $val)
                        <option value="{{ $key }}" class="class-val" {{ isset($data['field']) ? (old('classes', $data['field']->classes) == $key ? 'selected' : '') : ('') }}>{{ $val }}</option>
                    @endforeach
                `);
            }

        });
    </script>
    @endif
@endsection