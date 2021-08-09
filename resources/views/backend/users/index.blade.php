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
                    <label class="form-label">@lang('mod/users.user.label.field11')</label>
                    <select class="custom-select" name="r">
                        <option value=" " selected>@lang('lang.any')</option>
                        @foreach ($data['roles'] as $role)
                        <option value="{{ $role->id }}" {{ $role->id == Request::get('r') ? 'selected' : '' }} title="{{ $role->name }}">{{ Str::upper($role->name) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md">
                <div class="form-group">
                    <label class="form-label">@lang('lang.status')</label>
                    <select class="custom-select" name="a">
                        <option value=" " selected>@lang('lang.any')</option>
                        @foreach (config('custom.label.active') as $key => $val)
                        <option value="{{ $key }}" {{ Request::get('a') == ''.$key.'' ? 'selected' : '' }} title="{{ __($val['title']) }}">{{ __($val['title']) }}</option>
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
        <h5 class="card-header-title mt-1 mb-0">@lang('mod/users.user.text')</h5>
        <div class="card-header-elements ml-auto">
            @role('super')
            <a href="{{ route('user.trash') }}" class="btn btn-secondary icon-btn-only-sm" title="@lang('lang.trash')">
                <i class="las la-trash"></i> <span>@lang('lang.trash')</span>
            </a>
            @endrole
            @can('user_create')
            <a href="{{ route('user.create') }}" class="btn btn-success icon-btn-only-sm" title="@lang('lang.add_attr_new', [
                'attribute' => __('mod/users.user.caption')
            ])">
                <i class="las la-plus"></i> <span>@lang('mod/users.user.caption')</span>
            </a>
            @endcan
        </div>
    </div>
    <div class="table-responsive table-mobile-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>@lang('mod/users.user.label.field1')</th>
                    <th>@lang('mod/users.user.label.field2')</th>
                    <th>@lang('mod/users.user.label.field3')</th>
                    <th class="text-center">@lang('mod/users.user.label.field11')</th>
                    <th class="text-center">@lang('lang.status')</th>
                    <th style="width: 215px;">@lang('mod/users.user.last_activity')</th>
                    <th style="width: 215px;">@lang('lang.created')</th>
                    <th style="width: 215px;">@lang('lang.updated')</th>
                    <th class="text-center" style="width: 140px;">@lang('lang.action')</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['users']->total() == 0)
                <tr>
                    <td colspan="10" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (count(Request::query()) > 0)
                            ! @lang('lang.data_attr_not_found', [
                                'attribute' => __('mod/users.user.caption')
                            ]) !
                            @else
                            ! @lang('lang.data_attr_empty', [
                                'attribute' => __('mod/users.user.caption')
                            ]) !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['users'] as $item)
                <tr>
                    <td>{{ $data['no']++ }} </td>
                    <td><strong>{{ $item->name }}</strong></td>
                    <td>
                        <a href="mailto:{{ $item->email }}" title="{{ $item->email }}">{{ $item->email }}</a>
                    </td>
                    <td>{{ $item->username }}</td>
                    <td class="text-center"><span class="badge badge-primary">{{ Str::upper($item->roles[0]->name) }}</span></td>
                    <td class="text-center">
                        @if (Auth::user()->can('user_update') && $item->roles[0]->id >= Auth::user()->roles[0]->id && ($item->id != Auth::user()->id))
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="badge badge-{{ $item->customConfig()['active']['color'] }}"
                            title="@lang('mod/users.user.label.field6')">
                            {{ __($item->customConfig()['active']['title']) }}
                            <form action="{{ route('user.activate', ['id' => $item->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <span class="badge badge-{{ $item->customConfig()['active']['color'] }}">{{ __($item->customConfig()['active']['title']) }}</span>
                        @endif
                    </td>
                    <td>{{ !empty($item->session) ? $item->session->last_activity->format('d F Y (H:i A)') : __('mod/users.user.no_activity') }}</td>
                    <td>
                        {{ $item->created_at->format('d F Y (H:i A)') }}
                        @if (!empty($item->created_by))
                        <br>
                        <span class="text-muted"> @lang('lang.by') : {{ $item->createBy()->name }}</span>
                        @endif
                    </td>
                    <td>
                        {{ $item->updated_at->format('d F Y (H:i A)') }}
                        @if (!empty($item->updated_by))
                        <br>
                        <span class="text-muted"> @lang('lang.by') : {{ $item->updateBy()->name }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if (Auth::user()->can('user_update') && $item->roles[0]->id >= Auth::user()->roles[0]->id && ($item->id != Auth::user()->id))
                        <a href="{{ route('log.user', ['id' => $item->id]) }}" class="btn btn-warning btn-sm icon-btn" title="@lang('mod/users.user.log.caption')">
                            <i class="las la-user-clock"></i>
                        </a>
                        <a href="{{ route('user.edit', ['id' => $item->id]) }}" class="btn btn-primary icon-btn btn-sm" title="@lang('lang.edit_attr', [
                            'attribute' => __('mod/users.user.caption')
                        ])">
                            <i class="las la-pen"></i>
                        </a>
                        @else
                        <button type="button" class="btn btn-secondary btn-sm icon-btn" title="@lang('alert.access_denied')" disabled>
                            <i class="las la-user-clock"></i>
                        </button>
                        <button type="button" class="btn btn-secondary icon-btn btn-sm" title="@lang('alert.access_denied')" disabled>
                            <i class="las la-pen"></i>
                        </button>
                        @endif
                        @if (Auth::user()->can('user_delete') && $item->roles[0]->id >= Auth::user()->roles[0]->id && ($item->id != Auth::user()->id))
                            @if (Auth::user()->hasRole('super'))    
                            <button type="button" class="btn btn-danger icon-btn btn-sm modal-delete"
                                data-toggle="modal"
                                data-target="#modals-delete"
                                data-id="{{ $item->id }}"
                                data-name="{{ $item->name }}" title="@lang('lang.delete_attr', [
                                    'attribute' => __('mod/users.user.caption')
                                ])">
                                <i class="las la-trash-alt"></i>
                            </button>
                            @else
                            <button type="button" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="@lang('lang.delete_attr', [
                                    'attribute' => __('mod/users.user.caption')
                                ])">
                                <i class="las la-trash-alt"></i>
                            </button>
                            @endif
                        @else
                        <button type="button" class="btn btn-secondary icon-btn btn-sm" title="@lang('alert.access_denied')" disabled>
                            <i class="las la-trash-alt"></i>
                        </button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['users']->total() == 0)
                <tr>
                    <td colspan="10" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (count(Request::query()) > 0)
                            ! @lang('lang.data_attr_not_found', [
                                'attribute' => __('mod/users.user.caption')
                            ]) !
                            @else
                            ! @lang('lang.data_attr_empty', [
                                'attribute' => __('mod/users.user.caption')
                            ]) !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['users'] as $item)
                <tr>
                    <td>
                        <div class="card">
                            <div class="card-body">
                                <div class="item-table">
                                    <div class="data-table">@lang('mod/users.user.label.field1')</div>
                                    <div class="desc-table"><strong>{{ $item->name }}</strong></div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('mod/users.user.label.field2')</div>
                                    <div class="desc-table">
                                        <a href="mailto:{{ $item->email }}" title="{{ $item->email }}">{{ $item->email }}</a>
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('mod/users.user.label.field3')</div>
                                    <div class="desc-table">{{ $item->username }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('mod/users.user.label.field11')</div>
                                    <div class="desc-table"><span class="badge badge-primary">{{ Str::upper($item->roles[0]->name) }}</span></div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('lang.status')</div>
                                    <div class="desc-table">
                                        @if (Auth::user()->can('user_update') && $item->roles[0]->id >= Auth::user()->roles[0]->id && ($item->id != Auth::user()->id))
                                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="badge badge-{{ $item->customConfig()['active']['color'] }}"
                                            title="@lang('mod/users.user.field6')">
                                            {{ __($item->customConfig()['active']['title']) }}
                                            <form action="{{ route('user.activate', ['id' => $item->id]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                        </a>
                                        @else
                                        <span class="badge badge-{{ $item->customConfig()['active']['color'] }}">{{ __($item->customConfig()['active']['title']) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('mod/users.user.last_activity')</div>
                                    <div class="desc-table">{{ !empty($item->session) ? $item->session->last_activity->format('d F Y (H:i A)') : __('mod/users.user.no_activity') }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('lang.created')</div>
                                    <div class="desc-table">
                                        {{ $item->created_at->format('d F Y (H:i A)') }}
                                        @if (!empty($item->created_by))
                                        <br>
                                        <span class="text-muted"> @lang('lang.by') : {{ $item->createBy()->name }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('lang.updated')</div>
                                    <div class="desc-table">
                                        {{ $item->updated_at->format('d F Y (H:i A)') }}
                                        @if (!empty($item->updated_by))
                                        <br>
                                        <span class="text-muted"> @lang('lang.by') : {{ $item->updateBy()->name }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="item-table m-0">
                                    <div class="desc-table text-right">
                                        @if (Auth::user()->can('user_update') && $item->roles[0]->id >= Auth::user()->roles[0]->id && ($item->id != Auth::user()->id))
                                        <a href="{{ route('log.user', ['id' => $item->id]) }}" class="btn btn-warning btn-sm icon-btn" title="@lang('mod/users.user.log.caption')">
                                            <i class="las la-user-clock"></i>
                                        </a>
                                        <a href="{{ route('user.edit', ['id' => $item->id]) }}" class="btn btn-primary icon-btn btn-sm" title="@lang('lang.edit_attr', [
                                            'attribute' => __('mod/users.user.caption')
                                        ])">
                                            <i class="las la-pen"></i>
                                        </a>
                                        @else
                                        <button type="button" class="btn btn-secondary btn-sm icon-btn" title="@lang('alert.access_denied')" disabled>
                                            <i class="las la-user-clock"></i>
                                        </button>
                                        <button type="button" class="btn btn-secondary icon-btn btn-sm" title="@lang('alert.access_denied')" disabled>
                                            <i class="las la-pen"></i>
                                        </button>
                                        @endif
                                        @if (Auth::user()->can('user_delete') && $item->roles[0]->id >= Auth::user()->roles[0]->id && ($item->id != Auth::user()->id))
                                            @if (Auth::user()->hasRole('super'))    
                                            <button type="button" class="btn btn-danger icon-btn btn-sm modal-delete"
                                                data-toggle="modal"
                                                data-target="#modals-delete"
                                                data-id="{{ $item->id }}"
                                                data-name="{{ $item->name }}" title="@lang('lang.delete_attr', [
                                                    'attribute' => __('mod/users.user.caption')
                                                ])">
                                                <i class="las la-trash-alt"></i>
                                            </button>
                                            @else
                                            <button type="button" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="@lang('lang.delete_attr', [
                                                    'attribute' => __('mod/users.user.caption')
                                                ])">
                                                <i class="las la-trash-alt"></i>
                                            </button>
                                            @endif
                                        @else
                                        <button type="button" class="btn btn-secondary icon-btn btn-sm" title="@lang('alert.access_denied')" disabled>
                                            <i class="las la-trash-alt"></i>
                                        </button>
                                        @endif
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
                @lang('pagination.showing') : <strong>{{ $data['users']->firstItem() }}</strong> - <strong>{{ $data['users']->lastItem() }}</strong> @lang('pagination.of')
                <strong>{{ $data['users']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['users']->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>

@include('backend.users.modal-delete')
@endsection

@section('scripts')
<script src="{{ asset('assets/backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script>
    //confirm delete
    $('.modal-delete').click(function() {
        var id = $(this).data('id');
        var name = $(this).data('name');

        $('.modal-title #name').text(name);
        $('.modal-footer .id').attr('data-id', id);
    });

    $(document).ready(function () {
        //soft delete
        $('.soft-delete').on('click', function () {
            var id = $(this).attr('data-id');
            Swal.fire({
                title: "@lang('alert.delete_confirm_trash_title')",
                text: "@lang('alert.delete_confirm_text')",
                type: "warning",
                confirmButtonText: "@lang('lang.move_trash')",
                customClass: {
                    confirmButton: "btn btn-warning btn-lg",
                    cancelButton: "btn btn-primary btn-lg"
                },
                showLoaderOnConfirm: true,
                showCancelButton: true,
                allowOutsideClick: () => !Swal.isLoading(),
                cancelButtonText: "@lang('alert.delete_btn_cancel')",
                preConfirm: () => {
                    return $.ajax({
                        url: '/admin/user/' + id + '/soft',
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
                        text: "@lang('alert.delete_success', ['attribute' => __('mod/users.user.caption')])"
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
        //permanent delete
        $('.permanent-delete').on('click', function () {
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
                        url: '/admin/user/' + id + '/permanent?is_trash={{ Request::get('is_trash') }}',
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
                        text: "@lang('alert.delete_success', ['attribute' => __('mod/users.user.caption')])"
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
        //delete by another role
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
                        url: '/admin/user/' + id + '/soft',
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
                        text: "@lang('alert.delete_success', ['attribute' => __('mod/users.user.caption')])"
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