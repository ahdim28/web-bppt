@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
@endsection

@section('content')
<div class="card mb-4">
    <h6 class="card-header">
      Form Inquiry Field
    </h6>
    <form action="{{ route('inquiry.field.update', ['inquiryId' => $data['inquiry']->id, 'id' => $data['field']->id]) }}" method="POST">
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
                                    <label class="col-form-label col-sm-2 text-sm-right">Label</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control mb-1 @error('label_'.$lang->iso_codes) is-invalid @enderror" lang="{{ $lang->iso_codes }}" 
                                            name="label_{{ $lang->iso_codes }}" value="{{ old('label_'.$lang->iso_codes, $data['field']->fieldLang('label', $lang->iso_codes)) }}" placeholder="Enter title...">
                                        @include('components.field-error', ['field' => 'label_'.$lang->iso_codes])
                                    </div>
                                </div>
                                @if ($lang->iso_codes == config('custom.language.default'))
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 text-sm-right">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $data['field']->name) }}" placeholder="enter name...">
                                        @include('components.field-error', ['field' => 'name'])
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 text-sm-right">Type Form</label>
                                    <div class="col-sm-10">
                                        <select class="selectpicker show-tick" name="type" data-style="btn-default">
                                            @foreach (config('custom.columns.field_inquiry') as $key => $field)
                                                <option value="{{ $key }}" {{ (old('type', $data['field']->type) == ''.$key.'') ? 'selected' : '' }}>
                                                    {{ $field }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <h5>Properties</h5>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 text-sm-right">Type</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('inp_type') is-invalid @enderror" name="inp_type" value="{{ old('inp_type', $data['field']->properties['type']) }}" placeholder="enter input type...">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 text-sm-right">ID</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('inp_id') is-invalid @enderror" name="inp_id" value="{{ old('inp_id', $data['field']->properties['id']) }}" placeholder="enter input id...">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 text-sm-right">Class</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('inp_class') is-invalid @enderror" name="inp_class" value="{{ old('inp_class', $data['field']->properties['class']) }}" placeholder="enter input class...">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 text-sm-right">Attribute</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('inp_attr') is-invalid @enderror" name="inp_attr" value="{{ old('inp_attr', $data['field']->properties['attr']) }}" placeholder="enter input attribute...">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-2 text-sm-right">Validation</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('validation') is-invalid @enderror" name="validation" value="{{ old('validation', $data['field']->validation) }}" placeholder="laravel validation">
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
@endsection

@section('scripts')
<script src="{{ asset('assets/backend/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
@endsection