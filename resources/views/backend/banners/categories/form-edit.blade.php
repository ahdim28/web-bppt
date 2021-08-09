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
        @if ($data['fields']->count() > 0 || !empty($data['category']->field_category_id) || Auth::user()->hasRole('super'))
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#field">CUSTOM FIELD</a>
        @endif
    </div>
    <form action="{{ route('banner.category.update', ['id' => $data['category']->id]) }}" method="POST">
        @csrf
        @method('PUT')
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
                                            <label class="col-form-label col-sm-2 text-sm-right">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control mb-1 @error('name_'.$lang->iso_codes) is-invalid @enderror" lang="{{ $lang->iso_codes }}" 
                                                    name="name_{{ $lang->iso_codes }}" value="{{ old('name_'.$lang->iso_codes, $data['category']->fieldLang('name', $lang->iso_codes)) }}" placeholder="Enter name...">
                                                @include('components.field-error', ['field' => 'name_'.$lang->iso_codes])
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2 text-sm-right">Description</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control tiny-mce" name="description_{{ $lang->iso_codes }}">{!! old('description_'.$lang->iso_codes, $data['category']->fieldLang('description', $lang->iso_codes)) !!}</textarea>
                                            </div>
                                        </div>
                                        @if ($lang->iso_codes == config('custom.language.default'))
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2 text-sm-right">Banner Limit</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control mb-1" name="banner_limit"  value="{{ old('banner_limit', $data['category']->banner_limit) }}" placeholder="Enter banner limit...">
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

            @if (!empty($data['category']->field_category_id) || Auth::user()->hasRole('super'))
            <div class="tab-pane fade" id="field">
                <div class="card-body">
                    @role ('super')    
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">Field</label>
                        <div class="col-sm-10">
                            <select id="field_category" class="selectpicker show-tick" name="field_category_id" data-style="btn-default">
                                <option value=" " selected>Select</option>
                                @foreach ($data['fields'] as $field)
                                    <option value="{{ $field->id }}" {{ $field->id == $data['category']->field_category_id ? 'selected' : '' }}>
                                        {{ $field->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if (!empty($data['category']->field_category_id))    
                            <small>Current Field : <strong><i>{{ $data['category']->field->name }}</i></strong></small>
                            @endif
                        </div>
                    </div>
                    <div id="custom_field">

                    </div>
                    @else
                    <input type="hidden" name="field_category_id" value="{{ $data['category']->field_category_id }}">
                    @endrole

                    @if (!empty($data['category']->field_category_id))
                    <div id="current_field">
                        @include('backend.master.fields.input-edit', ['module' => 'category'])
                    </div>
                    @endif
                </div>
            </div>
            @endif

        </div>
        <div class="card-footer text-center">
            <button type="submit" class="btn btn-primary" name="action" value="back" title="@lang('lang.save_change')">
                <i class="las la-save"></i> @lang('lang.save_change')
            </button>&nbsp;&nbsp;
            <button type="submit" class="btn btn-danger" name="action" value="exit" title="@lang('lang.save_change_exit')">
                <i class="las la-save"></i> @lang('lang.save_change_exit')
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