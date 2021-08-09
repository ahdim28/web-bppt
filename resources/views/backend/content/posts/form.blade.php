@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/css/pages/account.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
<script src="{{ asset('assets/backend/admin.js') }}"></script>
<script src="{{ asset('assets/backend/wysiwyg/tinymce.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/backend/fancybox/fancybox.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/timepicker/timepicker.css') }}">
<script src="{{ asset('assets/backend/css/typehead.css') }}"></script>
@endsection

@section('content')
<div class="card">
    <div class="list-group list-group-flush account-settings-links flex-row">
        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#content">CONTENT</a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#setting">SETTING</a>
        @if ($data['section']->extra == 1)
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#files">FILES</a>
        @endif
        @if ($data['section']->extra == 2)
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#profiles">PROFILES</a>
        @endif
        @if ($data['fields']->count() > 0)
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#field">CUSTOM FIELD</a>
        @endif
    </div>
    <form action="{{ route('post.store', ['sectionId' => $data['section']->id]) }}" method="POST" enctype="multipart/form-data">
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
                                                <input type="text" class="form-control mb-1 gen_slug @error('title_'.$lang->iso_codes) is-invalid @enderror" lang="{{ $lang->iso_codes }}" 
                                                    name="title_{{ $lang->iso_codes }}" value="{{ old('title_'.$lang->iso_codes) }}" placeholder="Enter title...">
                                                @include('components.field-error', ['field' => 'title_'.$lang->iso_codes])
                                            </div>
                                        </div>
                                        @if ($lang->iso_codes == config('custom.language.default'))
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2 text-sm-right">Slug</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><strong>{{ url('/').'/'.$data['section']->slug.'/' }}</strong></span>
                                                    </div>
                                                    <input type="text" class="form-control slug_spot @error('slug') is-invalid @enderror" lang="{{ $lang->iso_codes }}" name="slug"
                                                        value="{{ old('slug') }}" placeholder="Enter slug...">
                                                    @include('components.field-error', ['field' => 'slug'])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2 text-sm-right">Category</label>
                                            <div class="col-sm-10">
                                                <select class="selectpicker custom-select" name="category_id" data-style="btn-default">
                                                    {{-- <option value=" " selected disabled>Select</option> --}}
                                                    @foreach ($data['categories'] as $category)
                                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{!! $category->fieldLang('name') !!}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block;color:red;">{!! $message !!}</label>
                                                @enderror
                                            </div>
                                        </div>
                                        @endif
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2 text-sm-right">Intro</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control tiny-mce" name="intro_{{ $lang->iso_codes }}">{!! old('intro_'.$lang->iso_codes) !!}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2 text-sm-right">Content</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control tiny-mce" name="content_{{ $lang->iso_codes }}">{!! old('content_'.$lang->iso_codes) !!}</textarea>
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
                        <label class="col-form-label col-sm-2 text-sm-right">Status</label>
                        <div class="col-sm-10">
                            <select class="selectpicker show-tick" name="publish" data-style="btn-default">
                                @foreach (config('custom.label.publish') as $key => $publish)
                                    <option value="{{ $key }}" {{ (old('publish') == ''.$key.'') ? 'selected' : '' }}>
                                        {{ __($publish['title']) }}
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
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">Tags</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control bs-tagsinput @error('tags') is-invalid @enderror" name="tags">
                            <small><i>*Separated by comma (,). Example : foods, tech,</i></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">Publish Time</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" class="datetime-picker form-control @error('created_at') is-invalid @enderror" name="created_at"
                                    value="{{ old('created_at', now()) }}" placeholder="enter publish time...">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="las la-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
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
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">Custom View</label>
                        <div class="col-sm-10">
                            <select class="selectpicker show-tick" name="custom_view_id" data-style="btn-default">
                                <option value=" " selected>DEFAULT</option>
                                @foreach ($data['template'] as $custom)
                                    <option value="{{ $custom->id }}" {{ (old('custom_view_id') == $custom->id) ? 'selected' : '' }}>
                                        {{ $custom->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">Meta Title</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control mb-1" name="meta_title" value="{{ old('meta_title') }}" placeholder="Enter meta title...">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">Meta Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control mb-1" name="meta_description" placeholder="Separated by comma (,)">{{ old('meta_decsription') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">Meta Keywords</label>
                        <div class="col-sm-10">
                            <input class="form-control mb-1" name="meta_keywords" id="bs-tagsinput-2" value="{{ old('meta_keywords') }}" placeholder="">
                            <small><i>* Separated by comma(,)</i></small>
                        </div>
                    </div>
                </div>
            </div>

            @if ($data['section']->extra == 1)
            <div class="tab-pane fade" id="files">
                <div class="card-body">
                    <div class="form-group row">
                        <div class="table-responsive">
                            <table id="user-list" class="table card-table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th id="add-file" colspan="4">
                                            <div class="text-center">
                                                <button type="button" id="add" class="btn btn-success btn-block mb-2"><i class="las la-plus"></i>Files</button>
                                                <span class="text-muted">
                                                    File Type : <strong>{{ Str::upper(config('custom.files.post_files.mimes')) }}</strong>, 
                                                    Max Size : <strong>{{ Str::upper(config('custom.files.post_files.size')) }} Kilobyte</strong>
                                                </span>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="list-files">
                                    <tr>
                                        <td style="width: 250px;">
                                            <label class="col-form-label text-sm-left">File</label>
                                            <label class="custom-file-label" for="file-0"></label>
                                            <input class="form-control custom-file-input file @error('files.0') is-invalid @enderror" type="file" id="file-0" lang="en" name="files[]" placeholder="enter file...">
                                            @include('components.field-error', ['field' => 'files.0'])
                                            
                                        </td>
                                        <td style="width: 150px;">
                                            <label class="col-form-label text-sm-left">Title</label>
                                            <input type="text" class="form-control mb-1" name="file_title_0" value="{{ old('file_title_0') }}" placeholder="Enter title...">
                                        </td>
                                        <td style="width: 150px;">
                                            <label class="col-form-label text-sm-right">Description</label>
                                            <textarea class="form-control mb-1" name="file_description_0" placeholder="Enter description">{{ old('file_decsription_0') }}</textarea>
                                        </td>
                                        <td class="text-center" style="width: 10px;">
                                            <button type="button" class="btn btn-secondary icon-btn" disabled><i class="las la-times"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if ($data['section']->extra == 2)
            <div class="tab-pane fade" id="profiles">
                <div class="card-body">
                    @foreach (config('custom.columns.profile_posts') as $keyP => $valP)
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">{{ $valP['label'] }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control mb-1 @error('profile_'.$valP['name']) is-invalid @enderror" name="profile_{{ $valP['name'] }}" value="{{ old('profile_'.$valP['name']) }}" placeholder="Enter {{ $valP['label'] }}...">
                            @include('components.field-error', ['field' => 'profile_'.$valP['name']])
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

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
<script src="{{ asset('assets/backend/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/backend/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
<script src="{{ asset('assets/backend/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/backend/vendor/libs/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.js') }}"></script>
<script src="{{ asset('assets/backend/vendor/libs/timepicker/timepicker.js') }}"></script>
<script src="{{ asset('assets/backend/typehead.js') }}"></script>
@endsection

@section('jsbody')
<script src="{{ asset('assets/backend/js/pages_account-settings.js') }}"></script>
<script src="{{ asset('assets/backend/js/forms_selects.js') }}"></script>
<script>
    //datetime
    $('.datetime-picker').bootstrapMaterialDatePicker({
        date: true,
        shortTime: false,
        format: 'YYYY-MM-DD HH:mm'
    });

    //select
    $('.select2').select2();

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

    //Tagsinput
    $(function() {

        var tagsname = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: {
                url: '/api/tags.json',
                filter: function(list) {
                return $.map(list, function(tagsname) {
                    return { name: tagsname }; });
                }
            }
        });
        tagsname.initialize();

        $('.bs-tagsinput').tagsinput({
            // tagClass: 'badge badge-primary',
            typeaheadjs: {
                name: 'tagsname',
                displayKey: 'name',
                valueKey: 'name',
                source: tagsname.ttAdapter()
            }
        });

    });
</script>

@if ($data['section']->extra == 1)
<script>
    $(function()  {

        var no=1;
        $("#add").click(function() {

            $("#list-files").append(`
                <tr class="num-list" id="delete-`+no+`">
                    <td style="width: 250px;">
                        <label class="col-form-label text-sm-left">File</label>
                        <label class="custom-file-label" for="file-`+no+`"></label>
                        <input class="form-control custom-file-input file @error('files.`+no+`') is-invalid @enderror" type="file" id="file-`+no+`" lang="en" name="files[]" placeholder="enter file...">
                        @include('components.field-error', ['field' => 'files.`+no+`'])
                        
                    </td>
                    <td style="width: 150px;">
                        <label class="col-form-label text-sm-left">Title</label>
                        <input type="text" class="form-control mb-1" name="file_title_`+no+`" value="{{ old('file_title_`+no+`') }}" placeholder="Enter title...">
                    </td>
                    <td style="width: 150px;">
                        <label class="col-form-label text-sm-right">Description</label>
                        <textarea class="form-control mb-1" name="file_description_`+no+`" placeholder="Enter description">{{ old('file_decsription_`+no+`') }}</textarea>
                    </td>
                    <td class="text-center" style="width: 10px;">
                        <button type="button" id="remove" class="btn btn-danger icon-btn" data-id="`+no+`"><i class="las la-times"></i></button>
                    </td>
                </tr>
            `);

            var noOfColumns = $('.num-list').length;
            var maxNum = 19;
            if (noOfColumns < maxNum) {
                $("#add-file").show();
            } else {
                $("#add-file").hide();
            }

            // FILE BROWSE
            function callfileBrowser() {
                $(".custom-file-input").on("change", function() {
                    const fileName = Array.from(this.files).map((value, index) => {
                        if (this.files.length == index + 1) {
                            return value.name
                        } else {
                            return value.name + ', '
                        }
                    });
                    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                });
            }
            callfileBrowser();

            no++;

        });

    });

    $(document).on('click', '#remove', function() {
        var id = $(this).attr("data-id");
        $("#delete-"+id).remove();
    });
</script>
@endif

@include('backend.master.fields.input')

@include('includes.button-fm')
@include('includes.tinymce-fm')
@endsection