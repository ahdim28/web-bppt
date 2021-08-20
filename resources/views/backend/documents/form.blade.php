@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/css/pages/account.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
<script src="{{ asset('assets/backend/admin.js') }}"></script>
<script src="{{ asset('assets/backend/wysiwyg/tinymce.min.js') }}"></script>
@endsection

@section('content')
<div class="card">
    <div class="list-group list-group-flush account-settings-links flex-row">
        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#content">CONTENT</a>
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#setting">SETTING</a>
    </div>
    <form action="{{ route('document.store', ['categoryId' => $data['category']->id]) }}" method="POST" enctype="multipart/form-data">
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
                                                    name="title_{{ $lang->iso_codes }}" value="{{ old('title_'.$lang->iso_codes) }}" placeholder="Enter name...">
                                                @include('components.field-error', ['field' => 'title_'.$lang->iso_codes])
                                            </div>
                                        </div>
                                        @if ($lang->iso_codes == config('custom.language.default'))
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2 text-sm-right">Slug</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><strong>{{ url('/').'/dokumen/'.$data['category']->slug.'/' }}</strong></span>
                                                    </div>
                                                    <input type="text" class="form-control slug_spot @error('slug') is-invalid @enderror" lang="{{ $lang->iso_codes }}" name="slug"
                                                        value="{{ old('slug') }}" placeholder="Enter slug...">
                                                    @include('components.field-error', ['field' => 'slug'])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="from">
                                            <label class="col-form-label col-sm-2 text-sm-right">From URL</label>
                                            <div class="col-sm-10">
                                                <label class="custom-control custom-checkbox m-0">
                                                    <input type="checkbox" class="custom-control-input" id="from_url" name="from" value="1">
                                                    <span class="custom-control-label ml-4">YES</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="file">
                                            <div class="col-md-2 text-md-right">
                                                <label class="col-form-label text-sm-right">File</label>
                                            </div>
                                            <div class="col-md-10">
                                                <label class="custom-file-label" for="file-0"></label>
                                                <input class="form-control custom-file-input file @error('file') is-invalid @enderror" type="file" id="file-0" lang="en" name="file" placeholder="enter file...">
                                                @include('components.field-error', ['field' => 'file'])
                                                <span class="text-muted">
                                                    File Type : <strong>{{ config('custom.files.edocman.mimes') }}</strong>,
                                                    Max Size : <strong>{{ config('custom.files.edocman.size') }}</strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="document_url">
                                            <label class="col-form-label col-sm-2 text-sm-right">Document URL</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <input type="text" class="form-control @error('document_url') is-invalid @enderror" id="image1" aria-label="Image" aria-describedby="button-image" name="document_url"
                                                            value="{{ old('document_url') }}" placeholder="browse file...">
                                                    <div class="input-group-append" title="browse file">
                                                        <button class="btn btn-primary file-name" id="button-image" type="button"><i class="las la-image"></i>&nbsp; Browse</button>
                                                    </div>
                                                    @include('components.field-error', ['field' => 'document_url'])
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
                    <hr>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">Cover</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" class="form-control" id="image2" aria-label="Image2" aria-describedby="button-image2" name="cover_file"
                                        value="{{ old('cover_file') }}" placeholder="browse cover..." readonly>
                                <div class="input-group-append" title="browse file">
                                    <span class="input-group-text">
                                        <input type="checkbox" id="remove-cover" value="1">&nbsp; Remove
                                    </span>
                                    <button class="btn btn-primary file-name" id="button-image2" type="button"><i class="las la-image"></i>&nbsp; Browse</button>
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
@endsection

@section('jsbody')
<script src="{{ asset('assets/backend/js/pages_account-settings.js') }}"></script>
<script>
    $('#remove-cover').click(function() {
        if ($('#remove-cover').prop('checked') == true) {
            $('#image2').val('');
        }
    });

    $(document).ready(function() {
        $('#file').show();
        $('#document_url').hide();
        $('#from_url').change(function() {

            if(this.checked) {
                $('#file').hide();
                $('#document_url').show();
            } else {
                $('#file').show();
                $('#document_url').hide();
            }

        });
    });
</script>

@include('includes.button-fm')
@include('includes.tinymce-fm')
@endsection