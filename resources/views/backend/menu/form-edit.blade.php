@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/select2/select2.css') }}">
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="card mb-4 col-md-10">
        <h6 class="card-header">
            @lang('lang.form_attr', [
            'attribute' => __('mod/menu.title')
          ])
        </h6>
        <form action="{{ route('menu.update', ['categoryId' => $data['category']->id, 'id' => $data['menu']->id]) }}" method="POST">
            @csrf
            @method('PUT')
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
                                        <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/menu.label.field2')</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control mb-1 gen_slug @error('title_'.$lang->iso_codes) is-invalid @enderror" lang="{{ $lang->iso_codes }}" 
                                                name="title_{{ $lang->iso_codes }}" value="{{ old('title_'.$lang->iso_codes, $data['menu']->fieldLang('title', $lang->iso_codes)) }}" 
                                                placeholder="@lang('mod/menu.placeholder.field2')">
                                            @include('components.field-error', ['field' => 'title_'.$lang->iso_codes])
                                        </div>
                                    </div>
                                    @if ($lang->iso_codes == config('custom.language.default'))
                                    @role ('super')
                                    <div class="form-group row">
                                        <div class="col-md-2 text-md-right">
                                        <label class="col-form-label text-sm-right">@lang('mod/menu.label.field3')</label>
                                        </div>
                                        <div class="col-md-10">
                                            <label class="switcher switcher-success">
                                                <input type="checkbox" id="nfm" class="switcher-input check-parent" name="not_from_module" value="1" 
                                                    {{ (old('not_from_module', $data['menu']->attr['not_from_module']) == 1 ? 'checked' : '') }}>
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
                                    @else
                                    <input type="hidden" name="not_from_module" value="{{ $data['menu']->attr['not_from_module'] }}">
                                    @endrole
                                    <div class="form-group row" id="url">
                                        <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/menu.label.field4')</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control mb-1" name="url" value="{{ old('url', $data['menu']->attr['url']) }}" placeholder="@lang('mod/menu.placeholder.field4')">
                                        </div>
                                    </div>
                                    @role ('super')
                                    <div class="form-group row" id="module">
                                        <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/menu.label.field5')</label>
                                        <div class="col-sm-10">
                                            <select id="mod" class="form-control show-tick" name="module" data-style="btn-default">
                                                <option value=" " selected disabled>@lang('lang.select')</option>
                                                @foreach (config('custom.label.menu_module') as $key => $menu)
                                                    <option value="{{ $key }}" {{ $data['menu']->module == ''.$key.'' ? 'selected' : '' }}>
                                                        {{ ucfirst($menu) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('module')
                                            <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block;color:red;">{!! $message !!}</label>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row" id="module_content">
                                        <label class="col-form-label col-sm-2 text-sm-right"></label>
                                        <div class="col-sm-10">
                                            <select id="mod_content" class="select2 form-control" name="module_content" style="width: 100%">
                                                <option value=" " selected disabled>@lang('lang.select') @lang('mod/menu.label.field6')</option>
                                            </select>
                                            @error('module_content')
                                            <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block;color:red;">{!! $message !!}</label>
                                            @enderror
                                        </div>
                                    </div> 
                                    <div class="form-group row">
                                        <div class="col-md-2 text-md-right">
                                        <label class="col-form-label text-sm-right">@lang('mod/menu.label.field7')</label>
                                        </div>
                                        <div class="col-md-10">
                                            <label class="switcher switcher-success">
                                                <input type="checkbox" class="switcher-input check-parent" name="edit_public_menu" value="1" 
                                                    {{ (old('edit_public_menu', $data['menu']->edit_public_menu) == 1 ? 'checked' : '') }}>
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
                                    @else
                                    <input type="hidden" name="module" value="{{ $data['menu']->module }}">
                                    <input type="hidden" name="module_content" value="{{ $data['menu']->menuable_id }}">
                                    <input type="hidden" name="edit_public_menu" value="{{ $data['menu']->edit_public_menu }}">
                                    @endrole
                                    <div class="form-group row">
                                        <label class="col-form-label col-sm-2 text-sm-right">@lang('lang.status')</label>
                                        <div class="col-sm-10">
                                            <select class="selectpicker show-tick" name="publish" data-style="btn-default">
                                                @foreach (config('custom.label.publish') as $key => $publish)
                                                    <option value="{{ $key }}" {{ (old('publish', $data['menu']->publish) == ''.$key.'') ? 'selected' : '' }}>
                                                        {{ __($publish['title']) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2 text-md-right">
                                        <label class="col-form-label text-sm-right">@lang('lang.public')</label>
                                        </div>
                                        <div class="col-md-10">
                                            <label class="switcher switcher-success">
                                                <input type="checkbox" class="switcher-input check-parent" name="public" value="1" 
                                                    {{ (old('public', $data['menu']->public) == 1 ? 'checked' : 'checked') }}>
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
                                        <label class="col-form-label col-sm-2 text-sm-right">Icon</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control mb-1" name="icon" value="{{ old('icon', $data['menu']->attr['icon']) }}" placeholder="Enter icon...">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2 text-md-right">
                                        <label class="col-form-label text-sm-right">@lang('mod/menu.label.field8')</label>
                                        </div>
                                        <div class="col-md-10">
                                            <label class="switcher switcher-success">
                                                <input type="checkbox" class="switcher-input check-parent" name="target_blank" value="1" 
                                                    {{ (old('target_blank', $data['menu']->attr['target_blank']) == 1 ? 'checked' : '') }}>
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
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
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
<script src="{{ asset('assets/backend/vendor/libs/select2/select2.js') }}"></script>
@endsection

@section('jsbody')
<script>
    //select
    $('.select2').select2();

    var nfm = '{{ $data['menu']->attr['not_from_module'] }}';
    var module = '{{ $data['menu']->module }}';
    
    if (nfm == 1) {
        $('#url').show();
        $('#module').hide();
        $('#module_content').hide();
    } else {
        $('#url').hide();
        $('#module').show();
        $('#module_content').show();
    }

    $('#nfm').change(function() {
        if(this.checked) {
            $('#url').show();
            $('#module').hide();
            $('#module_content').hide();
        } else {
            $('#url').hide();
            $('#module').show();
            $('#module_content').show();
        }
    });

    if (nfm == 0 && module == 0) {
        $("#mod_content").append(`
            @foreach($data['pages'] as $page)
            <option value="{{ $page->id }}" class="type-val" {{ $data['menu']->menuable_id == $page->id ? 'selected' : '' }}>
                {!! $page->fieldLang('title') !!}
            </option>
            @endforeach
        `);
    } else if (nfm == 0 && module == 1) {
        $("#mod_content").append(`
            @foreach($data['sections'] as $section)
            <option value="{{ $section->id }}" class="type-val" {{ $data['menu']->menuable_id == $section->id ? 'selected' : '' }}>
                {!! $section->fieldLang('name') !!}
            </option>
            @endforeach
        `);
    } else if (nfm == 0 && module == 2) {
        $("#mod_content").append(`
            @foreach($data['categories'] as $category)
            <option value="{{ $category->id }}" class="type-val" {{ $data['menu']->menuable_id == $category->id ? 'selected' : '' }}>
                {!! $category->fieldLang('name') !!}
            </option>
            @endforeach
        `);
    } else if (nfm == 0 && module == 9) {
        $("#mod_content").append(`
            @foreach($data['inquiries'] as $inquiry)
            <option value="{{ $inquiry->id }}" class="type-val" {{ $data['menu']->menuable_id == $inquiry->id ? 'selected' : '' }}>
                {!! $inquiry->fieldLang('name') !!}
            </option>
            @endforeach
        `);
    }

    $('#mod').on('change', function() {
        
        $('#module_content').show();
        $(".type-val").remove();
        if (this.value == 0) {
            $("#mod_content").append(`
                @foreach($data['pages'] as $page)
                <option value="{{ $page->id }}" class="type-val" {{ $data['menu']->menuable_id == $page->id ? 'selected' : '' }}>
                    {!! $page->fieldLang('title') !!}
                </option>
                @endforeach
            `);
        } else if (this.value == 1) {
            $("#mod_content").append(`
                @foreach($data['sections'] as $section)
                <option value="{{ $section->id }}" class="type-val" {{ $data['menu']->menuable_id == $section->id ? 'selected' : '' }}>
                    {!! $section->fieldLang('name') !!}
                </option>
                @endforeach
            `);
        } else if (this.value == 2) {
            $("#mod_content").append(`
                @foreach($data['categories'] as $category)
                <option value="{{ $category->id }}" class="type-val" {{ $data['menu']->menuable_id == $category->id ? 'selected' : '' }}>
                    {!! $category->fieldLang('name') !!}
                </option>
                @endforeach
            `);
        } else if (this.value == 9) {
            $("#mod_content").append(`
                @foreach($data['inquiries'] as $inquiry)
                <option value="{{ $inquiry->id }}" class="type-val" {{ $data['menu']->menuable_id == $inquiry->id ? 'selected' : '' }}>
                    {!! $inquiry->fieldLang('name') !!}
                </option>
                @endforeach
            `);
        }
    });
</script>
@endsection