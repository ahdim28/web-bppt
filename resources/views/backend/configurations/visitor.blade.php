@extends('layouts.backend.layout')

@section('content')
<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <div class="form-row align-items-center">
          <div class="col-md">
            <div class="form-group">
                <label class="form-label">@lang('lang.filter')</label>
                <select class="filter custom-select" name="f">
                    <option value=" " selected>@lang('lang.any')</option>
                    @foreach (config('custom.filtering.visitor') as $key => $value)
                    <option value="{{ $key }}" {{ (Request::get('f') == $key) ? 'selected' : '' }} title="{{ __($value) }}">{{ __($value) }}</option>
                    @endforeach
                </select>
            </div>
          </div>
        </div>
    </div>
</div>
<!-- / Filters -->

@if (isset($data['visitor']))
    @if (empty(env('ANALYTICS_VIEW_ID')))
    <div class="alert alert-warning alert-dismissible">
        <strong>@lang('mod/setting.visitor.warning1')</strong> @lang('mod/setting.visitor.warning2')
    </div>
    @endif
@else
<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <h6 class="card-header">@lang('mod/setting.visitor.card1')</h6>
            <div class="d-flex justify-content-center">
                <canvas id="chart-pie" height="450" class="chartjs-demo"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <!-- Popular products -->
        <div class="card mb-4">
            <h6 class="card-header">@lang('mod/setting.visitor.card2')</h6>
            <canvas id="chart-bars" height="450" class="chartjs-demo"></canvas>
        </div>
        <!-- / Popular products -->
    </div>
    <div class="col-md-12">
        <!-- Popular products -->
        <div class="card mb-4">
            <h6 class="card-header">@lang('mod/setting.visitor.title')</h6>
            <canvas id="chart-graph" height="450" class="chartjs-demo"></canvas>
        </div>
        <!-- / Popular products -->
    </div>
    <div class="col-md-6">
        <!-- Popular products -->
        <div class="card mb-4">
            <h6 class="card-header">@lang('mod/setting.visitor.card3')</h6>
            <div class="table-responsive">
            <table class="table card-table">
                <thead>
                    <tr>
                        <th>@lang('mod/setting.visitor.label.field1')</th>
                        <th class="text-center">@lang('lang.viewer')</th>
                        <th class="text-center">@lang('mod/setting.visitor.title')</th>
                        <th>@lang('mod/setting.visitor.label.field2')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['vp']->take(5)->sortbydesc('visitors') as $v)
                    <tr>
                    <td title="{{ $v['pageTitle'] }}">{{ Str::limit($v['pageTitle'], 60) }}</td>
                    <td class="text-center">
                        <strong>{{ $v['pageViews'] }}</strong>
                    </td>
                    <td class="text-center">
                        <strong>{{ $v['visitors'] }}</strong>
                    </td>
                    <td>{{ Carbon\Carbon::parse($v['date'])->format('d F Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
        <!-- / Popular products -->
    </div>
    <div class="col-md-6">
        <!-- Popular products -->
        <div class="card mb-4">
            <h6 class="card-header">@lang('mod/setting.visitor.card3')</h6>
            <div class="table-responsive">
            <table class="table card-table">
                <thead>
                    <tr>
                        <th>@lang('mod/setting.visitor.label.field3')</th>
                        <th class="text-center">@lang('lang.date')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['top']->take(5) as $tt)
                    <tr>
                        <td>
                            <a href="{{ url('/').$tt['url'] }}" title="{{ $tt['pageTitle'] }}">
                                @if ($tt['pageTitle'] == '(not set)')
                                    Home 
                                @else
                                    {{ Str::limit($tt['pageTitle'], 85) }}
                                @endif
                            </a>
                        </td>
                        <td class="text-center">
                            <strong>{{ $tt['pageViews'] }}</strong> 
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
        <!-- / Popular products -->
    </div>
</div>
@endif
@endsection

@section('scripts')
<script src="{{ asset('assets/backend/vendor/libs/chartjs/chartjs.js') }}"></script>
@endsection

@section('jsbody')
<script>
    $('.filter').on('change', function () {
        var url = $(this).val();
        if (url) {
            window.location = '?f='+url;
        }

        return false;
    });
</script>
@if (!isset($data['visitor']))
<script>
    //pie
    var pieChart = new Chart(document.getElementById('chart-pie').getContext("2d"), {
        type: 'pie',
        data: {
        labels: {!! json_encode($data['session_visitor']['label']) !!},
            datasets: [{
                data: {!! json_encode($data['session_visitor']['total']) !!},
                backgroundColor: ['#0084ff', '#ec1c24'],
                hoverBackgroundColor: ['#0084ff', '#ec1c24']
            }]
        },

        options: {
        responsive: false,
        maintainAspectRatio: false
        }
    });

    //barchart
    var barsChart = new Chart(document.getElementById('chart-bars').getContext("2d"), {
        type: 'bar',
        data: {
            labels: {!! json_encode($data['browser_visitor']['label']) !!},
            datasets: [{
                label: '@lang('mod/setting.visitor.title')',
                data: {!! json_encode($data['browser_visitor']['total']) !!},
                borderWidth: 1,
                backgroundColor: '#ec1c24',
                borderColor: '#ec1c24',
            }]
        },

        // Demo
        options: {
        responsive: false,
        maintainAspectRatio: false
        }
    });

    //graphchart
    var graphChart = new Chart(document.getElementById('chart-graph').getContext("2d"), {
        type: 'line',
        data: {
        labels: {!! json_encode($data['total_visitor']['label']) !!},
        datasets: [{
            label: '@lang('mod/setting.visitor.title')',
            data: {!! json_encode($data['total_visitor']['total']) !!},
            borderWidth: 1,
            backgroundColor: 'rgb(0, 132, 255, 1)',
            borderColor: '#0084ff',
        }],
        },

        // Demo
        options: {
        responsive: false,
        maintainAspectRatio: false
        }
    });
</script>
@endif
@endsection
