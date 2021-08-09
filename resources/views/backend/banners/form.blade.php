@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
<script src="{{ asset('assets/backend/wysiwyg/tinymce.min.js') }}"></script>
@endsection

@section('content')
<div class="card mb-4">
    <h6 class="card-header">
      Form Banner
    </h6>
    <form action="{{ route('banner.store', ['categoryId' => $data['category']->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
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
                                @if ($lang->iso_codes == config('custom.language.default'))
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 text-sm-right">Video</label>
                                    <div class="col-sm-10">
                                        <label class="custom-control custom-checkbox m-0">
                                            <input type="checkbox" class="custom-control-input" id="is_video" name="is_video" value="1">
                                            <span class="custom-control-label ml-4">YES</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row" id="from_youtube">
                                    <label class="col-form-label col-sm-2 text-sm-right">From Youtube</label>
                                    <div class="col-sm-10">
                                        <label class="custom-control custom-checkbox m-0">
                                            <input type="checkbox" class="custom-control-input" id="is_youtube" name="is_youtube" value="1">
                                            <span class="custom-control-label ml-4">YES</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row" id="youtube_id">
                                    <label class="col-form-label col-sm-2 text-sm-right">Youtube ID</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control mb-1 @error('youtube_id') is-invalid @enderror" name="youtube_id" 
                                            value="{{ old('youtube_id') }}" placeholder="Enter youtube id...">
                                        @include('components.field-error', ['field' => 'youtube_id'])
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
                                            File Type : <strong>{{ config('custom.files.banner.mimes').','.config('custom.files.banner.mimes_video') }}</strong>, 
                                            Pixel : <strong>{{ config('custom.files.banner.pixel') }}</strong>,
                                            Max Size : <strong>{{ config('custom.files.banner.size') }} Kilobyte</strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row" id="thumbnail">
                                    <div class="col-md-2 text-md-right">
                                        <label class="col-form-label text-sm-right">Thumbnail</label>
                                    </div>
                                    <div class="col-md-10">
                                        <label class="custom-file-label" for="file-1"></label>
                                        <input class="form-control custom-file-input file @error('thumbnail') is-invalid @enderror" type="file" id="file-1" lang="en" name="thumbnail" placeholder="enter thumbnail...">
                                        @include('components.field-error', ['field' => 'thumbnail'])
                                        <span class="text-muted">
                                            File Type : <strong>{{ config('custom.files.banner.thumbnail.mimes').','.config('custom.files.banner.mimes_video') }}</strong>, 
                                            Pixel : <strong>{{ config('custom.files.banner.thumbnail.pixel') }}</strong>,
                                            Max Size : <strong>{{ config('custom.files.banner.thumbnail.size') }} Kilobyte</strong>
                                        </span>
                                    </div>
                                </div>
                                @endif
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 text-sm-right">Title</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control mb-1 gen_slug @error('title_'.$lang->iso_codes) is-invalid @enderror" lang="{{ $lang->iso_codes }}" 
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
                                    <label class="col-form-label col-sm-2 text-sm-right">Image ALT</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control mb-1" name="alt" value="{{ old('alt') }}" placeholder="Enter alt...">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 text-sm-right">URL</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control mb-1" name="url" value="{{ old('url') }}" placeholder="Enter url...">
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
<script>
    $(document).ready(function() {
        $('#from_youtube').hide();
        $('#youtube_id').hide();
        $('#thumbnail').hide();
        $('#is_video').change(function() {

            if(this.checked) {
                $('#from_youtube').show();
                $('#thumbnail').show();

                $('#is_youtube').change(function() {
                    if(this.checked) {
                        $('#youtube_id').show();
                        $('#file').hide();
                        $('#thumbnail').hide();
                    } else {
                        $('#youtube_id').hide();
                        $('#file').show();
                        $('#thumbnail').show();
                    }
                });
            } else {
                $('#from_youtube').hide();
                $('#thumbnail').hide();
            }

        });
    });
</script>

@include('includes.tinymce-fm')
@endsection