@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
<script src="{{ asset('assets/backend/wysiwyg/tinymce.min.js') }}"></script>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="card mb-4 col-md-10">
        <h6 class="card-header">
        Form Media
        </h6>
        <form action="{{ route('catalog.product.media.update', ['productId' => $data['product']->id, 'id' => $data['media']->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body pb-2">
                <input type="hidden" name="is_video" value="{{ $data['media']->is_video }}">
                <input type="hidden" name="is_youtube" value="{{ $data['media']->is_youtube }}">
                @if ($data['media']->is_video == 1 && $data['media']->is_youtube == 1)    
                <div class="form-group row">
                    <label class="col-form-label col-sm-2 text-sm-right">Youtube ID</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control mb-1 @error('youtube_id') is-invalid @enderror" name="youtube_id" 
                            value="{{ old('youtube_id', $data['media']->youtube_id) }}" placeholder="Enter youtube id...">
                        @include('components.field-error', ['field' => 'youtube_id'])
                    </div>
                </div>
                @endif
                @if ($data['media']->is_youtube == 0)
                <div class="form-group row" id="file">
                    <div class="col-md-2 text-md-right">
                        <label class="col-form-label text-sm-right">File</label>
                    </div>
                    <div class="col-md-10">
                        <label class="custom-file-label" for="file-0"></label>
                        <input type="hidden" name="old_file" value="{{ $data['media']->file }}">
                        <input class="form-control custom-file-input file @error('file') is-invalid @enderror" type="file" id="file-0" lang="en" name="file" placeholder="enter file...">
                        @include('components.field-error', ['field' => 'file'])
                        <span class="text-muted">Type of file : <strong>{{ $data['media']->is_video == 0 ? config('custom.files.product.mimes') : config('custom.files.product.mimes_video') }}</strong>, Pixel : <strong>{{ config('custom.files.banner.pixel') }}</strong></span>
                    </div>
                </div>
                @endif
                @if ($data['media']->is_video == 1 && $data['media']->is_youtube == 0)
                <div class="form-group row">
                    <div class="col-md-2 text-md-right">
                        <label class="col-form-label text-sm-right">Thumbnail</label>
                    </div>
                    <div class="col-md-10">
                        <label class="custom-file-label" for="file-1"></label>
                        <input type="hidden" name="old_thumbnail" value="{{ $data['media']->thumbnail }}">
                        <input class="form-control custom-file-input file @error('thumbnail') is-invalid @enderror" type="file" id="file-1" lang="en" name="thumbnail" placeholder="enter thumbnail...">
                        @include('components.field-error', ['field' => 'thumbnail'])
                        <span class="text-muted">Type of file : <strong>{{ config('custom.files.product.thumbnail.mimes') }}</strong>, Pixel : <strong>{{ config('custom.files.product.pixel') }}</strong></span>
                    </div>
                </div>
                @endif
                <div class="form-group row">
                    <label class="col-form-label col-sm-2 text-sm-right">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control mb-1 gen_slug @error('title') is-invalid @enderror"
                            name="title" value="{{ old('title', $data['media']->caption['title']) }}" placeholder="Enter title...">
                        @include('components.field-error', ['field' => 'title'])
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-2 text-sm-right">Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control tiny-mce" name="description">{!! old('description', $data['media']->caption['description']) !!}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-2 text-sm-right">Image ALT</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control mb-1" name="alt" value="{{ old('alt', $data['media']->caption['alt']) }}" placeholder="Enter alt...">
                    </div>
                </div>
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
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/backend/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
@endsection

@section('jsbody')
@include('includes.tinymce-fm')
@endsection