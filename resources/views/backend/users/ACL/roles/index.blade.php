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
        <h5 class="card-header-title mt-1 mb-0">@lang('mod/users.role.text')</h5>
        <div class="card-header-elements ml-auto">
            <button type="button" class="btn btn-success icon-btn-only-sm modal-create" 
                data-toggle="modal" 
                data-target="#modals-create" title="@lang('lang.add_attr_new', [
                    'attribute' => __('mod/users.role.caption')
                ])">
                <i class="las la-plus"></i> <span>@lang('mod/users.role.caption')</span>
            </button>
        </div>
    </div>
    <div class="table-responsive table-mobile-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>@lang('mod/users.role.label.field1')</th>
                    <th>@lang('mod/users.role.label.field2')</th>
                    <th>@lang('mod/users.role.label.field3')</th>
                    <th style="width: 215px;">@lang('lang.created')</th>
                    <th style="width: 215px;">@lang('lang.updated')</th>
                    <th class="text-center" style="width: 250px;">@lang('lang.action')</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['roles']->total() == 0)
                <tr>
                    <td colspan="7" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (count(Request::query()) > 0)
                            ! @lang('lang.data_attr_not_found', [
                                'attribute' => __('mod/users.role.caption')
                            ]) !
                            @else
                            ! @lang('lang.data_attr_empty', [
                                'attribute' => __('mod/users.role.caption')
                            ]) !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['roles'] as $item)
                <tr>
                    <td>{{ $data['no']++ }}</td>
                    <td><strong>{{ Str::replace('_', ' ', Str::upper($item->name)) }}</strong></td>
                    <td><code>{{ $item->name }}</code></td>
                    <td>{{ $item->guard_name }}</td>
                    <td>{{ $item->created_at->format('d F Y (H:i A)') }}</td>
                    <td>{{ $item->updated_at->format('d F Y (H:i A)') }}</td>
                    <td class="text-center">
                        <a href="{{ route('role.permission', ['id' => $item->id]) }}" class="btn btn-warning btn-sm" title="@lang('mod/users.permission.caption')">
                            <i class="las la-user-shield"></i> @lang('mod/users.permission.caption')
                        </a>
                        <button type="button" class="btn btn-primary icon-btn btn-sm modal-edit" title="@lang('lang.edit_attr', [
                            'attribute' => __('mod/users.role.caption')
                        ])"
                            data-toggle="modal"
                            data-target="#modals-edit"
                            data-id="{{ $item->id }}"
                            data-name="{{ $item->name }}">
                            <i class="las la-pen"></i>
                        </button>
                        <button type="button" class="btn btn-danger icon-btn btn-sm swal-delete" title="@lang('lang.delete_attr', [
                            'attribute' => __('mod/users.role.caption')
                        ])"
                            data-id="{{ $item->id }}">
                            <i class="las la-trash-alt"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['roles']->total() == 0)
                <tr>
                    <td colspan="7" align="center">
                        <i>
                            <strong style="color:red;">
                            @if (count(Request::query()) > 0)
                            ! @lang('lang.data_attr_not_found', [
                                'attribute' => __('mod/users.role.caption')
                            ]) !
                            @else
                            ! @lang('lang.data_attr_empty', [
                                'attribute' => __('mod/users.role.caption')
                            ]) !
                            @endif
                            </strong>
                        </i>
                    </td>
                </tr>
                @endif
                @foreach ($data['roles'] as $item)
                <tr>
                    <td>
                        <div class="card">
                            <div class="card-body">
                                <div class="item-table">
                                    <div class="data-table">@lang('mod/users.role.label.field1')</div>
                                    <div class="desc-table"><strong>{{ Str::replace('_', ' ', Str::upper($item->name)) }}</strong></div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('mod/users.role.label.field2')</div>
                                    <div class="desc-table"><code>{{ $item->name }}</code></div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('mod/users.role.label.field3')</div>
                                    <div class="desc-table">{{ $item->guard_name }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('lang.created')</div>
                                    <div class="desc-table">{{ $item->created_at->format('d F Y (H:i A)') }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('lang.updated')</div>
                                    <div class="desc-table">{{ $item->updated_at->format('d F Y (H:i A)') }}</div>
                                </div>
                                <div class="item-table m-0">
                                    <div class="desc-table text-right">
                                        <a href="{{ route('role.permission', ['id' => $item->id]) }}" class="btn btn-warning btn-sm" title="@lang('mod/users.permission.caption')">
                                            <i class="las la-user-shield"></i> @lang('mod/users.permission.caption')
                                        </a>
                                        <button type="button" class="btn btn-primary icon-btn btn-sm modal-edit" title="@lang('lang.edit_attr', [
                                            'attribute' => __('mod/users.role.caption')
                                        ])"
                                            data-toggle="modal"
                                            data-target="#modals-edit"
                                            data-id="{{ $item->id }}"
                                            data-name="{{ $item->name }}">
                                            <i class="las la-pen"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger icon-btn btn-sm swal-delete" title="@lang('lang.delete_attr', [
                                            'attribute' => __('mod/users.role.caption')
                                        ])"
                                            data-id="{{ $item->id }}">
                                            <i class="las la-trash-alt"></i>
                                        </button>
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
                @lang('pagination.showing') : <strong>{{ $data['roles']->firstItem() }}</strong> - <strong>{{ $data['roles']->lastItem() }}</strong> @lang('pagination.of')
                <strong>{{ $data['roles']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['roles']->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>

@include('backend.users.ACL.roles.modal-create')
@include('backend.users.ACL.roles.modal-edit')
@endsection

@section('scripts')
<script src="{{ asset('assets/backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script>
    //modals edit
    $('.modal-edit').click(function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var url = '/admin/acl/role/' + id;

        $(".modal-dialog #form-edit").attr('action', url);
        $('.modal-body #name').val(name);
    });
    //delete
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
                        url: '/admin/acl/role/' + id,
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
                        text: "@lang('alert.delete_success', ['attribute' => __('mod/users.role.caption')])"
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

@include('components.toastr-error')
@endsection
