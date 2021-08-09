@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/css/pages/account.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/fancybox/fancybox.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-xl-4">

        <!-- Side info -->
        <div class="card mb-4">
          <div class="card-body">
            <div class="media">
              <a href="{{ $data['user']->avatars() }}" data-fancybox="gallery">
                  <img src="{{ $data['user']->avatars() }}" alt="" class="ui-w-60 rounded-circle">
              </a>
              <div class="media-body pt-2 ml-3">
                <h5 class="mb-2">{{ $data['user']->name }}</h5>
                <div class="text-muted small"><i class="las la-crown"></i> {{ Str::upper($data['user']->roles[0]->name) }}</div>
                <div class="mt-3">
                    <button type="button" class="btn btn-primary btn-sm rounded-pill" data-toggle="modal" data-target="#modals-change-photo" title="@lang('lang.change')">
                        <i class="las la-camera"></i> @lang('lang.change')
                    </button>
                    @if (!empty($data['user']->profile_photo_path['filename']))
                    <button type="button" class="btn btn-danger btn-sm rounded-pill swal-delete-photo" title="@lang('lang.remove')">
                        <i class="las la-times"></i> @lang('lang.remove')
                    </button>
                    @endif
                  </div>
              </div>
            </div>
          </div>
          <hr class="border-light m-0">
          <div class="card-body">
            <div class="mb-2">
              <span class="text-muted">@lang('mod/users.user.log.label.field1') :</span>&nbsp;
              <strong>{{ !empty($data['user']->session) ? $data['user']->session->ip_address : '-' }}</strong>
            </div>
            <div class="mb-2">
                <span class="text-muted">@lang('mod/users.user.last_activity') :</span>&nbsp;
                <a href="javascript:void(0)" class="text-body"><strong>{{ !empty($data['user']->session) && !empty($data['user']->session->last_activity) ? $data['user']->session->last_activity->format('d F Y (H:i A)') : __('mod/users.user.no_activity') }}</strong></a>
            </div>
          </div>
          <div class="card-body">
            @if ($data['user']->logs()->count() == 0)
            <div class="text-center">
              <i><strong style="color: red;">! @lang('mod/users.user.no_activity') !</strong></i>
            </div>
            @endif
            @foreach ($data['user']->logs()->limit(3)->get() as $item)    
            <div class="media pb-1 mb-2">
                <div class="ui-feed-icon-container">
                  <span class="ui-icon ui-feed-icon ion {{ $item->event_attr['icon'] }} text-white"></span>
                  <img src="{{ $data['user']->avatars() }}" alt="{{ $data['user']->name }} photo" class="ui-w-40 rounded-circle">
                </div>
                <div class="media-body align-self-center ml-3">
                  <a href="javascript:void(0)">
                      @if ($item->user_id == Auth::user()->id)
                          @lang('lang.you')
                      @else
                      {{ $item->user->name }}
                      @endif
                  </a> 
                  {!! $item->event_attr['description'] !!}
                  <div class="text-bold small">{{ $item->ip_address }}</div>
                  <div class="text-muted small">{{ $item->created_at->diffForHumans() }}</div>
                </div>
            </div>
            @endforeach
          </div>
          <div class="card-footer text-center">
            <a href="{{ route('log.user', ['id' => $data['user']->id]) }}" class="btn btn-warning btn-sm" title="@lang('lang.view_all')">
              <i class="las la-clock"></i>@lang('lang.view_all') @lang('mod/users.user.log.caption')
            </a>
          </div>
        </div>
        <!-- / Side info -->
  
    </div>
    <div class="col">
        <div class="card mb-4">
            <form action="{{ route('profile') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="list-group list-group-flush account-settings-links flex-row">
                    <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account">@lang('mod/users.user.profile.tabs.1')</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#profile">@lang('mod/users.user.profile.tabs.2')</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#password">@lang('mod/users.user.profile.tabs.3')</a>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="account">
                          <div class="form-group row">
                            <div class="col-md-2 text-md-left">
                              <label class="col-form-label text-sm-right">@lang('mod/users.user.label.field1')</label>
                            </div>
                            <div class="col-md-10">
                              <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name', $data['user']->name) }}" placeholder="@lang('mod/users.user.placeholder.field1')" autofocus>
                              @include('components.field-error', ['field' => 'name'])
                            </div>
                          </div>
                          <div class="form-group row">
                              <div class="col-md-2 text-md-left">
                                <label class="col-form-label text-sm-right">@lang('mod/users.user.label.field2')</label>
                              </div>
                              <div class="col-md-10">
                                <input type="hidden" name="old_email" value="{{ $data['user']->email }}">
                                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                                  value="{{ old('email', $data['user']->email) }}" placeholder="@lang('mod/users.user.placeholder.field2')">
                                @include('components.field-error', ['field' => 'email'])
                                @if ($data['user']->email_verified == 0)
                                <div class="alert alert-warning alert-dismissible fade show mt-2">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <i class="las la-exclamation" style="font-size: 1.2em;"></i> @lang('mod/users.user.profile.verification.warning') 
                                    <a href="{{ route('profile.mail.send') }}" title="@lang('mod/users.user.profile.verification.href')"><em>@lang('mod/users.user.profile.verification.href')</em></a>.
                                </div>
                                @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <div class="col-md-2 text-md-left">
                                <label class="col-form-label text-sm-right">@lang('mod/users.user.label.field3')</label>
                              </div>
                              <div class="col-md-10">
                                <input type="text" class="form-control @error('username') is-invalid @enderror" name="username"
                                  value="{{ old('name', $data['user']->username) }}" placeholder="@lang('mod/users.user.placeholder.field3')">
                                @include('components.field-error', ['field' => 'username'])
                              </div>
                          </div>
                        </div>

                        <div class="tab-pane fade" id="profile">
                          <div class="form-group row">
                            <div class="col-md-2 text-md-left">
                              <label class="col-form-label text-sm-right">@lang('mod/users.user.profile.label.field1')</label>
                            </div>
                            <div class="col-md-10">
                              @foreach (config('custom.label.gender') as $keyG => $valG)    
                              <label class="custom-control custom-radio">
                                <input name="gender" type="radio" class="custom-control-input" value="{{ $keyG }}" {{ $data['user']->profile->gender == ''.$keyG.'' ? 'checked' : '' }}>
                                <span class="custom-control-label">{{ __($valG['title']) }}</span>
                              </label>
                              @endforeach
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="col-md-2 text-md-left">
                              <label class="col-form-label text-sm-right">@lang('mod/users.user.profile.label.field2')</label>
                            </div>
                            <div class="col-md-10">
                              <div class="input-group">
                                <input type="text" class="form-control @error('place_of_birth') is-invalid @enderror" name="place_of_birth"
                                  value="{{ old('place_of_birth', $data['user']->profile->place_of_birth) }}" placeholder="@lang('mod/users.user.profile.placeholder.field2')">
                                <div class="input-group-append">
                                  <span class="input-group-text"><i class="las la-map-marker"></i></span>
                                </div>
                                @include('components.field-error', ['field' => 'place_of_birth'])
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="col-md-2 text-md-left">
                              <label class="col-form-label text-sm-right">@lang('mod/users.user.profile.label.field3')</label>
                            </div>
                            <div class="col-md-10">
                              <div class="input-group">
                                <input type="text" class="form-control datepicker @error('date_of_birth') is-invalid @enderror" name="date_of_birth"
                                  value="{{ old('date_of_birth', $data['user']->profile->date_of_birth) }}" placeholder="@lang('mod/users.user.profile.placeholder.field3')" readonly>
                                <div class="input-group-append">
                                  <span class="input-group-text"><i class="las la-calendar"></i></span>
                                </div>
                                @include('components.field-error', ['field' => 'date_of_birth'])
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="col-md-2 text-md-left">
                              <label class="col-form-label text-sm-right">@lang('mod/users.user.profile.label.field4')</label>
                            </div>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <textarea class="form-control @error('address') is-invalid @enderror" name="address" placeholder="@lang('mod/users.user.profile.placeholder.field4')">{{ old('address', $data['user']->profile->address) }}</textarea>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="las la-road"></i></span>
                                    </div>
                                    @include('components.field-error', ['field' => 'address'])
                                </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="col-md-2 text-md-left">
                              <label class="col-form-label text-sm-right">@lang('mod/users.user.profile.label.field5')</label>
                            </div>
                            <div class="col-md-10">
                              <div class="input-group">
                                <input type="text" class="form-control @error('postal_code') is-invalid @enderror" name="postal_code"
                                  value="{{ old('postal_code', $data['user']->profile->postal_code) }}" placeholder="@lang('mod/users.user.profile.placeholder.field5')">
                                <div class="input-group-append">
                                  <span class="input-group-text"><i class="las la-map-signs"></i></span>
                                </div>
                                @include('components.field-error', ['field' => 'postal_code'])
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="col-md-2 text-md-left">
                              <label class="col-form-label text-sm-right">@lang('mod/users.user.label.field8')</label>
                            </div>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="las la-phone"></i></span>
                                    </div>
                                    <input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone"
                                        value="{{ old('phone', $data['user']->profile->phone) }}" placeholder="@lang('mod/users.user.placeholder.field8')">
                                    @include('components.field-error', ['field' => 'phone'])
                                </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="col-md-2 text-md-left">
                              <label class="col-form-label text-sm-right">Mobile @lang('mod/users.user.label.field8')</label>
                            </div>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><strong>+62</strong></span>
                                    </div>
                                    <input type="number" class="form-control @error('mobile_phone') is-invalid @enderror" name="mobile_phone"
                                        value="{{ old('mobile_phone', $data['user']->profile->mobile_phone) }}" placeholder="@lang('mod/users.user.placeholder.field8')">
                                    @include('components.field-error', ['field' => 'mobile_phone'])
                                </div>
                            </div>
                          </div>
                          <hr>
                          <h5>@lang('mod/users.user.profile.label.field6') :</h5>
                          @foreach ($data['user']->profile->socmed as $key => $val)
                          <div class="form-group row">
                              <div class="col-md-2 text-md-left">
                                <label class="col-form-label text-sm-right">@lang('mod/users.user.profile.label.field6_1', [
                                  'attribute' => $key,
                                ])</label>
                              </div>
                              <div class="col-md-10">
                                  <div class="input-group">
                                      <div class="input-group-prepend">
                                          <span class="input-group-text"><i class="lab la-{{ $key }}"></i></span>
                                      </div>
                                      <input type="text" class="form-control @error($key) is-invalid @enderror" name="{{ $key }}"
                                        value="{{ old($key, $data['user']->profile->socmed[$key]) }}" placeholder="@lang('mod/users.user.profile.placeholder.field6_1', [
                                          'attribute' => $key,
                                        ])">
                                      @include('components.field-error', ['field' => $key])
                                  </div>
                              </div>
                          </div>
                          @endforeach
                        </div>

                        <div class="tab-pane fade" id="password">
                          <div class="form-group row">
                              <div class="col-md-2 text-md-right">
                                <label class="col-form-label text-sm-right">@lang('mod/users.user.label.field9_2')</label>
                              </div>
                              <div class="col-md-10">
                                <div class="input-group">
                                  <input type="password" id="old-password-field" class="form-control @error('old_password') is-invalid @enderror" name="old_password" 
                                    placeholder="@lang('mod/users.user.placeholder.field9_2')">
                                  <div class="input-group-append">
                                      <span toggle="#old-password-field" class="input-group-text toggle-old-password fas fa-eye"></span>
                                  </div>
                                  @include('components.field-error', ['field' => 'old_password'])
                                </div>
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
                    </div>
                </div>
                <div class="card-footer text-center">
                  <button type="submit" class="btn btn-primary" title="@lang('lang.save_change')">
                    <i class="las la-save"></i> @lang('lang.save_change')
                  </button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('backend.users.profile.modal-change-photo')
@endsection

@section('scripts')
<script src="{{ asset('assets/backend/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/backend/fancybox/fancybox.min.js') }}"></script>
<script src="{{ asset('assets/backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script>
  //delete photo
  $(document).ready(function () {
      $('.swal-delete-photo').on('click', function () {
          Swal.fire({
            title: "@lang('alert.delete_confirm_title')",
              text: "@lang('alert.delete_confirm_text')",
              type: "warning",
              confirmButtonText: "@lang('alert.delete_btn_yes')",
              customClass: {
                  confirmButton: "btn btn-danger btn-lg",
                  cancelButton: "btn btn-primary btn-lg"
              },
              showLoaderOnConfirm: true,
              showCancelButton: true,
              allowOutsideClick: () => !Swal.isLoading(),
              cancelButtonText: "@lang('alert.delete_btn_cancel')",
              preConfirm: () => {
                  return $.ajax({
                      url: '/admin/profile/photo/remove',
                      method: 'PUT',
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                      dataType: 'json'
                  }).then(response => {
                      if (!response.success) {
                          return new Error(response.message);
                      }
                      return response;
                  }).catch(error => {
                      swal({
                          type: 'error',
                          text: 'Error while deleting data. Error Message: ' + error
                      })
                  });
              }
          }).then(response => {
              if (response.value.success) {
                  Swal.fire({
                      type: 'success',
                      text: "{{ __('alert.delete_success', ['attribute' => __('mod/users.user.label.field10')]) }}"
                  }).then(() => {
                      window.location.reload();
                  })
              } else {
                  Swal.fire({
                      type: 'error',
                      text: response.value.message
                  }).then(() => {
                      window.location.reload();
                  })
              }
          });
      });
  });
  //show & hide password
  $(".toggle-old-password, .toggle-password, .toggle-password-confirm").click(function() {
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

  //datepicker
  $( ".datepicker" ).datepicker({
    format: 'yyyy-mm-dd',
    todayHighlight: true,
    endDate: new Date()
  });
</script>

@error('avatars')
@include('components.toastr-error')
@enderror
@endsection