@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/select2/select2.css') }}">
@endsection

@section('content')
@if (isset($data['parent']))
<div class="row justify-content-center">
    <div class="col-md-10">
      <div class="alert alert-primary alert-dismissible fade show text-muted">
        <i class="las la-thumbtack"></i> @lang('lang.under') <strong>" {!! $data['parent']->modMenu($data['parent'])['title'] !!} "</strong>
      </div>
    </div>
</div>
@endif

<div class="row justify-content-center">
    <div class="card mb-4 col-md-10">
        <h6 class="card-header">
        @lang('lang.form_attr', [
            'attribute' => __('mod/menu.title')
          ])
        </h6>
        <form action="{{ route('menu.store', ['categoryId' => $data['category']->id, 'parent' => Request::get('parent')]) }}" method="POST">
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
                                    <div class="form-group row">
                                        <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/menu.label.field2')</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control mb-1 gen_slug @error('title_'.$lang->iso_codes) is-invalid @enderror" lang="{{ $lang->iso_codes }}" 
                                                name="title_{{ $lang->iso_codes }}" value="{{ old('title_'.$lang->iso_codes) }}" placeholder="@lang('mod/menu.placeholder.field2')">
                                            @include('components.field-error', ['field' => 'title_'.$lang->iso_codes])
                                        </div>
                                    </div>
                                    @if ($lang->iso_codes == config('custom.language.default'))
                                    <div class="form-group row">
                                        <div class="col-md-2 text-md-right">
                                        <label class="col-form-label text-sm-right">@lang('mod/menu.label.field3')</label>
                                        </div>
                                        <div class="col-md-10">
                                            <label class="switcher switcher-success">
                                                <input type="checkbox" id="nfm" class="switcher-input check-parent" name="not_from_module" value="1" 
                                                    {{ (old('not_from_module') == 1 ? 'checked' : '') }}>
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
                                    <div class="form-group row" id="url">
                                        <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/menu.label.field4')</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control mb-1" name="url" value="{{ old('url') }}" placeholder="@lang('mod/menu.placeholder.field4')">
                                        </div>
                                    </div>
                                    <div class="form-group row" id="module">
                                        <label class="col-form-label col-sm-2 text-sm-right">@lang('mod/menu.label.field5')</label>
                                        <div class="col-sm-10">
                                            <select id="mod" class="form-control show-tick" name="module" data-style="btn-default">
                                                <option value=" " selected disabled>@lang('lang.select')</option>
                                                @foreach (config('custom.label.menu_module') as $key => $menu)
                                                    <option value="{{ $key }}">
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
                                    @role ('super')    
                                    <div class="form-group row">
                                        <div class="col-md-2 text-md-right">
                                        <label class="col-form-label text-sm-right">@lang('mod/menu.label.field7')</label>
                                        </div>
                                        <div class="col-md-10">
                                            <label class="switcher switcher-success">
                                                <input type="checkbox" class="switcher-input check-parent" name="edit_public_menu" value="1" 
                                                    {{ (old('edit_public_menu') == 1 ? 'checked' : '') }}>
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
                                    @endrole
                                    <div class="form-group row">
                                        <label class="col-form-label col-sm-2 text-sm-right">@lang('lang.status')</label>
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
                                        <label class="col-form-label text-sm-right">@lang('lang.public')</label>
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
                                        <label class="col-form-label col-sm-2 text-sm-right">Icon</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control mb-1" name="icon" value="{{ old('icon') }}" placeholder="Enter icon...">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2 text-md-right">
                                        <label class="col-form-label text-sm-right">@lang('mod/menu.label.field8')</label>
                                        </div>
                                        <div class="col-md-10">
                                            <label class="switcher switcher-success">
                                                <input type="checkbox" class="switcher-input check-parent" name="target_blank" value="1" 
                                                    {{ (old('target_blank') == 1 ? 'checked' : '') }}>
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

    $('#url').hide();
    $('#module').show();
    $('#module_content').hide();
    $('#nfm').change(function() {
        console.log(this.value);
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

    $('#module_content').hide();
    $('#mod').on('change', function() {
        
        $('#module_content').show();
        $(".type-val").remove();
        if (this.value == 0) {
            $("#mod_content").append(`
                @foreach($data['pages'] as $page)
                <option value="{{ $page->id }}" class="type-val">{!! $page->fieldLang('title') !!}</option>
                @endforeach
            `);
        } else if (this.value == 1) {
            $("#mod_content").append(`
                @foreach($data['sections'] as $section)
                <option value="{{ $section->id }}" class="type-val">{!! $section->fieldLang('name') !!}</option>
                @endforeach
            `);
        } else if (this.value == 2) {
            $("#mod_content").append(`
                @foreach($data['categories'] as $category)
                <option value="{{ $category->id }}" class="type-val">{!! $category->fieldLang('name') !!}</option>
                @endforeach
            `);
        } else if (this.value == 3) {
            $("#mod_content").append(`
                @foreach($data['posts'] as $post)
                <option value="{{ $post->id }}" class="type-val">{!! $post->fieldLang('title') !!}</option>
                @endforeach
            `);
        } else if (this.value == 4) {
            $("#mod_content").append(`
                @foreach($data['cat_categories'] as $catCategory)
                <option value="{{ $catCategory->id }}" class="type-val">{!! $catCategory->fieldLang('name') !!}</option>
                @endforeach
            `);
        } else if (this.value == 5) {
            $("#mod_content").append(`
                @foreach($data['cat_products'] as $catProduct)
                <option value="{{ $catProduct->id }}" class="type-val">{!! $catProduct->fieldLang('title') !!}</option>
                @endforeach
            `);
        } else if (this.value == 6) {
            $("#mod_content").append(`
                @foreach($data['albums'] as $album)
                <option value="{{ $album->id }}" class="type-val">{!! $album->fieldLang('name') !!}</option>
                @endforeach
            `);
        } else if (this.value == 7) {
            $("#mod_content").append(`
                @foreach($data['playlists'] as $playlist)
                <option value="{{ $playlist->id }}" class="type-val">{!! $playlist->fieldLang('name') !!}</option>
                @endforeach
            `);
        } else if (this.value == 8) {
            $("#mod_content").append(`
                @foreach($data['links'] as $link)
                <option value="{{ $link->id }}" class="type-val">{!! $link->fieldLang('name') !!}</option>
                @endforeach
            `);
        } else if (this.value == 9) {
            $("#mod_content").append(`
                @foreach($data['inquiries'] as $inquiry)
                <option value="{{ $inquiry->id }}" class="type-val">{!! $inquiry->fieldLang('name') !!}</option>
                @endforeach
            `);
        }

    });
</script>
@endsection