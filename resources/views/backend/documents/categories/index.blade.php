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
                    <label class="form-label">Status</label>
                    <select class="status custom-select" name="s">
                        <option value=" " selected>Any</option>
                        @foreach (config('custom.label.publish') as $key => $val)
                        <option value="{{ $key }}" {{ Request::get('s') == ''.$key.'' ? 'selected' : '' }} title="Filter by {{ __($val['title']) }}">{{ __($val['title']) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md">
                <div class="form-group">
                    <label class="form-label">@lang('lang.public')</label>
                    <select class="status custom-select" name="p">
                        <option value=" " selected>@lang('lang.any')</option>
                        @foreach (config('custom.label.optional') as $key => $val)
                        <option value="{{ $key }}" {{ Request::get('p') == ''.$key.'' ? 'selected' : '' }} title="{{ __($val['title']) }}">{{ __($val['title']) }}</option>
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
        <h5 class="card-header-title mt-1 mb-0">Document Category List</h5>
        <div class="card-header-elements ml-auto">
            @can ('document_category_create')
            <a href="{{ route('document.category.create') }}" class="btn btn-success icon-btn-only-sm" title="Add New Category">
                <i class="las la-plus"></i> <span>Category</span>
            </a>
            @endcan
        </div>
    </div>
    <div class="table-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>Name</th>
                    <th class="text-center" style="width: 80px;">@lang('lang.viewer')</th>
                    {{-- <th class="text-center" style="width: 120px;">Document</th> --}}
                    <th class="text-center" style="width: 100px;">Status</th>
                    <th class="text-center" style="width: 80px;">@lang('lang.public')</th>
                    <th style="width: 230px;">@lang('lang.created')</th>
                    <th style="width: 230px;">@lang('lang.updated')</th>
                    <th class="text-center" style="width: 110px;">@lang('lang.position')</th>
                    <th class="text-center" style="width: 180px;">@lang('lang.action')</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['categories']->total() == 0)
                    <tr>
                        <td colspan="10" align="center">
                            <i>
                                <strong style="color:red;">
                                    @if (count(Request::query()) > 0)
                                    ! @lang('lang.data_attr_not_found', [
                                        'attribute' => 'Category'
                                    ]) !
                                    @else
                                    ! @lang('lang.data_attr_empty', [
                                        'attribute' => 'Category'
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
                    <td><strong>{!! Str::limit($item->fieldLang('name'), 50) !!}</strong></td>
                    <td class="text-center"><span class="badge badge-info">{{ $item->viewer }}</span></td>
                    {{-- <td class="text-center">
                        <span class="badge badge-primary">{{ $item->documents->count() }}</span>
                    </td> --}}
                    <td class="text-center">
                        @can ('document_category_update')
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="badge badge-{{ $item->customConfig()['publish']['color'] }}"
                            title="Status">
                            {{ __($item->customConfig()['publish']['title']) }}
                            <form action="{{ route('document.category.publish', ['id' => $item->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <span class="badge badge-{{ $item->customConfig()['publish']['color'] }}">{{ __($item->customConfig()['publish']['title']) }}</span>
                        @endcan
                    </td>
                    <td class="text-center">
                        <span class="badge badge-{{ $item->customConfig()['public']['color'] }}">{{ __($item->customConfig()['public']['title']) }}</span>
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
                        @if (auth()->user()->can('document_category_update') && $item->min('position') != $item->position)
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="@lang('lang.position') Up">
                            <i class="las la-arrow-up"></i>
                            <form action="{{ route('document.category.position', ['id' => $item->id, 'position' => ($item->position - 1)]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-up"></i></button>
                        @endif
                        @if (auth()->user()->can('document_category_update') && $item->max('position') != $item->position)
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="@lang('lang.position') Down">
                            <i class="las la-arrow-down"></i>
                            <form action="{{ route('document.category.position', ['id' => $item->id, 'position' => ($item->position + 1)]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-down"></i></button>
                        @endif
                    </td>
                    <td class="text-center">
                        @can ('documents')
                        <a href="{{ route('document.index', ['categoryId' => $item->id]) }}" class="btn btn-sm btn-warning" title="View Document">
                            <i class="las la-file"></i> DOCUMENT
                        </a>
                        @endcan
                        <a href="{{ route('document.category.read', ['slugCategory' => $item->slug]) }}" class="btn icon-btn btn-sm btn-info" title="View Detail" target="_blank">
                            <i class="las la-external-link-alt"></i>
                        </a>
                        @can ('document_category_create')
                        <a href="{{ route('document.category.create', ['parent' => $item->id]) }}" class="btn icon-btn btn-sm btn-success" title="Add New Child Category">
                            <i class="las la-plus"></i>
                        </a>
                        @endcan
                        @can('document_category_update')
                        <a href="{{ route('document.category.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="Edit Category">
                            <i class="las la-pen"></i>
                        </a>
                        @endcan
                        @can('document_category_delete')
                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="Delete Category">
                            <i class="las la-trash"></i>
                        </a>
                        @endcan
                    </td>
                </tr>
                @if (count($item->childs))
                    @include('backend.documents.categories.child', ['childs' => $item->childs, 'level' => 1])
                @endif
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
                        url: '/admin/document/category/'+ id,
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
                        text: 'category successfully deleted'
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