@extends('layouts.backend.layout-auth')

@section('content')
<h5 class="text-center text-muted font-weight-normal mb-4">@lang('auth.login.text')</h5>

<!-- Form -->
<form class="my-2" action="{{ route('login') }}" method="POST">
  @csrf
  <div class="form-group">
    <label class="form-label">@lang('auth.login.label.field1')</label>
    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}"
      placeholder="@lang('auth.login.placeholder.field1')" autofocus>
    @include('components.field-error', ['field' => 'username'])
  </div>
  <div class="form-group">
    <label class="form-label d-flex justify-content-between align-items-end">
      <div>@lang('auth.login.label.field2')</div>
    </label>
    <div class="input-group">
      <input type="password" id="password-field" class="form-control @error('password') is-invalid @enderror" name="password"
        placeholder="@lang('auth.login.placeholder.field2')">
      <div class="input-group-append">
          <span toggle="#password-field" class="input-group-text toggle-password fas fa-eye"></span>
      </div>
      @include('components.field-error', ['field' => 'password'])
    </div>
  </div>
  <div class="d-flex justify-content-between align-items-center m-0">
    <label class="custom-control custom-checkbox m-0">
      <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
      <span class="custom-control-label">@lang('auth.login.label.field3')</span>
    </label>
    <button type="submit" style="background: #0084ff;" class="btn btn-primary" title="@lang('auth.login.signin_caption')">
      @lang('auth.login.signin_caption')
    </button>
  </div>
</form>
<!-- / Form -->
@endsection

@section('content-footer')
  @lang('lang.view_frontend') &nbsp;
  <a href="{{ route('home') }}" target="_blank" title="@lang('lang.view_frontend')">
    <i class="las la-external-link-alt" style="font-size: 1.3em;"></i>
  </a>
@endsection

@section('jsbody')
<script>
  $(".toggle-password").click(function() {
      $(this).toggleClass("fa-eye fa-eye-slash");
      var input = $($(this).attr("toggle"));
      if (input.attr("type") == "password") {
      input.attr("type", "text");
      } else {
      input.attr("type", "password");
      }
  });
</script>
@endsection
