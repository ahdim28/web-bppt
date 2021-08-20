@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
<script src="{{ asset('assets/backend/admin.js') }}"></script>
<script src="{{ asset('assets/backend/wysiwyg/tinymce.min.js') }}"></script>
@endsection

@section('content')
<div class="card mb-4">
    <h6 class="card-header">
      Form Album Category
    </h6>
    <form action="{{ !isset($data['category']) ? route('gallery.album.category.store') : route('gallery.album.category.update', ['id' => $data['category']->id]) }}" method="POST">
        @csrf
        @isset ($data['category'])
            @method('PUT')
        @endisset
        <div class="card-body overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                @if (config('custom.language.multiple') == true)
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        @foreach ($data['languages'] as $lang)
                        <a class="list-group-item list-group-item-action {{ $lang->iso_codes == config('custom.language.default') ? 'active' : '' }}" data-toggle="list" href="#{{ $lang->iso_codes }}">
                            <img src="{{ $lang->flags() }}" style="width: 20px;"> {{ Str::upper($lang->country) }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
                <div class="col-md-{{ config('custom.language.multiple') == true ? '9' : '12' }}">
                    <div class="tab-content">
                        @foreach ($data['languages'] as $lang)
                        <div class="tab-pane fade {{ $lang->iso_codes == config('custom.language.default') ? 'active show' : '' }}" id="{{ $lang->iso_codes }}">
                            <div class="card-body pb-2">
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 text-sm-right">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control mb-1 gen_slug @error('name_'.$lang->iso_codes) is-invalid @enderror" lang="{{ $lang->iso_codes }}" 
                                            name="name_{{ $lang->iso_codes }}" value="{{ !isset($data['category']) ? old('name_'.$lang->iso_codes) : old('name_'.$lang->iso_codes, $data['category']->fieldLang('name', $lang->iso_codes)) }}" placeholder="Enter name...">
                                        @include('components.field-error', ['field' => 'name_'.$lang->iso_codes])
                                    </div>
                                </div>
                                @if ($lang->iso_codes == config('custom.language.default'))
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 text-sm-right">Slug</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><strong>{{ url('/').'/photo/' }}</strong></span>
                                            </div>
                                            <input type="text" class="form-control slug_spot @error('slug') is-invalid @enderror" lang="{{ $lang->iso_codes }}" name="slug"
                                                    value="{{ !isset($data['category']) ? old('slug') : old('slug', $data['category']->slug) }}" placeholder="Enter slug...">
                                            @include('components.field-error', ['field' => 'slug'])
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 text-sm-right">Description</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control tiny-mce" name="description_{{ $lang->iso_codes }}">{!! !isset($data['category']) ? old('description_'.$lang->iso_codes) : old('description_'.$lang->iso_codes, $data['category']->fieldLang('description', $lang->iso_codes)) !!}</textarea>
                                    </div>
                                </div>
                                @if ($lang->iso_codes == config('custom.language.default'))
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 text-sm-right">Status</label>
                                    <div class="col-sm-10">
                                        <select class="selectpicker show-tick" name="publish" data-style="btn-default">
                                            @foreach (config('custom.label.publish') as $key => $publish)
                                                <option value="{{ $key }}" {{ !isset($data['category']) ? (old('publish') == ''.$key.'' ? 'selected' : '') : (old('publish', $data['category']->publish) == ''.$key.'' ? 'selected' : '') }}>
                                                    {{ __($publish['title']) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 text-sm-right">Image Preview</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="image1" aria-label="Image" aria-describedby="button-image" name="image_file"
                                                    value="{{ !isset($data['category']) ? old('image_file') : old('image_file', $data['category']->image_preview['file_path']) }}" placeholder="browse image..." readonly>
                                            <div class="input-group-append" title="browse file">
                                                <span class="input-group-text">
                                                    <input type="checkbox" id="remove-image" value="1">&nbsp; Remove
                                                </span>
                                                <button class="btn btn-primary file-name" id="button-image" type="button"><i class="las la-image"></i>&nbsp; Browse</button>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-6">
                                            <input type="text" class="form-control" placeholder="title..." name="image_title" value="{{ !isset($data['category']) ? old('image_title') : old('image_title', $data['category']->image_preview['title']) }}">
                                            </div>
                                            <div class="col-sm-6">
                                            <input type="text" class="form-control" placeholder="alt..." name="image_alt" value="{{ !isset($data['category']) ? old('image_alt') : old('image_alt', $data['category']->image_preview['alt']) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
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
@endsection

@section('scripts')
<script src="{{ asset('assets/backend/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
@endsection

@section('jsbody')
<script>
    $('#remove-image').click(function() {
        if ($('#remove-image').prop('checked') == true) {
            $('#image1').val('');
        }
    });
</script>
@include('includes.button-fm')
@include('includes.tinymce-fm')
@endsection