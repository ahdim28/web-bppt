@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="card mb-4 col-md-10">
    <h6 class="card-header">
      @lang('lang.form_attr', [
        'attribute' => __('mod/users.user.caption')
      ])
    </h6>
    <form action="{{ !isset($data['user']) ? route('user.store') : route('user.update', ['id' => $data['user']->id]) }}" method="POST">
        @csrf
        @isset ($data['user'])
            @method('PUT')
            <input type="hidden" name="old_email" value="{{ $data['user']->email }}">
        @endisset
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">@lang('mod/users.user.label.field1')</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ !isset($data['user']) ? old('name') : old('name', $data['user']->name) }}" 
                    placeholder="@lang('mod/users.user.placeholder.field1')" autofocus>
                  @include('components.field-error', ['field' => 'name'])
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">@lang('mod/users.user.label.field2')</label>
                </div>
                <div class="col-md-10">
                  <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ !isset($data['user']) ? old('email') : old('email', $data['user']->email) }}" 
                    placeholder="@lang('mod/users.user.placeholder.field2')">
                  @include('components.field-error', ['field' => 'email'])
                </div>
            </div>
            {{-- <div class="form-group row">
                <div class="col-md-2 text-md-right">
                  <label class="col-form-label text-sm-right">@lang('mod/users.user.label.field8')</label>
                </div>
                <div class="col-md-10">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><strong>+62</strong></span>
                        </div>
                        <input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone"
                            value="{{ !isset($data['user']) ? old('phone') : old('phone', $data['user']->phone) }}" 
                            placeholder="@lang('mod/users.user.placeholder.field8')">
                        @include('components.field-error', ['field' => 'phone'])
                    </div>
                </div>
            </div> --}}
            <div class="form-group row">
              <div class="col-md-2 text-md-right">
                <label class="col-form-label text-sm-right">@lang('mod/users.user.label.field3')</label>
              </div>
              <div class="col-md-10">
                <input type="text" class="form-control @error('username') is-invalid @enderror" name="username"
                  value="{{ !isset($data['user']) ? old('username') : old('username', $data['user']->username) }}" 
                  placeholder="@lang('mod/users.user.placeholder.field3')">
                @include('components.field-error', ['field' => 'username'])
              </div>
          </div>
          @if (!isset($data['user']) || isset($data['user']) && $data['user']->roles[0]->id <= 3)
          <div class="form-group row">
              <div class="col-md-2 text-md-right">
                <label class="col-form-label text-sm-right">@lang('mod/users.user.label.field11')</label>
              </div>
              <div class="col-md-10">
                <select id="select-role" class="selectpicker show-tick @error('roles') is-invalid @enderror" name="roles" data-style="btn-default">
                    <option value="" disabled selected>@lang('lang.select')</option>
                    @foreach ($data['roles'] as $item)
                          <option value="{{ $item->name }}" {{ !isset($data['user']) ? (old('roles') == $item->name ? 'selected' : '') : 
                            (old('roles', $data['user']->roles[0]->name) == $item->name ? 'selected' : '') }}>
                            {{ Str::upper($item->name) }}
                          </option>
                    @endforeach
                </select>
                @error('roles')
                <label class="error jquery-validation-error small form-text invalid-feedback" style="display: inline-block; color:red;">{!! $message !!}</label>
                @enderror
              </div>
          </div>
          @else
          <input type="hidden" name="roles" value="{{ $data['user']->roles[0]->name }}">
          @endif
          <div class="form-group row">
              <div class="col-md-2 text-md-right">
                <label class="col-form-label text-sm-right">@lang('lang.status')</label>
              </div>
              <div class="col-md-10">
                  <label class="switcher switcher-success">
                      <input type="checkbox" class="switcher-input check-parent" name="active" value="1" 
                          {{ !isset($data['user']) ? (old('active') ? 'checked' : 'checked') : (old('active', $data['user']->active) == 1 ? 'checked' : '') }}>
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
                <label class="col-form-label text-sm-right">@lang('mod/users.user.label.field9')</label>
              </div>
              <div class="col-md-10">
                <div class="input-group">
                  <input type="password" id="password-field" class="form-control gen-field @error('password') is-invalid @enderror" name="password"
                      value="{{ old('password') }}" placeholder="@lang('mod/users.user.placeholder.field9')">
                  <div class="input-group-append">
                      <span toggle="#password-field" class="input-group-text toggle-password fas fa-eye"></span>
                      <span class="btn btn-warning ml-2" id="generate"><i class="las la-recycle"></i></span>
                  </div>
                  @include('components.field-error', ['field' => 'password'])
                </div>
              </div>
          </div>
          <div class="form-group row">
              <div class="col-md-2 text-md-right">
                <label class="col-form-label">@lang('mod/users.user.label.field9_1')</label>
              </div>
              <div class="col-md-10">
                <div class="input-group">
                  <input type="password" id="password-confirm-field" class="form-control gen-field @error('password_confirmation') is-invalid @enderror" name="password_confirmation"
                      value="{{ old('password_confirmation') }}" placeholder="@lang('mod/users.user.placeholder.field9_1')">
                  <div class="input-group-append">
                      <span toggle="#password-confirm-field" class="input-group-text toggle-password-confirm fas fa-eye"></span>
                  </div>
                  @include('components.field-error', ['field' => 'password_confirmation'])
                </div>
              </div>
          </div>
        </div>
        <div class="card-footer text-center">
            <button type="submit" class="btn btn-primary" name="action" value="back" title="{{ isset($data['user']) ? __('lang.save_change') : __('lang.save') }}">
                <i class="las la-save"></i> {{ isset($data['user']) ? __('lang.save_change') : __('lang.save') }}
            </button>&nbsp;&nbsp;
            <button type="submit" class="btn btn-danger" name="action" value="exit" title="{{ isset($data['user']) ? __('lang.save_change_exit') : __('lang.save_exit') }}">
                <i class="las la-save"></i> {{ isset($data['user']) ? __('lang.save_change_exit') : __('lang.save_exit') }}
            </button>&nbsp;&nbsp;
            <button type="reset" class="btn btn-secondary" title="{{ __('lang.reset') }}">
              <i class="las la-redo-alt"></i> {{ __('lang.reset') }}
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
<script src="{{ asset('assets/tmplts_backend/js/pages_account-settings.js') }}"></script>
<script>
    //show & hide password
    $(".toggle-password, .toggle-password-confirm").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
        input.attr("type", "text");
        } else {
        input.attr("type", "password");
        }
    });
    //generate password
    function makeid(length) {
        var result           = '';
        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }

        return result;
    }
    $("#generate").click(function(){
        $(".gen-field").val(makeid(8));
    });
</script>
@endsection