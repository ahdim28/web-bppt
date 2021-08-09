@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/css/pages/account.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
<script src="{{ asset('assets/backend/admin.js') }}"></script>
<script src="{{ asset('assets/backend/wysiwyg/tinymce.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/backend/fancybox/fancybox.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/timepicker/timepicker.css') }}">
@endsection

@section('content')
<div class="card">
    <div class="list-group list-group-flush account-settings-links flex-row">
        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#content">CONTENT</a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#setting">SETTING</a>
        @if ($data['fields']->count() > 0)
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#field">CUSTOM FIELD</a>
        @endif
    </div>
    <form action="{{ route('link.media.store', ['linkId' => $data['link']->id]) }}" method="POST">
        @csrf
        <div class="tab-content">

            <div class="tab-pane fade show active" id="content">
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
                                            <label class="col-form-label col-sm-2 text-sm-right">Title</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control mb-1 @error('title_'.$lang->iso_codes) is-invalid @enderror" lang="{{ $lang->iso_codes }}" 
                                                    name="title_{{ $lang->iso_codes }}" value="{{ old('title_'.$lang->iso_codes) }}" placeholder="Enter title...">
                                                @include('components.field-error', ['field' => 'title_'.$lang->iso_codes])
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2 text-sm-right">Description</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control tiny-mce" name="description_{{ $lang->iso_codes }}">{!! old('description_'.$lang->iso_codes) !!}</textarea>
                                            </div>
                                        </div>
                                        @if ($lang->iso_codes == config('custom.language.default'))
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2 text-sm-right">URL</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control mb-1 @error('url') is-invalid @enderror" name="url"
                                                        value="{{ old('url') }}" placeholder="Enter url...">
                                                @include('components.field-error', ['field' => 'url'])
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
            </div>

            <div class="tab-pane fade" id="setting">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">Cover</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" class="form-control" id="image1" aria-label="Image" aria-describedby="button-image" name="cover_file"
                                        value="{{ old('cover_file') }}" placeholder="browse cover..." readonly>
                                <div class="input-group-append" title="browse file">
                                    <span class="input-group-text">
                                        <input type="checkbox" id="remove-cover" value="1">&nbsp; Remove
                                    </span>
                                    <button class="btn btn-primary file-name" id="button-image" type="button"><i class="las la-image"></i>&nbsp; Browse</button>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-6">
                                <input type="text" class="form-control" placeholder="title..." name="cover_title" value="{{ old('cover_title') }}">
                                </div>
                                <div class="col-sm-6">
                                <input type="text" class="form-control" placeholder="alt..." name="cover_alt" value="{{ old('cover_alt') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">Banner</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" class="form-control" id="image2" aria-label="Image2" aria-describedby="button-image2" name="banner_file"
                                        value="{{ old('banner_file') }}" placeholder="browse banner..." readonly>
                                <div class="input-group-append" title="browse file">
                                    <span class="input-group-text">
                                        <input type="checkbox" id="remove-banner" value="1">&nbsp; Remove
                                    </span>
                                    <button class="btn btn-primary file-name" id="button-image2" type="button"><i class="las la-image"></i>&nbsp; Browse</button>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-6">
                                <input type="text" class="form-control" placeholder="title..." name="banner_title" value="{{ old('banner_title') }}">
                                </div>
                                <div class="col-sm-6">
                                <input type="text" class="form-control" placeholder="alt..." name="banner_alt" value="{{ old('banner_alt') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="field">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">Field</label>
                        <div class="col-sm-10">
                            <select id="field_category" class="selectpicker show-tick" name="field_category_id" data-style="btn-default">
                                <option value=" " selected>Select</option>
                                @foreach ($data['fields'] as $field)
                                    <option value="{{ $field->id }}">
                                        {{ $field->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="custom_field">

                    </div>
                </div>
            </div>

        </div>
        <div class="card-footer text-center">
            <button type="submit" class="btn btn-primary" name="action" value="back" title="@lang('lang.save')">
                <i class="las la-save"></i> @lang('lang.save')
            </button>&nbsp;&nbsp;
            <button type="submit" class="btn btn-danger" name="action" value="exit" title="@lang('lang.save_exit')">
                <i class="las la-save"></i> @lang('lang.save_exit')
            </button>&nbsp;&nbsp;
            <button type="reset" class="btn btn-secondary" title="@lang('lang.reset')">
                <i class="las la-redo-alt"></i> @lang('lang.reset')
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/backend/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
<script src="{{ asset('assets/backend/fancybox/fancybox.min.js') }}"></script>
<script src="{{ asset('assets/backend/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('assets/backend/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/backend/vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.js') }}"></script>
<script src="{{ asset('assets/backend/vendor/libs/timepicker/timepicker.js') }}"></script>
@endsection

@section('jsbody')
<script src="{{ asset('assets/backend/js/pages_account-settings.js') }}"></script>
<script>
    $('#remove-cover').click(function() {
        if ($('#remove-cover').prop('checked') == true) {
            $('#image1').val('');
        }
    });
    $('#remove-banner').click(function() {
        if ($('#remove-banner').prop('checked') == true) {
            $('#image2').val('');
        }
    });
</script>
@include('backend.master.fields.input')

@include('includes.button-fm')
@include('includes.tinymce-fm')
@endsection