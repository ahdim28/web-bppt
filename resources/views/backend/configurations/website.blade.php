@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/fancybox/fancybox.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/css/pages/account.css') }}">
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="card mb-4 col-md-10 overflow-hidden">
        <div class="row no-gutters row-bordered row-border-light">
            <div class="col-md-3 pt-0">
                <div class="list-group list-group-flush account-settings-links">
                <a class="list-group-item list-group-item-action {{ (Request::get('tab') == 'upload') ? 'active' : '' }}" href="{{ route('configuration.website', ['tab' => 'upload']) }}" 
                    title="@lang('mod/setting.config.tabs.1')">
                    @lang('mod/setting.config.tabs.1')
                </a>
                <a class="list-group-item list-group-item-action {{ empty(Request::get('tab')) ? 'active' : '' }}" href="{{ route('configuration.website') }}" 
                    title="@lang('mod/setting.config.tabs.2')">
                    @lang('mod/setting.config.tabs.2')
                </a>
                <a class="list-group-item list-group-item-action {{ (Request::get('tab') == 'meta-data') ? 'active' : '' }}" href="{{ route('configuration.website', ['tab' => 'meta-data']) }}"
                    title="@lang('mod/setting.config.tabs.3')">
                    @lang('mod/setting.config.tabs.3')
                </a>
                <a class="list-group-item list-group-item-action {{ (Request::get('tab') == 'social-media') ? 'active' : '' }}" href="{{ route('configuration.website', ['tab' => 'social-media']) }}"
                    title="@lang('mod/setting.config.tabs.4')">
                    @lang('mod/setting.config.tabs.4')
                </a>
                <a class="list-group-item list-group-item-action {{ (Request::get('tab') == 'custom') ? 'active' : '' }}" href="{{ route('configuration.website', ['tab' => 'custom']) }}"
                    title="Custom">
                    Custom
                </a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="tab-content">

                    {{-- upload --}}
                    <div class="tab-pane fade {{ (Request::get('tab') == 'upload') ? 'show active' : '' }}">
                        @foreach ($data['upload'] as $upload)
                        <div class="card-body media align-items-center">
                            @if ($upload->name != 'google_analytics_api' && $upload->name != 'panduan_identitas')
                                <a href="{{ $upload->file($upload->name) }}" data-fancybox="gallery" title="Click to view image">
                                    <img src="{{ $upload->file($upload->name) }}" alt="" class="d-block ui-w-80">
                                </a>
                            @else
                                <i class="las la-file display-4 text-primary mr-4"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            @endif
                            <div class="media-body ml-4" title="Click to change image / file">
                                <form id="upload-{{ $upload->name }}" action="{{ route('configuration.website.upload', ['name' => $upload->name]) }}" 
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <label class="btn btn-outline-primary">
                                        {{ $upload->label }}
                                        <input type="hidden" name="old_{{ $upload->name }}" value="{{ $upload->value }}">
                                        <input type="file" id="{{ $upload->name }}" name="{{ $upload->name }}" class="account-settings-fileinput">
                                    </label>
                                </form>

                                <div class="text-light small mt-1">
                                    @if ($upload->name != 'google_analytics_api')
                                        File Type : <strong>{{ Str::upper(config('custom.files.config.'.$upload->name.'.mimes')) }}</strong>,
                                        Pixel : <strong>{{ Str::upper(config('custom.files.config.'.$upload->name.'.pixel')) }}</strong> ,
                                        Max Size : <strong>{{ Str::upper(config('custom.files.config.'.$upload->name.'.size')) }} Kilobyte</strong>
                                    @else
                                        File Type <strong>JSON</strong> Only.
                                    @endif
                                </div>
                                @error($upload->name)
                                <div class="small mt-1" style="color:#d9534f;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- General --}}
                    <div class="tab-pane fade {{ empty(Request::get('tab')) ? 'show active' : '' }}">
                        <form action="{{ route('configuration.website.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                            @foreach ($data['general'] as $general)
                            <div class="form-group">
                                <label class="form-label">{{ $general->label }}</label>
                                <textarea class="form-control mb-1" name="name[{{ $general->name }}]" placeholder="Enter value...">{!! old($general->name, $general->value) !!}</textarea>
                            </div>
                            @endforeach
                            <hr>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary" title="@lang('lang.save_change')">
                                    <i class="las la-save"></i> @lang('lang.save_change')
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- meta --}}
                    <div class="tab-pane fade {{ (Request::get('tab') == 'meta-data') ? 'show active' : '' }}">
                        <form action="{{ route('configuration.website.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                            @foreach ($data['meta_data'] as $meta)
                            <div class="form-group">
                                <label class="form-label">{{ $meta->label }}</label>
                                <textarea class="form-control mb-1" name="name[{{ $meta->name }}]" placeholder="Enter value...">{!! old($meta->name, $meta->value) !!}</textarea>
                            </div>
                            @endforeach
                            <hr>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary" title="@lang('lang.save_change')">
                                    <i class="las la-save"></i> @lang('lang.save_change')
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- socmed --}}
                    <div class="tab-pane fade {{ (Request::get('tab') == 'social-media') ? 'show active' : '' }}">
                        <form action="{{ route('configuration.website.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                            @foreach ($data['social_media'] as $socmed)
                            <div class="form-group">
                                <label class="form-label">{{ $socmed->label }}</label>
                                <textarea class="form-control mb-1" name="name[{{ $socmed->name }}]" placeholder="Enter value...">{!! old($socmed->name, $socmed->value) !!}</textarea>
                            </div>
                            @endforeach
                            <hr>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary" title="@lang('lang.save_change')">
                                    <i class="las la-save"></i> @lang('lang.save_change')
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- custom --}}
                    <div class="tab-pane fade {{ (Request::get('tab') == 'custom') ? 'show active' : '' }}">
                        <form action="{{ route('configuration.website.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                            @foreach ($data['custom'] as $custom)
                            <div class="form-group">
                                <label class="form-label">{{ $custom->label }}</label>
                                <textarea class="form-control mb-1" name="name[{{ $custom->name }}]" placeholder="Enter value...">{!! old($custom->name, $custom->value) !!}</textarea>
                            </div>
                            @endforeach
                            <hr>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary" title="@lang('lang.save_change')">
                                    <i class="las la-save"></i> @lang('lang.save_change')
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/backend/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
<script src="{{ asset('assets/backend/fancybox/fancybox.min.js') }}"></script>
@endsection

@section('jsbody')
<script src="{{ asset('assets/backend/js/pages_account-settings.js') }}"></script>
<script>
    $('#logo').change(function() {
        $('#upload-logo').submit();
    });
    $('#logo_2').change(function() {
        $('#upload-logo_2').submit();
    });
    $('#logo_small').change(function() {
        $('#upload-logo_small').submit();
    });
    $('#logo_small_2').change(function() {
        $('#upload-logo_small_2').submit();
    });
    $('#logo_mail').change(function() {
        $('#upload-logo_mail').submit();
    });
    $('#open_graph').change(function() {
        $('#upload-open_graph').submit();
    });
    $('#banner_default').change(function() {
        $('#upload-banner_default').submit();
    });
    $('#google_analytics_api').change(function() {
        $('#upload-google_analytics_api').submit();
    });
    $('#panduan_identitas').change(function() {
        $('#upload-panduan_identitas').submit();
    });
</script>
@endsection