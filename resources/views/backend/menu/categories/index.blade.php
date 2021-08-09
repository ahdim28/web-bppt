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

<div class="card">
    <div class="card-header with-elements">
        <h5 class="card-header-title mt-1 mb-0">@lang('mod/menu.category.text')</h5>
        <div class="card-header-elements ml-auto">
            @can ('menu_category_create')
            <button type="button" class="btn btn-success icon-btn-only-sm modal-create" 
                data-toggle="modal" 
                data-target="#modals-create" title="@lang('lang.add_attr_new', [
                    'attribute' => __('mod/menu.category.caption')
                ])">
                <i class="las la-plus"></i> <span>@lang('mod/menu.category.title')</span>
            </button>
            @endcan
        </div>
    </div>
    <div class="table-responsive table-mobile-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th style="width: 10px;">ID</th>
                    <th>@lang('mod/menu.category.label.field1')</th>
                    <th class="text-center" style="width: 100px;">@lang('mod/menu.title')</th>
                    <th style="width: 215px;">@lang('lang.created')</th>
                    <th style="width: 215px;">@lang('lang.updated')</th>
                    <th class="text-center" style="width: 240px;">@lang('lang.action')</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['categories']->total() == 0)
                    <tr>
                        <td colspan="7" align="center">
                            <i>
                                <strong style="color:red;">
                                @if (count(Request::query()) > 0)
                                ! @lang('lang.data_attr_not_found', [
                                    'attribute' => __('mod/menu.category.title')
                                ]) !
                                @else
                                ! @lang('lang.data_attr_empty', [
                                    'attribute' => __('mod/menu.category.title')
                                ]) !
                                @endif
                                </strong>
                            </i>
                        </td>
                    </tr>
                @endif
                @foreach ($data['categories'] as $item)
                <tr>
                    <td>{{ $data['no']++ }}</td>
                    <td>#{{ $item->id }}</td>
                    <td><strong>{!! Str::limit($item->name, 50) !!}</strong></td>
                    <td class="text-center">
                        @lang('lang.total') : <span class="badge badge-success">{{ $item->menu->count() }}</span>
                    </td>
                    <td>
                        <span class="text-muted">@lang('lang.by') {{ $item->createBy->name }}</span><br>
                        {{ $item->created_at->format('d F Y (H:i A)') }}
                    </td>
                    <td>
                        <span class="text-muted">@lang('lang.by') {{  $item->updateBy->name }}</span><br>
                        {{ $item->updated_at->format('d F Y (H:i A)') }}
                    </td>
                    <td class="text-center">
                        @can('menus')
                        <a href="{{ route('menu.index', ['categoryId' => $item->id]) }}" class="btn btn-sm btn-warning" title="@lang('mod/menu.title')">
                            <i class="las la-list"></i> @lang('mod/menu.title')
                        </a>
                        @endcan
                        @can('menu_category_update')
                        <button type="button" class="btn btn-primary icon-btn btn-sm modal-edit" title="@lang('lang.edit_attr', [
                            'attribute' => __('mod/menu.category.caption')
                        ])"
                            data-toggle="modal"
                            data-target="#modals-edit"
                            data-id="{{ $item->id }}"
                            data-name="{{ $item->name }}">
                            <i class="las la-pen"></i>
                        </button>
                        @endcan
                        @can('menu_category_delete')
                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="@lang('lang.delete_attr', [
                            'attribute' => __('mod/menu.category.caption')
                        ])">
                            <i class="las la-trash"></i>
                        </a>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['categories']->total() == 0)
                    <tr>
                        <td colspan="7" align="center">
                            <i>
                                <strong style="color:red;">
                                @if (count(Request::query()) > 0)
                                ! @lang('lang.data_attr_not_found', [
                                    'attribute' => __('mod/menu.category.title')
                                ]) !
                                @else
                                ! @lang('lang.data_attr_empty', [
                                    'attribute' => __('mod/menu.category.title')
                                ]) !
                                @endif
                                </strong>
                            </i>
                        </td>
                    </tr>
                @endif
                @foreach ($data['categories'] as $item)
                <tr>
                    <td>
                        <div class="card">
                            <div class="card-body">
                                <div class="item-table">
                                    <div class="data-table">ID</div>
                                    <div class="desc-table">
                                        <strong>#{{ $item->id }}</strong>
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('mod/menu.category.label.field1')</div>
                                    <div class="desc-table">
                                        <strong>{!! Str::limit($item->name, 50) !!}</strong>
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('mod/menu.title')</div>
                                    <div class="desc-table">
                                        @lang('lang.total') : <span class="badge badge-success">{{ $item->menu->count() }}</span><br>
                                    </div>
                                </div>
                                <div class="item-table m-0">
                                    <div class="desc-table text-right">
                                        @can('menus')
                                        <a href="{{ route('menu.index', ['categoryId' => $item->id]) }}" class="btn btn-sm btn-warning" title="@lang('mod/menu.title')">
                                            <i class="las la-list"></i> @lang('mod/menu.title')
                                        </a>
                                        @endcan
                                        @can('menu_category_update')
                                        <button type="button" class="btn btn-primary icon-btn btn-sm modal-edit" title="@lang('lang.edit_attr', [
                                            'attribute' => __('mod/menu.category.caption')
                                        ])"
                                            data-toggle="modal"
                                            data-target="#modals-edit"
                                            data-id="{{ $item->id }}"
                                            data-name="{{ $item->name }}">
                                            <i class="las la-pen"></i>
                                        </button>
                                        @endcan
                                        @can('menu_category_delete')
                                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="@lang('lang.delete_attr', [
                                            'attribute' => __('mod/menu.category.caption')
                                        ])">
                                            <i class="las la-trash"></i>
                                        </a>
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
                @lang('pagination.showing') : <strong>{{ $data['categories']->firstItem() }}</strong> - <strong>{{ $data['categories']->lastItem() }}</strong>  @lang('pagination.of')
                <strong>{{ $data['categories']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['categories']->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>

@can('menu_category_create')
@include('backend.menu.categories.modal-create')
@endcan
@can('menu_category_update')
@include('backend.menu.categories.modal-edit')
@endcan

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
        var url = '/admin/management/menu/category/' + id;

        $(".modal-dialog #form-edit").attr('action', url);
        $('.modal-body #name').val(name);
    });
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
                        url: '/admin/menu/category/' + id,
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
                        text: "@lang('alert.delete_success', ['attribute' => __('mod/menu.category.title')])"
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