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
    <form action="{{ route('section.store') }}" method="POST">
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
                                            <label class="col-form-label col-sm-2 text-sm-right">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control mb-1 gen_slug @error('name_'.$lang->iso_codes) is-invalid @enderror" lang="{{ $lang->iso_codes }}" 
                                                    name="name_{{ $lang->iso_codes }}" value="{{ old('name_'.$lang->iso_codes) }}" placeholder="Enter name...">
                                                @include('components.field-error', ['field' => 'name_'.$lang->iso_codes])
                                            </div>
                                        </div>
                                        @if ($lang->iso_codes == config('custom.language.default'))
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2 text-sm-right">Slug</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><strong>{{ url('/').'/' }}</strong></span>
                                                    </div>
                                                    <input type="text" class="form-control slug_spot @error('slug') is-invalid @enderror" lang="{{ $lang->iso_codes }}" name="slug"
                                                        value="{{ old('slug') }}" placeholder="Enter slug...">
                                                    @include('components.field-error', ['field' => 'slug'])
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2 text-sm-right">Description</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control tiny-mce" name="description_{{ $lang->iso_codes }}">{!! old('description_'.$lang->iso_codes) !!}</textarea>
                                            </div>
                                        </div>
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
                        <label class="col-form-label col-sm-2 text-sm-right">Extra</label>
                        <div class="col-sm-10">
                            <select class="custom-select" name="extra" data-style="btn-default">
                                @foreach (config('custom.label.extra') as $key => $extra)
                                    <option value="{{ $key }}" {{ (old('extra') == ''.$key.'') ? 'selected' : '' }}>
                                        {{ $extra['title'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">Order Field</label>
                        <div class="col-sm-10">
                            <select class="custom-select" name="order_field" data-style="btn-default">
                                @foreach (config('custom.filtering.ordering_field_posts') as $key => $value)
                                    <option value="{{ $value }}" {{ (old('order_field') == $value) ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">Order By</label>
                        <div class="col-sm-10">
                            <select class="custom-select" name="order_by" data-style="btn-default">
                                @foreach (config('custom.filtering.ordering') as $key => $ordering)
                                    <option value="{{ $ordering['title'] }}" {{ (old('order_by') == $ordering['title']) ? 'selected' : '' }}>
                                        {{ $ordering['description'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Public</label>
                        </div>
                        <div class="col-md-10">
                            <label class="switcher switcher-success">
                                <input type="checkbox" class="switcher-input check-parent" name="public" value="1" 
                                    {{ (old('public') == 1 ? 'checked' : 'checked') }}>
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
                    <div class="form-group row">
                        <div class="col-md-2 text-md-right">
                          <label class="col-form-label text-sm-right">Detail</label>
                        </div>
                        <div class="col-md-10">
                            <label class="switcher switcher-success">
                                <input type="checkbox" class="switcher-input check-parent" name="is_detail" value="1" 
                                    {{ (old('is_detail') == 1 ? 'checked' : 'checked') }}>
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
                    <hr>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">Banner</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" class="form-control" id="image1" aria-label="Image" aria-describedby="button-image" name="banner_file"
                                        value="{{ old('banner_file') }}" placeholder="browse banner..." readonly>
                                <div class="input-group-append" title="browse file">
                                    <span class="input-group-text">
                                        <input type="checkbox" id="remove-banner" value="1">&nbsp; Remove
                                    </span>
                                    <button class="btn btn-primary file-name" id="button-image" type="button"><i class="las la-image"></i>&nbsp; Browse</button>
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
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">List View</label>
                        <div class="col-sm-10">
                            <select class="selectpicker show-tick" name="list_view_id" data-style="btn-default">
                                <option value=" " selected>DEFAULT</option>
                                @foreach ($data['template_list'] as $custom)
                                    <option value="{{ $custom->id }}" {{ (old('list_view_id') == $custom->id) ? 'selected' : '' }}>
                                        {{ $custom->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">Detail View</label>
                        <div class="col-sm-10">
                            <select class="selectpicker show-tick" name="detail_view_id" data-style="btn-default">
                                <option value=" " selected>DEFAULT</option>
                                @foreach ($data['template_detail'] as $custom)
                                    <option value="{{ $custom->id }}" {{ (old('detail_view_id') == $custom->id) ? 'selected' : '' }}>
                                        {{ $custom->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">Content Limit <i>(category)</i></label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="limit_category" value="{{ old('limit_category') }}" placeholder="for category">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">Content Limit <i>(post)</i></label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="limit_post" value="{{ old('limit_post') }}" placeholder="for post">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">Post Selection</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="post_selection" value="{{ old('post_selection') }}" placeholder="for post">
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
    $('#remove-banner').click(function() {
        if ($('#remove-banner').prop('checked') == true) {
            $('#image1').val('');
        }
    });
</script>
@include('backend.master.fields.input')

@include('includes.button-fm')
@include('includes.tinymce-fm')
@endsection