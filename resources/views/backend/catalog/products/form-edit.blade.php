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
        @if ($data['fields']->count() > 0 || !empty($data['post']->field_category_id) || Auth::user()->hasRole('super'))
        <a class="list-group-item list-group-item-action" data-toggle="list" href="#field">CUSTOM FIELD</a>
        @endif
    </div>
    <form action="{{ route('catalog.product.update', ['id' => $data['product']->id]) }}" method="POST">
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
                                            <label class="col-form-label col-sm-2 text-sm-right">Title</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control mb-1 gen_slug @error('title_'.$lang->iso_codes) is-invalid @enderror" lang="{{ $lang->iso_codes }}" 
                                                    name="title_{{ $lang->iso_codes }}" value="{{ old('title_'.$lang->iso_codes, $data['product']->fieldLang('title', $lang->iso_codes)) }}" placeholder="Enter title...">
                                                @include('components.field-error', ['field' => 'title_'.$lang->iso_codes])
                                            </div>
                                        </div>
                                        @if ($lang->iso_codes == config('custom.language.default'))
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2 text-sm-right">Slug</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><strong>{{ url('/').'/catalog/' }}</strong></span>
                                                    </div>
                                                    <input type="text" class="form-control slug_spot @error('slug') is-invalid @enderror" lang="{{ $lang->iso_codes }}" name="slug"
                                                            value="{{ old('slug', $data['product']->slug) }}" placeholder="Enter slug...">
                                                    @include('components.field-error', ['field' => 'slug'])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2 text-sm-right">Type</label>
                                            <div class="col-sm-10">
                                                <select class="selectpicker custom-select" name="type_id" data-style="btn-default">
                                                    <option value=" " selected disabled>Select</option>
                                                    @foreach ($data['types'] as $type)
                                                        <option value="{{ $type->id }}" {{ old('type_id', $data['product']->catalog_type_id) == $type->id ? 'selected' : '' }}>{!! $type->fieldLang('name') !!}</option>
                                                    @endforeach
                                                </select>
                                                @error('type_id')
                                                <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block;color:red;">{!! $message !!}</label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2 text-sm-right">Category</label>
                                            <div class="col-sm-10">
                                                <select class="selectpicker custom-select" name="category_id" data-style="btn-default">
                                                    {{-- <option value=" " selected disabled>Select</option> --}}
                                                    @foreach ($data['categories'] as $category)
                                                        <option value="{{ $category->id }}" {{ old('category_id', $data['product']->catalog_category_id) == $category->id ? 'selected' : '' }}>{!! $category->fieldLang('name') !!}</option>
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
                                                <textarea class="form-control tiny-mce" name="intro_{{ $lang->iso_codes }}">{!! old('intro_'.$lang->iso_codes, $data['product']->fieldLang('intro', $lang->iso_codes)) !!}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2 text-sm-right">Content</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control tiny-mce" name="content_{{ $lang->iso_codes }}">{!! old('content_'.$lang->iso_codes, $data['product']->fieldLang('content', $lang->iso_codes)) !!}</textarea>
                                            </div>
                                        </div>
                                        @if ($lang->iso_codes == config('custom.language.default'))
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2 text-sm-right">Quantity</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control mb-1 @error('quantity') is-invalid @enderror" name="quantity"
                                                    value="{{ old('quantity', $data['product']->quantity) }}" placeholder="Enter quantity...">
                                                @include('components.field-error', ['field' => 'quantity'])
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2 text-sm-right">Price</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control mb-1 @error('price') is-invalid @enderror" id="price" name="price" onkeyup="document.getElementById('format').innerHTML = formatCurrency(this.value);" autocomplete="off"
                                                    value="{{ old('price', $data['product']->price) }}" placeholder="Enter price...">
                                                @include('components.field-error', ['field' => 'price'])
                                                <em><span  id="format" class=""></span> <span id="price-generate" class="font"></span></em>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-sm-2 text-sm-right">Product Discount</label>
                                            <div class="col-sm-10">
                                                <label class="switcher">
                                                    <input type="checkbox" name="is_discount" id="is-discount" value="1" class="switcher-input" {{ old('is_discount', $data['product']->is_discount) == 1 ? 'checked' : '' }}>
                                                    <span class="switcher-indicator">
                                                        <span class="switcher-yes"></span>
                                                        <span class="switcher-no"></span>
                                                    </span>
                                                    <span class="switcher-label"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="discount">
                                            <label class="col-form-label col-sm-2 text-sm-right">Discount</label>
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <input type="number" class="form-control @error('discount') is-invalid @enderror" name="discount" max="100"
                                                        value="{{ old('discount', $data['product']->discount) }}" placeholder="Enter discount...">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                </div>
                                                @include('components.field-error', ['field' => 'discount'])
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

            <div class="tab-pane fade" id="setting">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">Status</label>
                        <div class="col-sm-10">
                            <select class="selectpicker show-tick" name="publish" data-style="btn-default">
                                @foreach (config('custom.label.publish') as $key => $publish)
                                    <option value="{{ $key }}" {{ (old('publish', $data['product']->publish) == ''.$key.'') ? 'selected' : '' }}>
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
                                    {{ (old('public', $data['product']->public) == 1 ? 'checked' : '') }}>
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
                                    {{ (old('is_detail', $data['product']->is_detail) == 1 ? 'checked' : '') }}>
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
                            <input type="hidden" name="old_tags" value="{{ $data['tags'] }}">
                            <input type="text" class="form-control bs-tagsinput @error('tags') is-invalid @enderror" name="tags"
                                value="{{ $data['tags'] }}">
                            <small><i>*Separated by comma (,). Example : foods, tech,</i></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">Publish Time</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" class="datetime-picker form-control @error('created_at') is-invalid @enderror" name="created_at"
                                    value="{{ old('created_at', $data['product']->created_at->format('Y-m-d H:i')) }}" placeholder="enter publish time...">
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
                                        value="{{ old('cover_file', $data['product']->cover['file_path']) }}" placeholder="browse cover..." readonly>
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
                                <input type="text" class="form-control" placeholder="title..." name="cover_title" value="{{ old('cover_title', $data['product']->cover['title']) }}">
                                </div>
                                <div class="col-sm-6">
                                <input type="text" class="form-control" placeholder="alt..." name="cover_alt" value="{{ old('cover_alt', $data['product']->cover['alt']) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">Banner</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" class="form-control" id="image2" aria-label="Image2" aria-describedby="button-image2" name="banner_file"
                                        value="{{ old('banner_file', $data['product']->banner['file_path']) }}" placeholder="browse banner..." readonly>
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
                                <input type="text" class="form-control" placeholder="title..." name="banner_title" value="{{ old('banner_title', $data['product']->banner['title']) }}">
                                </div>
                                <div class="col-sm-6">
                                <input type="text" class="form-control" placeholder="alt..." name="banner_alt" value="{{ old('banner_alt', $data['product']->banner['alt']) }}">
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
                                    <option value="{{ $custom->id }}" {{ (old('custom_view_id', $data['product']->custom_view_id) == $custom->id) ? 'selected' : '' }}>
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
                            <input type="text" class="form-control mb-1" name="meta_title" value="{{ old('meta_title', $data['product']->meta_data['title']) }}" placeholder="Enter meta title...">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">Meta Description</label>
                        <div class="col-sm-10">
                            <textarea class="form-control mb-1" name="meta_description" placeholder="Separated by comma (,)">{{ old('meta_decsription', $data['product']->meta_data['description']) }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">Meta Keywords</label>
                        <div class="col-sm-10">
                            <input class="form-control mb-1" name="meta_keywords" id="bs-tagsinput-2" value="{{ old('meta_keywords', $data['product']->meta_data['keywords']) }}" placeholder="">
                            <small><i>* Separated by comma(,)</i></small>
                        </div>
                    </div>
                </div>
            </div>

            @if (!empty($data['product']->field_category_id) || Auth::user()->hasRole('super'))
            <div class="tab-pane fade" id="field">
                <div class="card-body">
                    @role ('super')    
                    <div class="form-group row">
                        <label class="col-form-label col-sm-2 text-sm-right">Field</label>
                        <div class="col-sm-10">
                            <select id="field_category" class="selectpicker show-tick" name="field_category_id" data-style="btn-default">
                                <option value=" " selected>Select</option>
                                @foreach ($data['fields'] as $field)
                                    <option value="{{ $field->id }}" {{ $field->id == $data['product']->field_category_id ? 'selected' : '' }}>
                                        {{ $field->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if (!empty($data['product']->field_category_id))    
                            <small>Current Field : <strong><i>{{ $data['product']->field->name }}</i></strong></small>
                            @endif
                        </div>
                    </div>
                    <div id="custom_field">

                    </div>
                    @else
                    <input type="hidden" name="field_category_id" value="{{ $data['product']->field_category_id }}">
                    @endrole

                    @if (!empty($data['product']->field_category_id))
                    <div id="current_field">
                        @include('backend.master.fields.input-edit', ['module' => 'product'])
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

    //price
    function formatCurrency(price)
    {
        price = price.toString().replace(/\$|\,/g,'');
        if(isNaN(price))
        price = "0";
        sign = (price == (price = Math.abs(price)));
        price = Math.floor(price*100+0.50000000001);
        cents = price%100;
        price = Math.floor(price/100).toString();
        if(cents<10)
        cents = "0" + cents;
        for (var i = 0; i < Math.floor((price.length-(1+i))/3); i++)
        price = price.substring(0,price.length-(4*i+3))+'.'+
        price.substring(price.length-(4*i+3));
        return (((sign)?'':'-') + ' Rp. ' + price + ',' + cents);
    };

    //max length discount
    $(document).ready(function() {

        $('input[type=number][max]:not([max=""])').on('input', function(ev) {
        var $this = $(this);
        var maxlength = $this.attr('max').length;
        var value = $this.val();
        if (value && value.length >= maxlength) {
            $this.val(value.substr(0, maxlength));
        }
        });

        var is_discount = '{{ $data['product']->is_discount }}';
        if (is_discount == 1) {
            $('#discount').show();
        } else {
            $('#discount').hide();
        }

    });

    //is discount
    $('#discount').hide();
    $('#is-discount').click(function() {
        if ($('#is-discount').prop('checked') == true) {
            $('#discount').toggle('slow');
        } else {
            $('#discount').toggle('slow');
        }
    });

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

@include('backend.master.fields.input')

@include('includes.button-fm')
@include('includes.tinymce-fm')
@endsection