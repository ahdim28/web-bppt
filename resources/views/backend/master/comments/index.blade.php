@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

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
                    <label class="form-label">@lang('mod/master.tag.label.field3')</label>
                    <select class="status custom-select" name="f">
                        <option value=" " selected>@lang('lang.any')</option>
                        @foreach (config('custom.label.flags') as $key => $val)
                        <option value="{{ $key }}" {{ Request::get('f') == ''.$key.'' ? 'selected' : '' }} title="{{ __($val['title']) }}">{{ __($val['title']) }}</option>
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
        <h5 class="card-header-title mt-1 mb-0">@lang('mod/master.comment.text')</h5>
    </div>
    <div class="table-responsive table-mobile-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>@lang('mod/master.comment.label.field1')</th>
                    <th>@lang('mod/master.comment.label.field2')</th>
                    <th style="width: 200px;">Module</th>
                    <th class="text-center" style="width: 150px;">@lang('mod/master.comment.label.field3')</th>
                    <th class="text-center" style="width: 80px;">@lang('mod/master.comment.reply')</th>
                    <th style="width: 215px;">@lang('lang.created')</th>
                    <th style="width: 215px;">@lang('lang.updated')</th>
                    <th class="text-center" style="width: 170px;">@lang('lang.action')</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['comments']->total() == 0)
                    <tr>
                        <td colspan="9" align="center">
                            <i>
                                <strong style="color:red;">
                                @if (count(Request::query()) > 0)
                                ! @lang('lang.data_attr_not_found', [
                                    'attribute' => __('mod/master.comment.caption')
                                ]) !
                                @else
                                ! @lang('lang.data_attr_empty', [
                                    'attribute' => __('mod/master.comment.caption')
                                ]) !
                                @endif
                                </strong>
                            </i>
                        </td>
                    </tr>
                @endif
                @foreach ($data['comments'] as $item)
                <tr>
                    <td>{{ $data['no']++ }} </td>
                    <td><strong>{{ $item->user->name }}</strong></td>
                    <td>{{ Str::limit($item->comment, 80) }}</td>
                    <td><code>{{ $item->commentable_type ?? '[No Module]' }}</code></td>
                    <td class="text-center">
                        @can ('comment_edit')
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="badge badge-{{ $item->customConfig()['flags']['color'] }}"
                            title="@lang('mod/master.comment.label.field3')">
                            {{ __($item->customConfig()['flags']['title']) }}
                            <form action="{{ route('comment.flags', ['id' => $item->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <span class="badge badge-{{ $item->customConfig()['flags']['color'] }}">{{ __($item->customConfig()['flags']['title']) }}</span>
                        @endcan
                    </td>
                    <td class="text-center">
                        <span class="badge badge-info">{{ $item->reply->count() }}</span>
                    </td>
                    <td>{{ $item->created_at->format('d F Y (H:i A)') }}</td>
                    <td>{{ $item->updated_at->format('d F Y (H:i A)') }}</td>
                    <td class="text-center">
                        <a href="{{ route('comment.detail', ['id' => $item->id]) }}" class="btn btn-warning btn-sm" title="@lang('mod/master.comment.reply')">
                            <i class="las la-comments"></i> @lang('mod/master.comment.reply')
                        </a>
                        @can ('comment_delete')
                        <button type="button" class="btn btn-danger icon-btn btn-sm swal-delete" title="@lang('lang.delete_attr', [
                            'attribute' => __('mod/master.comment.caption')
                        ])"
                            data-id="{{ $item->id }}">
                            <i class="las la-trash-alt"></i>
                        </button>
                        @else
                        <button type="button" class="btn btn-danger icon-btn btn-sm" title="@lang('alert.access_denied')" disabled>
                            <i class="las la-trash-alt"></i>
                        </button>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['comments']->total() == 0)
                    <tr>
                        <td colspan="9" align="center">
                            <i>
                                <strong style="color:red;">
                                @if (count(Request::query()) > 0)
                                ! @lang('lang.data_attr_not_found', [
                                    'attribute' => __('mod/master.comment.caption')
                                ]) !
                                @else
                                ! @lang('lang.data_attr_empty', [
                                    'attribute' => __('mod/master.comment.caption')
                                ]) !
                                @endif
                                </strong>
                            </i>
                        </td>
                    </tr>
                @endif
                @foreach ($data['comments'] as $item)
                <tr>
                    <td>
                        <div class="card">
                            <div class="card-body">
                                <div class="item-table">
                                    <div class="data-table">@lang('mod/master.comment.label.field1')</div>
                                    <div class="desc-table">
                                        <strong>{{ $item->user->name }}</strong>
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('mod/master.comment.label.field2')</div>
                                    <div class="desc-table">{{ Str::limit($item->comment, 80) }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Module</div>
                                    <div class="desc-table"><code>{{ $item->commentable_type ?? '[No Module]' }}</code></div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('mod/master.comment.label.field3')</div>
                                    <div class="desc-table">
                                        @can ('comment_edit')
                                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="badge badge-{{ $item->customConfig()['flags']['color'] }}"
                                            title="@lang('mod/master.comment.label.field3')">
                                            {{ __($item->customConfig()['flags']['title']) }}
                                            <form action="{{ route('comment.flags', ['id' => $item->id]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                        </a>
                                        @else
                                        <span class="badge badge-{{ $item->customConfig()['flags']['color'] }}">{{ __($item->customConfig()['flags']['title']) }}</span>
                                        @endcan
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('mod/master.comment.reply')</div>
                                    <div class="desc-table">
                                        <span class="badge badge-info">{{ $item->reply->count() }}</span>
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('lang.created')</div>
                                    <div class="desc-table">
                                        {{ $item->created_at->format('d F Y (H:i A)') }}
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('lang.updated')</div>
                                    <div class="desc-table">
                                        {{ $item->updated_at->format('d F Y (H:i A)') }}
                                    </div>
                                </div>
                                <div class="item-table m-0">
                                    <div class="desc-table text-right">
                                        <a href="{{ route('comment.detail', ['id' => $item->id]) }}" class="btn btn-warning btn-sm" title="@lang('mod/master.comment.reply')">
                                            <i class="las la-comments"></i> @lang('mod/master.comment.reply')
                                        </a>
                                        @can ('comment_delete')
                                        <button type="button" class="btn btn-danger icon-btn btn-sm swal-delete" title="@lang('lang.delete_attr', [
                                            'attribute' => __('mod/master.comment.caption')
                                        ])"
                                            data-id="{{ $item->id }}">
                                            <i class="las la-trash-alt"></i>
                                        </button>
                                        @else
                                        <button type="button" class="btn btn-danger icon-btn btn-sm" title="@lang('alert.access_denied')" disabled>
                                            <i class="las la-trash-alt"></i>
                                        </button>
                                        @endcan
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
                @lang('pagination.showing') : <strong>{{ $data['comments']->firstItem() }}</strong> - <strong>{{ $data['comments']->lastItem() }}</strong> @lang('pagination.of')
                <strong>{{ $data['comments']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['comments']->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script>
    //alert delete
    $(document).ready(function () {
        $('.swal-delete').on('click', function () {
            var id = $(this).attr('data-id');
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
                        url: '/admin/comment/' + id,
                        method: 'DELETE',
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
                        text: "@lang('alert.delete_success', ['attribute' => __('mod/master.comment.caption')])"
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
</script>
@endsection