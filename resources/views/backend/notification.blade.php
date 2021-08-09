@extends('layouts.backend.layout')

@section('content')
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
                        <option value="{{ $key }}" {{ Request::get('l') == ''.$key.'' ? 'selected' : '' }} title="@lang('lang.limit')">{{ $val }}</option>
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

@if ($data['notifications']->total() > 0)
<div class="card mb-3">

    <div class="card-header d-none d-md-block">
      <div class="row no-gutters align-items-center">
        <div class="col"></div>
        <div class="col-4 text-muted">
          <div class="row no-gutters align-items-center">
            <div class="col-8">@lang('mod/setting.notification.send')</div>
          </div>
        </div>
      </div>
    </div>

    @foreach ($data['notifications'] as $item)    
    <div class="card-body py-3">

      <div class="row no-gutters align-items-center">
        <div class="col">
          <a href="{{ url('/').'/'.$item->link.'notif_id='.$item->id }}" class="text-big">{!! $item->attribute['content'] !!}</a>
          <div class="text-muted small mt-1">{!! $item->attribute['title'] !!}</div>
        </div>
        <div class="d-none d-md-block col-4">

          <div class="row no-gutters align-items-center">
            <div class="media col-8 align-items-center">
              <div class="media-body flex-truncate ml-2">
                <div class="line-height-1 text-truncate">{{ $item->created_at->diffForHumans() }}</div>
                <a href="javascript:void(0)" class="text-muted small text-truncate">
                  @lang('mod/setting.notification.from')
                  {{ !empty($item->user_from) ? $item->userFrom->name : __('lang.visitor') }}
                </a>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
    <hr class="m-0">
    @endforeach

</div>
@endif

@if ($data['notifications']->total() == 0)
<div class="card files">
    <div class="card-body text-center">
        <strong style="color: red;">
            @if (count(Request::query()) > 0)
            ! @lang('lang.data_attr_not_found', [
              'attribute' => __('mod/setting.notification.caption')
            ]) !
            @else
            ! @lang('lang.data_attr_empty', [
              'attribute' => __('mod/setting.notification.caption')
            ]) !
            @endif
        </strong>
    </div>
</div>
@endif

@if ($data['notifications']->total() > 0)
<div class="card files">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                @lang('pagination.showing') : <strong>{{ $data['notifications']->firstItem() }}</strong> - <strong>{{ $data['notifications']->lastItem() }}</strong> @lang('pagination.of')
                <strong>{{ $data['notifications']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['notifications']->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>
@endif
@endsection