@extends('layouts.backend.layout')

@section('content')
<div class="row justify-content-center">
    <div class="card mb-4 col-md-10">
        <h6 class="card-header">
            @lang('lang.form_attr', [
                'attribute' => __('mod/master.media.caption')
            ])
        </h6>
        <form action="{{ !isset($data['media']) ? $data['routeStore'] : $data['routeUpdate'] }}" method="POST">
            <div class="card-body">
                @csrf
                @isset ($data['media'])
                    @method('PUT')
                    <input type="hidden" id="from_youtube" value="{{ $data['media']->is_youtube }}">
                @endisset
                <div class="form-group row">
                    <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/master.media.label.field1')</label>
                    <div class="col-sm-10">
                        <label class="custom-control custom-checkbox m-0">
                            <input type="checkbox" class="custom-control-input" id="is_youtube" name="is_youtube" value="1" {{ !isset($data['media']) ? '' : ($data['media']->is_youtube == 1 ? 'checked' : '') }}>
                            <span class="custom-control-label ml-4">@lang('mod/master.media.placeholder.field1')</span>
                        </label>
                    </div>
                </div>
                <div class="form-group row" id="youtube_id">
                    <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/master.media.label.field4')</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control mb-1 @error('youtube_id') is-invalid @enderror" name="youtube_id" 
                            value="{{ !isset($data['media']) ? old('youtube_id') : old('youtube_id', $data['media']->youtube_id) }}" placeholder="@lang('mod/master.media.placeholder.field1')">
                        @include('components.field-error', ['field' => 'youtube_id'])
                    </div>
                </div>
                <div id="files">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/master.media.label.field2')</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" class="form-control @error('filename') is-invalid @enderror" id="image1" aria-label="Image" aria-describedby="button-image" name="filename"
                                        value="{{ !isset($data['media']) ? old('filename') : old('filename', $data['media']->file_path['filename']) }}" placeholder="@lang('lang.browse')" readonly>
                                <div class="input-group-append" title="browse file">
                                    <span class="input-group-text">
                                        <input type="checkbox" id="remove-file" value="1">&nbsp; @lang('lang.remove')
                                    </span>
                                    <button class="btn btn-primary file-name" id="button-image" type="button"><i class="las la-file"></i>&nbsp; Browse</button>
                                </div>
                                @include('components.field-error', ['field' => 'filename'])
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/master.media.label.field3')</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" class="form-control" id="image2" aria-label="Image2" aria-describedby="button-image2" name="thumbnail"
                                        value="{{ !isset($data['media']) ? old('thumbnail') : old('thumbnail', $data['media']->file_path['thumbnail']) }}" placeholder="@lang('lang.browse')" readonly>
                                <div class="input-group-append" title="browse thumbnail">
                                    <span class="input-group-text">
                                        <input type="checkbox" id="remove-thumbnail" value="1">&nbsp; @lang('lang.remove')
                                    </span>
                                    <button class="btn btn-primary file-name" id="button-image2" type="button"><i class="las la-image"></i>&nbsp; Browse</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/master.media.label.field5')</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control mb-1 @error('title') is-invalid @enderror" name="title" 
                        value="{{ !isset($data['media']) ? old('title') : old('title', $data['media']->caption['title']) }}" placeholder="@lang('mod/master.media.placeholder.field5').">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/master.media.label.field6')</label>
                    <div class="col-sm-10">
                        <textarea class="form-control tiny-mce" name="description" placeholder="@lang('mod/master.media.placeholder.field6')">{!! !isset($data['media']) ? old('description') : old('description', $data['media']->caption['description']) !!}</textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary" name="action" value="back" title="{{ isset($data['media']) ? __('lang.save_change') : __('lang.save') }}">
                    <i class="las la-save"></i> {{ isset($data['media']) ? __('lang.save_change') : __('lang.save') }}
                </button>&nbsp;&nbsp;
                <button type="submit" class="btn btn-danger" name="action" value="exit" title="{{ isset($data['media']) ? __('lang.save_change_exit') : __('lang.save_exit') }}">
                    <i class="las la-save"></i> {{ isset($data['media']) ? __('lang.save_change_exit') : __('lang.save_exit') }}
                </button>&nbsp;&nbsp;
                <button type="reset" class="btn btn-secondary" title="{{ __('lang.reset') }}">
                <i class="las la-redo-alt"></i> {{ __('lang.reset') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('jsbody')
<script>
    $('#remove-file').click(function() {
        if ($('#remove-file').prop('checked') == true) {
            $('#image1').val('');
        }
    });
    $('#remove-thumbnail').click(function() {
        if ($('#remove-thumbnail').prop('checked') == true) {
            $('#image2').val('');
        }
    });
</script>
@if (!isset($data['media']))    
<script>
    $(document).ready(function() {
        $('#youtube_id').hide();
        $('#files').show();
        $('#is_youtube').change(function() {

            if(this.checked) {
                $('#youtube_id').show();
                $('#files').hide();
            } else {
                $('#youtube_id').hide();
                $('#files').show();
            }    
            
        });
    });
</script>
@else
<script>
    $(document).ready(function() {
        var is_youtube = $('#from_youtube').val();
        if (is_youtube == 0) {
            $('#youtube_id').hide();
            $('#files').show();
        } else {
            $('#youtube_id').show();
            $('#files').hide();
        }

        $('#is_youtube').change(function() {

            if(this.checked) {
                $('#youtube_id').show();
                $('#files').hide();
            } else {
                $('#youtube_id').hide();
                $('#files').show();
            }    

        });
    });
</script>
@endif

@include('includes.button-fm')
@endsection