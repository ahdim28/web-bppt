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
        <h5 class="card-header-title mt-1 mb-0">Catalog Type List</h5>
        <div class="card-header-elements ml-auto">
            @can ('catalog_type_create')
            <a href="{{ route('catalog.type.create') }}" class="btn btn-success icon-btn-only-sm" title="Add New Type">
                <i class="las la-plus"></i> <span>Type</span>
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
                    <th style="width: 230px;">Created</th>
                    <th style="width: 230px;">Updated</th>
                    <th class="text-center" style="width: 110px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['types']->total() == 0)
                    <tr>
                        <td colspan="6" align="center">
                            <i>
                                <strong style="color:red;">
                                @if (count(Request::query()) > 0)
                                ! Catalog Type not found :( !
                                @else
                                ! Catalog Type is empty !
                                @endif
                                </strong>
                            </i>
                        </td>
                    </tr>
                @endif
                @foreach ($data['types'] as $item)
                <tr>
                    <td>{{ $data['no']++ }}</td>
                    <td><strong>{!! Str::limit($item->fieldLang('name'), 50) !!}</strong></td>
                    <td>[{!! !empty($item->fieldLang('description')) ? Str::limit(strip_tags($item->fieldLang('description')), 60) : __('lang.no', [
                        'attribute' => 'Description'
                    ]) !!}]</td>
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
                        @can('catalog_type_update')
                        <a href="{{ route('catalog.type.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="Edit Type">
                            <i class="las la-pen"></i>
                        </a>
                        @endcan
                        @can('catalog_type_delete')
                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="Delete Type">
                            <i class="las la-trash"></i>
                        </a>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['types']->total() == 0)
                    <tr>
                        <td colspan="6" align="center">
                            <i>
                                <strong style="color:red;">
                                @if (count(Request::query()) > 0)
                                ! Catalog Type not found :( !
                                @else
                                ! Catalog Type is empty !
                                @endif
                                </strong>
                            </i>
                        </td>
                    </tr>
                @endif
                @foreach ($data['types'] as $item)
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
                                        [{!! !empty($item->fieldLang('description')) ? Str::limit(strip_tags($item->fieldLang('description')), 60) : __('lang.no', [
                                            'attribute' => 'Description'
                                        ]) !!}]
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
                                        @can('catalog_type_update')
                                        <a href="{{ route('catalog.type.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="Edit Type">
                                            <i class="las la-pen"></i>
                                        </a>
                                        @endcan
                                        @can('catalog_type_delete')
                                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="Delete Type">
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
                Showing : <strong>{{ $data['types']->firstItem() }}</strong> - <strong>{{ $data['types']->lastItem() }}</strong> of
                <strong>{{ $data['types']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['types']->onEachSide(1)->links() }}
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
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                confirmButtonText: "Yes, delete!",
                customClass: {
                    confirmButton: "btn btn-danger btn-lg",
                    cancelButton: "btn btn-primary btn-lg"
                },
                showLoaderOnConfirm: true,
                showCancelButton: true,
                allowOutsideClick: () => !Swal.isLoading(),
                cancelButtonText: "No, thanks",
                preConfirm: () => {
                    return $.ajax({
                        url: '/admin/catalog/type/' + id,
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
                        text: 'catalog type successfully deleted'
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
