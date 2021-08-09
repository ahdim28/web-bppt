@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/css/pages/account.css') }}">
@endsection

@section('content')
<h4 class="font-weight-bold py-3 mb-3">
  @lang('mod/dashboard.title')
    <div class="text-muted text-tiny mt-1 time-frame">
        <small class="font-weight-normal">@lang('mod/dashboard.date') {{ now()->format('l, j F Y') }} (<em id="time-part"></em>)</small>
    </div>
</h4>

<div class="row">
    <div class="col-md-12">
      <div class="alert alert-primary alert-dismissible fade show text-muted">
        @lang('mod/dashboard.welcome_back') <strong><em>{!! auth()->user()->name !!}</em></strong> !
      </div>
    </div>
</div>

@if (config('custom.maintenance.mode') == TRUE)
<div class="alert alert-danger alert-dismissible fade show">
  <i class="las la-tools" style="font-size: 1.3em;"></i>
  <strong>@lang('mod/dashboard.maintenance_1')</strong> @lang('mod/dashboard.maintenance_2')
</div>
@endif

{{-- counter --}}
<div class="row drag">
    @can ('pages')    
    <div class="col-sm-6 col-xl-3">
      <div class="card mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="las la-bars display-4 text-primary"></div>
            <div class="ml-3">
              <a href="{{ route('page.index') }}" class="text-muted small">@lang('mod/dashboard.counter.1')</a>
              <div class="text-large">{{ $data['counter']['pages'] }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endcan
    @can('content_sections')  
    <div class="col-sm-6 col-xl-3">
      <div class="card mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="las la-pen-square display-4 text-primary"></div>
            <div class="ml-3">
              <a href="{{ route('section.index') }}" class="text-muted small">@lang('mod/dashboard.counter.2')</a>
              <div class="text-large">{{ $data['counter']['sections'] }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endcan
    @can('content_categories')  
    <div class="col-sm-6 col-xl-3">
      <div class="card mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="las la-list-ul display-4 text-primary"></div>
            <div class="ml-3">
              <a href="{{ route('section.index') }}" class="text-muted small">@lang('mod/dashboard.counter.3')</a>
              <div class="text-large">{{ $data['counter']['categories'] }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endcan
    @can('content_posts')  
    <div class="col-sm-6 col-xl-3">
      <div class="card mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="las la-newspaper display-4 text-primary"></div>
            <div class="ml-3">
              <a href="{{ route('section.index') }}" class="text-muted small">@lang('mod/dashboard.counter.4')</a>
              <div class="text-large">{{ $data['counter']['posts'] }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endcan
    @can('albums')  
    <div class="col-sm-6 col-xl-3">
      <div class="card mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="las la-folder display-4 text-primary"></div>
            <div class="ml-3">
              <a href="{{ route('gallery.album.index') }}" class="text-muted small">@lang('mod/dashboard.counter.5')</a>
              <div class="text-large">{{ $data['counter']['albums'] }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endcan
    @can('photos')  
    <div class="col-sm-6 col-xl-3">
      <div class="card mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="las la-image display-4 text-primary"></div>
            <div class="ml-3">
              <a href="{{ route('gallery.album.index') }}" class="text-muted small">@lang('mod/dashboard.counter.6')</a>
              <div class="text-large">{{ $data['counter']['photos'] }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endcan
    @can('playlists')  
    <div class="col-sm-6 col-xl-3">
      <div class="card mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="las la-folder display-4 text-primary"></div>
            <div class="ml-3">
              <a href="{{ route('gallery.playlist.index') }}" class="text-muted small">@lang('mod/dashboard.counter.7')</a>
              <div class="text-large">{{ $data['counter']['playlists'] }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endcan
    @can('videos')  
    <div class="col-sm-6 col-xl-3">
      <div class="card mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="las la-film display-4 text-primary"></div>
            <div class="ml-3">
              <a href="{{ route('gallery.playlist.index') }}" class="text-muted small">@lang('mod/dashboard.counter.8')</a>
              <div class="text-large">{{ $data['counter']['videos'] }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endcan
</div>

<div class="row drag">
    @can('visitor')
      @if (!empty(env('ANALYTICS_VIEW_ID')))
      {{-- visitor --}}
      <div class="col-md-12">
        <div class="card-header">
          <h6 class="card-header-title mt-0 mb-0"><i class="las la-users" style="font-size: 1.3em;"></i> @lang('mod/dashboard.lists.visitor.title') (<i>@lang('mod/dashboard.lists.visitor.sub')</i>)</h6>
        </div>
        <div class="card mb-4">
          <div class="list-group list-group-flush account-settings-links flex-row">
            <a class="list-group-item list-group-item-action active" data-toggle="list" href="#table">@lang('mod/dashboard.lists.visitor.tabs.1')</a>
            <a class="list-group-item list-group-item-action" data-toggle="list" href="#chart">@lang('mod/dashboard.lists.visitor.tabs.2')</a>
          </div>
          <div class="card-body">
            <div class="tab-content">

              <div class="tab-pane fade show active" id="table">
                <div class="table-responsive">
                  <table class="table card-table">
                    <thead>
                      <tr>
                          @foreach($data['total'] as $total)
                          <th class="text-center">{{ Carbon\Carbon::parse($total['date'])->format('d F') }}</th>
                          @endforeach
                      </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach($data['total'] as $total)
                            <td class="text-center">
                              <strong>{{ $total['visitors'] }}</strong>
                            </td>
                            @endforeach
                        </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="chart">
                <canvas id="myChart"></canvas>
              </div>

            </div>
          </div>
          <div class="card-footer">
            <a href="{{ route('visitor') }}" class="d-block text-center text-body small font-weight-semibold">@lang('lang.show_more')</a>
          </div>
        </div>
      </div>
      @endif
    @endcan

    @can('content_posts')  
    {{-- latest post --}}
    <div class="col-md-6">
      <div class="card mb-4 card-list">
        <h6 class="card-header"><i class="las la-newspaper" style="font-size: 1.3em;"></i> @lang('mod/dashboard.lists.post.title')</h6>
        <div class="table-responsive">
          <table class="table card-table">
            <thead>
              <tr>
                <th colspan="2">@lang('mod/dashboard.lists.post.th1')</th>
                <th>@lang('mod/dashboard.lists.post.th2')</th>
                <th>@lang('mod/dashboard.lists.post.th3')</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @forelse ($data['lists']['posts'] as $post)
              <tr>
                <td class="align-middle" style="width: 75px">
                  <img class="ui-w-40" src="{{ $post->coverSrc($post) }}" alt="">
                </td>
                <td class="align-middle">
                  <a href="javascript:void(0)" class="text-body">{!! Str::limit($post->fieldLang('title'), 40) !!}</a>
                </td>
                <td class="align-middle">{!! $post->category->fieldLang('name') !!}</td>
                <td class="align-middle"><span class="badge badge-info">{{ $post->viewer }}</span></td>
                <td class="align-middle">
                  <a href="{{ route('post.read.'.$post->section->slug, ['slugPost' => $post->slug]) }}" class="btn icon-btn btn-sm btn-primary" title="view post">
                      <i class="las la-external-link-alt"></i>
                  </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" align="center">
                  <i><strong style="color:red;">! @lang('lang.data_attr_empty', [
                    'attribute' => __('mod/dashboard.lists.post.title')
                  ]) !</strong></i>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
          <a href="{{ route('section.index') }}" class="card-footer d-block text-center text-body small font-weight-semibold">@lang('lang.show_more')</a>
        </div>
      </div>
    </div>
    @endcan

    @can('inquiries')  
    {{-- latest inquiry --}}
    <div class="col-md-6">
      <div class="card mb-4 card-list">
        <h6 class="card-header">
          <div class="title-text"><i class="las la-envelope" style="font-size: 1.3em;"></i> @lang('mod/dashboard.lists.inquiry.title')</div>
        </h6>
        <div class="card-body">

          @forelse ($data['lists']['inquiries'] as $inquiry)
          <div class="media pb-1 mb-3">
            <img src="{{ asset(config('custom.files.avatars.file')) }}" class="d-block ui-w-40 rounded-circle" alt="">
            <div class="media-body flex-truncate ml-3">
              <a href="javascript:void(0)">{!! $inquiry->fields['name'] !!}</a>
              <span class="text-muted">@lang('mod/dashboard.lists.inquiry.send')</span>
              <a href="{{ route('inquiry.detail', ['id' => $inquiry->inquiry_id]) }}">{{ $inquiry->inquiry->fieldLang('name') }}</a>
              <p class="text-truncate my-1"></p>
              <div class="clearfix">
                <span class="float-left text-muted small">{{ $inquiry->submit_time->diffForHumans() }}</span>
              </div>
            </div>
          </div>
          @empty
          <div class="media pb-1 mb-3">
            <div class="media-body flex-truncate ml-3 text-center">
              <i><strong style="color:red;">! @lang('lang.data_attr_empty', [
                'attribute' => __('mod/dashboard.lists.inquiry.title')
              ]) !</strong></i>
            </div>
          </div>
          @endforelse

        </div>
        <a href="{{ route('inquiry.index') }}" class="card-footer d-block text-center text-body small font-weight-semibold">@lang('lang.show_more')</a>
      </div>
    </div>
    @endcan
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/backend/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('assets/backend/vendor/libs/chartjs/chartjs.js') }}"></script>
@endsection

@section('jsbody')
<script src="{{ asset('assets/backend/jquery-ui.js') }}"></script>
<script>
  $(document).ready(function() {
      var interval = setInterval(function() {
          var momentNow = moment();
          $('#time-part').html(momentNow.format('hh:mm:ss A'));
      }, 100);
  });

  $(function () {
      $(".drag").sortable({
          connectWith: '.drag',
          update : function (event, ui) {
              var data  = $(this).sortable('toArray');
              $.ajax({
                  data: {'datas' : data},
                  url: '/',
                  dataType:'json',
              });
          }
      });
      $( "#drag" ).disableSelection();
  });
</script>

@if (!empty(env('ANALYTICS_VIEW_ID')))
<script>
  //chart
  const labels = {!! json_encode($data['graph_visitor']['label']) !!};

  const data = {
      labels: labels,
      datasets: [{
          label: '@lang('mod/setting.notification.visitor')',
          backgroundColor: 'rgb(0, 132, 255, 1)',
          borderColor: 'rgb(0, 132, 255, 1)',
          data: {!! json_encode($data['graph_visitor']['visitor']) !!},
      }]
  };

  const config = {
      type: 'line',
      data,
      options: {}
  };

  var myChart = new Chart(
      document.getElementById('myChart'),
      config
  );
</script>
@endif
@endsection
