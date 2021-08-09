@extends('layouts.backend.layout')

@section('styles')
<script src="{{ asset('assets/backend/wysiwyg/tinymce.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="card mb-4 col-md-10">
    <h6 class="card-header">
      @lang('lang.form_attr', [
        'attribute' => __('mod/language.caption')
      ])
    </h6>
    <form action="{{ !isset($data['language']) ? route('language.store') : route('language.update', ['id' => $data['language']->id]) }}" method="POST">
        @csrf
        @isset ($data['language'])
            @method('PUT')
        @endisset
        <div class="card-body">
            <div class="form-group row">
                <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/language.label.field1')</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control @error('iso_codes') is-invalid @enderror" name="iso_codes"
                        value="{{ !isset($data['language']) ? old('iso_codes') : old('iso_codes', $data['language']->iso_codes) }}"
                        placeholder="@lang('mod/language.placeholder.field1')" {{ (isset($data['language'])) ? (($data['language']->iso_codes == 'id' || $data['language']->iso_codes == 'en') ? 'readonly' : '') : '' }}>
                  @include('components.field-error', ['field' => 'iso_codes'])
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/language.label.field2')</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control @error('country') is-invalid @enderror" name="country"
                        value="{{ !isset($data['language']) ? old('country') : old('country', $data['language']->country) }}" 
                        placeholder="@lang('mod/language.placeholder.field2')">
                  @include('components.field-error', ['field' => 'country'])
                </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/language.label.field3')</label>
              <div class="col-sm-10">
                <input type="text" class="form-control @error('country_code') is-invalid @enderror" name="country_code"
                      value="{{ !isset($data['language']) ? old('country_code') : old('country_code', $data['language']->country_code) }}" 
                      placeholder="@lang('mod/language.placeholder.field3')">
                @include('components.field-error', ['field' => 'country_code'])
              </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">@lang('mod/language.label.field4')</label>
                </div>
                <div class="col-md-10">
                    <textarea class="form-control tiny-mce @error('description') is-invalid @enderror" name="description" placeholder="@lang('mod/language.placeholder.field4')">{!! !isset($data['language']) ? old('description') : old('description', $data['language']->description) !!}</textarea>
                    @include('components.field-error', ['field' => 'description'])
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/language.label.field5')</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control @error('time_zone') is-invalid @enderror" name="time_zone"
                        value="{{ !isset($data['language']) ? old('time_zone') : old('time_zone', $data['language']->time_zone) }}" 
                        placeholder="@lang('mod/language.placeholder.field5')">
                  @include('components.field-error', ['field' => 'time_zone'])
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/language.label.field6')</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control @error('gmt') is-invalid @enderror" name="gmt"
                        value="{{ !isset($data['language']) ? old('gmt') : old('gmt', $data['language']->gmt) }}" 
                        placeholder="@lang('mod/language.placeholder.field6')">
                  @include('components.field-error', ['field' => 'gmt'])
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/language.label.field7')</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control @error('faker_locale') is-invalid @enderror" name="faker_locale"
                        value="{{ !isset($data['language']) ? old('faker_locale') : old('faker_locale', $data['language']->faker_locale) }}" 
                        placeholder="@lang('mod/language.placeholder.field7')">
                  @include('components.field-error', ['field' => 'faker_locale'])
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/language.label.field8')</label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <input type="text" class="form-control @error('icon') is-invalid @enderror" id="image1" aria-label="Image" aria-describedby="button-image" name="icon"
                            value="{{ !isset($data['language']) ? old('icon') : old('icon', $data['language']->icon) }}" placeholder="@lang('mod/language.placeholder.field8')">
                    <div class="input-group-append" title="browse file">
                        <button class="btn btn-primary file-name" id="button-image" type="button"><i class="las la-image"></i>&nbsp; @lang('lang.browse')</button>
                    </div>
                    @include('components.field-error', ['field' => 'icon'])
                  </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">@lang('lang.status')</label>
                </div>
                <div class="col-md-10">
                    <label class="switcher switcher-success">
                        <input type="checkbox" class="switcher-input check-parent" name="status" value="1" 
                            {{ !isset($data['language']) ? (old('status') == 1 ? 'checked' : 'checked') : (old('status', $data['language']->status) == 1 ? 'checked' : '') }}>
                        <span class="switcher-indicator">
                          <span class="switcher-yes">
                            <span class="ion ion-md-checkmark"></span>
                          </span>
                          <span class="switcher-no">
                            <span class="ion ion-md-close"></span>
                          </span>
                        </span>
                    </label>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
          <button type="submit" class="btn btn-primary" name="action" value="back" title="{{ isset($data['language']) ? __('lang.save_change') : __('lang.save') }}">
              <i class="las la-save"></i> {{ isset($data['language']) ? __('lang.save_change') : __('lang.save') }}
          </button>&nbsp;&nbsp;
          <button type="submit" class="btn btn-danger" name="action" value="exit" title="{{ isset($data['language']) ? __('lang.save_change_exit') : __('lang.save_exit') }}">
              <i class="las la-save"></i> {{ isset($data['language']) ? __('lang.save_change_exit') : __('lang.save_exit') }}
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
<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
@endsection

@section('jsbody')
@include('includes.button-fm')
@include('includes.tinymce-fm')
@endsection