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
                        <label class="form-label">Limit</label>
                        <select class="limit custom-select" name="l">
                            <option value="20" selected>Any</option>
                            @foreach (config('custom.filtering.limit') as $key => $val)
                            <option value="{{ $key }}" {{ Request::get('l') == ''.$key.'' ? 'selected' : '' }} title="Limit {{ $val }}">{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            <div class="col-md">
                    <div class="form-group">
                        <label class="form-label">Search</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="Keywords...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-dark" title="Search"><i class="las la-filter"></i></button>
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
        <h5 class="card-header-title mt-1 mb-0">Banner Category List</h5>
        <div class="card-header-elements ml-auto">
            @can ('banner_category_create')
            <a href="{{ route('banner.category.create') }}" class="btn btn-success icon-btn-only-sm" title="Add New Banner Category">
                <i class="las la-plus"></i> <span>Banner Category</span>
            </a>
            @endcan
        </div>
    </div>
    <div class="table-responsive table-mobile-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th class="text-center" style="width: 100px;">Banner</th>
                    <th class="text-center" style="width: 80px;">Limit</th>
                    <th style="width: 230px;">Created</th>
                    <th style="width: 230px;">Updated</th>
                    <th class="text-center" style="width: 210px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['categories']->total() == 0)
                    <tr>
                        <td colspan="8" align="center">
                            <i>
                                <strong style="color:red;">
                                @if (count(Request::query()) > 0)
                                ! Banner Category not found :( !
                                @else
                                ! Banner Category is empty !
                                @endif
                                </strong>
                            </i>
                        </td>
                    </tr>
                @endif
                @foreach ($data['categories'] as $item)
                <tr>
                    <td>{{ $data['no']++ }}</td>
                    <td><strong>{!! Str::limit($item->fieldLang('name'), 50) !!}</strong></td>
                    <td>
                        {!! !empty($item->fieldLang('description')) ? Str::limit(strip_tags($item->fieldLang('description')), 60) : __('lang.no', [
                            'attribute' => 'Description'
                        ]) !!}
                    </td>
                    <td class="text-center">
                        Total : <span class="badge badge-success">{{ $item->banners->count() }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-success">
                            {{ $item->banner_limit ?? 'Default Config' }}
                        </span>
                    </td>
                    <td>
                        {{ $item->created_at->format('d F Y (H:i A)') }}
                        @if (!empty($item->created_by))
                        <br>
                            <span class="text-muted">@lang('lang.by') : {{ $item->createBy->name }}</span>
                        @endif
                    </td>
                    <td>
                        {{ $item->updated_at->format('d F Y (H:i A)') }}
                        @if (!empty($item->updated_by))
                        <br>
                            <span class="text-muted">@lang('lang.by') : {{ $item->updateBy->name }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @can('banners')
                        <a href="{{ route('banner.index', ['categoryId' => $item->id]) }}" class="btn btn-sm btn-warning" title="banner list">
                            <i class="las la-image"></i> Banners
                        </a>
                        @endcan
                        @can('banner_category_update')
                        <a href="{{ route('banner.category.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="Edit Banner Category">
                            <i class="las la-pen"></i>
                        </a>
                        @endcan
                        @can('banner_category_delete')
                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="Delete Banner Category">
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
                        <td colspan="8" align="center">
                            <i>
                                <strong style="color:red;">
                                @if (count(Request::query()) > 0)
                                ! Banner Category not found :( !
                                @else
                                ! Banner Category is empty !
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
                                    <div class="data-table">Name</div>
                                    <div class="desc-table">
                                        <strong>{!! Str::limit($item->fieldLang('name'), 50) !!}</strong>
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Description</div>
                                    <div class="desc-table">
                                        {!! !empty($item->fieldLang('description')) ? Str::limit(strip_tags($item->fieldLang('description')), 60) : __('lang.no', [
                                            'attribute' => 'Description'
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Banner</div>
                                    <div class="desc-table">
                                        Total : <span class="badge badge-success">{{ $item->banners->count() }}</span>
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Limit</div>
                                    <div class="desc-table">
                                        <span class="badge badge-success">
                                            {{ $item->banner_limit ?? 'Default Config' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('lang.created')</div>
                                    <div class="desc-table">
                                        {{ $item->created_at->format('d F Y (H:i A)') }}
                                        @if (!empty($item->created_by))
                                        <br>
                                        <span class="text-muted">@lang('lang.by') : {{ $item->createBy->name }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('lang.updated')</div>
                                    <div class="desc-table">
                                        {{ $item->updated_at->format('d F Y (H:i A)') }}
                                        @if (!empty($item->updated_by))
                                        <br>
                                        <span class="text-muted">@lang('lang.by') : {{ $item->updateBy->name }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="item-table m-0">
                                    <div class="desc-table text-right">
                                        @can('banners')
                                        <a href="{{ route('banner.index', ['categoryId' => $item->id]) }}" class="btn btn-sm btn-warning" title="banner list">
                                            <i class="las la-image"></i> Banners
                                        </a>
                                        @endcan
                                        @can('banner_category_update')
                                        <a href="{{ route('banner.category.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="Edit Banner Category">
                                            <i class="las la-pen"></i>
                                        </a>
                                        @endcan
                                        @can('banner_category_delete')
                                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="Delete Banner Category">
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
                Showing : <strong>{{ $data['categories']->firstItem() }}</strong> - <strong>{{ $data['categories']->lastItem() }}</strong> of
                <strong>{{ $data['categories']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['categories']->onEachSide(1)->links() }}
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
                        url: '/admin/banner/category/' + id,
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
                        text: 'banner category successfully deleted'
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
