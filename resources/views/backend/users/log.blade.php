@extends('layouts.backend.layout')

@section('styles')
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
            {{-- <div class="text-muted">
              Lorem ipsum dolor sit amet, nibh suavitate qualisque ut nam. Ad harum primis electram duo, porro principes ei has.
            </div> --}}
          </div>
        </div>
        <!-- / Side info -->
  
    </div>
    <div class="col">
        <!-- Filters -->
        <div class="card">
            <div class="card-body">
                <div class="form-row align-items-center">
                    <div class="col-md">
                        <form action="" method="GET">
                            <div class="form-group">
                                <label class="form-label">@lang('lang.limit')</label>
                                <select class="custom-select" name="l">
                                    <option value="20" selected>@lang('lang.any')</option>
                                    @foreach (config('custom.filtering.limit') as $key => $val)
                                    <option value="{{ $key }}" {{ Request::get('l') == ''.$key.'' ? 'selected' : '' }} title="@lang('lang.limit') {{ $val }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>
                    </div>
                    <div class="col-md">
                            <div class="form-group">
                                <label class="form-label">@lang('lang.search')</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="@lang('lang.search_keyword')">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-dark" title="@lang('lang.search')"><i class="las la-filter"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Filters -->
        <div class="card mb-4">
            <div class="card-header with-elements">
                <h5 class="card-header-title mt-1 mb-0">@lang('mod/users.user.caption') @lang('mod/users.user.log.caption')</h5>
            </div>
            <div class="table-responsive table-mobile-responsive">
                <table id="user-list" class="table card-table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 10px;">No</th>
                            <th style="width: 140px;">@lang('mod/users.user.log.label.field1')</th>
                            <th class="text-center" style="width: 120px;">@lang('mod/users.user.log.label.field2')</th>
                            <th>@lang('mod/users.user.log.label.field3')</th>
                            <th style="width: 230px;">@lang('lang.date')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($data['logs']->total() == 0)
                            <tr>
                                <td colspan="5" align="center">
                                    <i>
                                        <strong style="color:red;">
                                        @if (count(Request::query()) > 0)
                                        ! @lang('lang.data_attr_not_found', [
                                            'attribute' => __('mod/users.user.log.caption')
                                        ]) !
                                        @else
                                        ! @lang('lang.data_attr_empty', [
                                            'attribute' => __('mod/users.user.log.caption')
                                        ]) !
                                        @endif
                                        </strong>
                                    </i>
                                </td>
                            </tr>
                        @endif
                        @foreach ($data['logs'] as $item)
                        <tr>
                            <td>{{ $data['no']++ }} </td>
                            <td><strong>{{ $item->ip_address }}</strong></td>
                            <td class="text-center"><span class="badge badge-{{ $item->event_attr['color'] }}">{{ Str::upper($item->event) }}</span></td>
                            <td>
                                <strong>
                                    @if ($item->user_id == Auth::user()->id)
                                        @lang('lang.you')
                                    @else
                                    {{ $item->user->name }}
                                    @endif
                                </strong>
                                {!! $item->event_attr['description'] !!}
                            </td>
                            <td>{{ $item->created_at->format('d F Y (H:i A)') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tbody class="tbody-responsive">
                        @if ($data['logs']->total() == 0)
                            <tr>
                                <td colspan="5" align="center">
                                    <i>
                                        <strong style="color:red;">
                                        @if (count(Request::query()) > 0)
                                        ! @lang('lang.data_attr_not_found', [
                                            'attribute' => __('mod/users.user.log.caption')
                                        ]) !
                                        @else
                                        ! @lang('lang.data_attr_empty', [
                                            'attribute' => __('mod/users.user.log.caption')
                                        ]) !
                                        @endif
                                        </strong>
                                    </i>
                                </td>
                            </tr>
                        @endif
                        @foreach ($data['logs'] as $item)
                        <tr>
                            <td>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="item-table">
                                            <div class="data-table">@lang('mod/users.user.log.label.field1')</div>
                                            <div class="desc-table">
                                                <strong>{{ $item->ip_address }}</strong>
                                            </div>
                                        </div>
                                        <div class="item-table">
                                            <div class="data-table">@lang('mod/users.user.log.label.field2')</div>
                                            <div class="desc-table">
                                                <span class="badge badge-{{ $item->event_attr['color'] }}">{{ Str::upper($item->event) }}</span>
                                            </div>
                                        </div>
                                        <div class="item-table">
                                            <div class="data-table">@lang('mod/users.user.log.label.field3')</div>
                                            <div class="desc-table">
                                                <strong>
                                                    @if ($item->user_id == Auth::user()->id)
                                                        @lang('lang.you')
                                                    @else
                                                    {{ $item->user->name }}
                                                    @endif
                                                </strong>
                                                {!! $item->event_attr['description'] !!}
                                            </div>
                                        </div>
                                        <div class="item-table">
                                            <div class="data-table">@lang('lang.date')</div>
                                            <div class="desc-table">
                                                {{ $item->created_at->format('d F Y (H:i A)') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="row align-items-center">
                    <div class="col-lg-6 m--valign-middle">
                        @lang('pagination.showing') : <strong>{{ $data['logs']->firstItem() }}</strong> - <strong>{{ $data['logs']->lastItem() }}</strong> @lang('pagination.of')
                        <strong>{{ $data['logs']->total() }}</strong>
                    </div>
                    <div class="col-lg-6 m--align-right">
                        {{ $data['logs']->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/backend/fancybox/fancybox.min.js') }}"></script>
<script src="{{ asset('assets/backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection