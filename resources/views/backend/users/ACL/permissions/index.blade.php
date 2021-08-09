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

<div class="text-left">
    <button type="button" class="btn btn-success rounded-pill modal-create" 
        data-toggle="modal" 
        data-target="#modals-create" 
        data-parent-name="not_child" 
        data-parent="0" title="@lang('lang.add_attr_new', [
            'attribute' => __('mod/users.permission.caption')
        ])">
        <i class="las la-plus"></i> <span>@lang('mod/users.permission.caption')</span>
    </button>
</div>
<br>

<div id="accordion2">
    @foreach ($data['permissions'] as $item)    
    <div class="card mb-2">
      <div class="card-header">
        <a class="collapsed d-flex justify-content-between text-body" data-toggle="collapse" href="#permission-{{ $item->id }}">
          <strong>{{ $data['no']++.'. '.Str::replace('_', ' ', Str::upper($item->name)) }}</strong> 
          <div class="collapse-icon"></div>
        </a>
      </div>
      <div id="permission-{{ $item->id }}" class="collapse" data-parent="#accordion2">
        <div class="table-responsive">
            <table id="user-list" class="table card-table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>@lang('mod/users.permission.label.field2')</th>
                        <th>@lang('mod/users.permission.label.field3')</th>
                        <th style="width: 215px;">@lang('lang.created')</th>
                        <th style="width: 215px;">@lang('lang.updated')</th>
                        <th class="text-center" style="width: 140px;">@lang('lang.action')</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>{{ $item->name }}</code></td>
                        <td>{{ $item->guard_name }}</td>
                        <td>{{ $item->created_at->format('d F Y (H:i A)') }}</td>
                        <td>{{ $item->updated_at->format('d F Y (H:i A)') }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-success icon-btn btn-sm modal-create" title="@lang('lang.add_attr', [
                                'attribute' => __('mod/users.permission.caption')
                            ])"
                                data-toggle="modal"
                                data-target="#modals-create"
                                data-parent-name="{{ $item->name }}"
                                data-parent="{{ $item->id }}">
                                <i class="las la-plus"></i>
                            </button>
                            <button type="button" class="btn btn-primary icon-btn btn-sm modal-edit" title="@lang('lang.edit_attr', [
                                'attribute' => __('mod/users.permission.caption')
                            ])"
                                data-toggle="modal"
                                data-target="#modals-edit"
                                data-id="{{ $item->id }}"
                                data-name="{{ $item->name }}">
                                <i class="las la-pen"></i>
                            </button>
                            <button type="button" class="btn btn-danger icon-btn btn-sm swal-delete" title="@lang('lang.delete_attr', [
                                'attribute' => __('mod/users.permission.caption')
                            ])"
                                data-id="{{ $item->id }}">
                                <i class="las la-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
      </div>
    </div>
        @foreach ($item->where('parent', $item->id)->get() as $child)
        @php
            $parentName = substr_replace($item->name, '', -1);
            $childName = Str::replace($parentName.'_', '', $child->name)
        @endphp
        <div class="card mb-2 ml-4">
            <div class="card-header">
            <a class="collapsed d-flex justify-content-between text-body" data-toggle="collapse" href="#permission-{{ $child->id }}">
                <em><i class="las la-minus"></i> {{ Str::replace('_', ' ', Str::upper($childName)) }}</em> 
                <div class="collapse-icon"></div>
            </a>
            </div>
            <div id="permission-{{ $child->id }}" class="collapse" data-parent="#accordion2">
            <div class="table-responsive">
                <table id="user-list" class="table card-table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>@lang('mod/users.permission.label.field2')</th>
                            <th>@lang('mod/users.permission.label.field3')</th>
                            <th style="width: 215px;">@lang('lang.created')</th>
                            <th style="width: 215px;">@lang('lang.updated')</th>
                            <th class="text-center" style="width: 140px;">@lang('lang.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>{{ $child->name }}</code></td>
                            <td>{{ $child->guard_name }}</td>
                            <td>{{ $child->created_at->format('d F Y (H:i A)') }}</td>
                            <td>{{ $child->updated_at->format('d F Y (H:i A)') }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary icon-btn btn-sm modal-edit" title="@lang('lang.edit_attr', [
                                    'attribute' => __('mod/users.permission.caption')
                                ])"
                                    data-toggle="modal"
                                    data-target="#modals-edit"
                                    data-id="{{ $child->id }}"
                                    data-name="{{ $child->name }}">
                                    <i class="las la-pen"></i>
                                </button>
                                <button type="button" class="btn btn-danger icon-btn btn-sm swal-delete" title="@lang('lang.delete_attr', [
                                    'attribute' => __('mod/users.permission.caption')
                                ])"
                                    data-id="{{ $child->id }}">
                                    <i class="las la-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
        @endforeach
    @endforeach
</div>

@if ($data['permissions']->total() == 0)
<div class="card">
    <div class="card-body text-center">
        <strong style="color: red;">
            @if (count(Request::query()) > 0)
            ! @lang('lang.data_attr_not_found', [
                'attribute' => __('mod/users.permission.caption')
            ]) !
            @else
            ! @lang('lang.data_attr_empty', [
                'attribute' => __('mod/users.permission.caption')
            ]) !
            @endif
        </strong>
    </div>
</div>
@endif

@if ($data['permissions']->total() > 0)
<div class="card">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                @lang('pagination.showing') : <strong>{{ $data['permissions']->firstItem() }}</strong> - <strong>{{ $data['permissions']->lastItem() }}</strong> @lang('pagination.of')
                <strong>{{ $data['permissions']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['permissions']->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>
@endif

@include('backend.users.ACL.permissions.modal-create')
@include('backend.users.ACL.permissions.modal-edit')
@endsection

@section('scripts')
<script src="{{ asset('assets/backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script>
    //modals create
    $('.modal-create').click(function() {
        var parent_name = $(this).data('parent-name');
        var parent = $(this).data('parent');

        $('.modal-body #show-parent').hide();
        if (parseInt(parent) != 0) {
            $('.modal-body #show-parent').show();
        }

        $('.modal-body #parent-name').val(parent_name);
        $('.modal-body #parent').val(parent);
    });
    //modals edit
    $('.modal-edit').click(function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var url = '/admin/acl/permission/' + id;

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
                        url: '/admin/acl/permission/' + id,
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
                        text: "@lang('alert.delete_success', ['attribute' => __('mod/users.permission.caption')])"
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
