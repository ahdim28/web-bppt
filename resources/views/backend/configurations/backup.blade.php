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

<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">@lang('mod/setting.backup.text')</h5>
    </div>
    <div class="table-responsive table-mobile-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>@lang('mod/setting.backup.label.field1')</th>
                    <th style="width: 215px;">@lang('lang.date')</th>
                    <th class="text-center" style="width: 80px;">@lang('lang.action')</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['backups']->total() == 0)
                <tr>
                    <td colspan="4" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (count(Request::query()) > 0)
                            ! @lang('lang.data_attr_not_found', [
                                'attribute' => __('mod/setting.backup.title')
                            ]) !
                            @else
                            ! @lang('lang.data_attr_empty', [
                                'attribute' => __('mod/setting.backup.title')
                            ]) !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['backups'] as $item)
                <tr>
                    <td>{{ $data['no']++ }}</td>
                    <td><strong>{{ $item->file_path }}</strong></td>
                    <td>{{ $item->backup_date->format('d F Y H:i (A)') }}</td>
                    <td class="text-center">
                        <a href="{{ route('backup.download', ['id' => $item->id]) }}" class="btn btn-primary btn-sm" title="@lang('lang.download')">
                            <i class="las la-download"></i> @lang('lang.download')
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['backups']->total() == 0)
                <tr>
                    <td colspan="4" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (count(Request::query()) > 0)
                            ! @lang('lang.data_attr_not_found', [
                                'attribute' => __('mod/setting.backup.title')
                            ]) !
                            @else
                            ! @lang('lang.data_attr_empty', [
                                'attribute' => __('mod/setting.backup.title')
                            ]) !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['backups'] as $item)
                <tr>
                    <td>
                        <div class="card">
                            <div class="card-body">
                                <div class="item-table">
                                    <div class="data-table">@lang('mod/setting.backup.label.field1')</div>
                                    <div class="desc-table"><strong>{{ $item->file_path }}</strong></div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('lang.date')</div>
                                    <div class="desc-table">{{ $item->backup_date->format('d F Y H:i (A)') }}</div>
                                </div>
                                <div class="item-table m-0">
                                    <div class="desc-table text-right">
                                        <a href="{{ route('backup.download', ['id' => $item->id]) }}" class="btn btn-primary btn-sm" title="@lang('lang.download')">
                                            <i class="las la-download"></i> @lang('lang.download')
                                        </a>
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
                @lang('pagination.showing') : <strong>{{ $data['backups']->firstItem() }}</strong> - <strong>{{ $data['backups']->lastItem() }}</strong> @lang('pagination.of')
                <strong>{{ $data['backups']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['backups']->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
