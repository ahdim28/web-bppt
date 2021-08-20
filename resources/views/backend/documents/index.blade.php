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
                    <label class="form-label">Public</label>
                    <select class="status custom-select" name="p">
                        <option value=" " selected>Any</option>
                        @foreach (config('custom.label.optional') as $key => $val)
                        <option value="{{ $key }}" {{ Request::get('p') == ''.$key.'' ? 'selected' : '' }} title="Filter by {{ __($val['title']) }}">{{ __($val['title']) }}</option>
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
        <h5 class="card-header-title mt-1 mb-0">Document List</h5>
        <div class="card-header-elements ml-auto">
            @can ('document_create')
            <a href="{{ route('document.create', ['categoryId' => $data['category']->id]) }}" class="btn btn-success icon-btn-only-sm" title="Add New Document">
                <i class="las la-plus"></i> <span>Document</span>
            </a>
            @endcan
        </div>
    </div>
    <div class="table-responsive table-mobile-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>Title</th>
                    <th class="text-center" style="width: 80px;">Viewer</th>
                    <th class="text-center" style="width: 80px;">Download</th>
                    <th class="text-center" style="width: 100px;">Status</th>
                    <th class="text-center" style="width: 80px;">Public</th>
                    <th style="width: 230px;">Created</th>
                    <th style="width: 230px;">Updated</th>
                    <th class="text-center" style="width: 110px;">Position</th>
                    <th class="text-center" style="width: 180px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['documents']->total() == 0)
                    <tr>
                        <td colspan="10" align="center">
                            <i>
                                <strong style="color:red;">
                                @if (count(Request::query()) > 0)
                                ! Document not found :( !
                                @else
                                ! Document is empty !
                                @endif
                                </strong>
                            </i>
                        </td>
                    </tr>
                @endif
                @foreach ($data['documents'] as $item)
                <tr>
                    <td>{{ $data['no']++ }}</td>
                    <td><strong>{!! Str::limit($item->fieldLang('title'), 50) !!}</strong></td>
                    <td class="text-center"><span class="badge badge-info">{{ $item->viewer }}</span></td>
                    <td class="text-center"><span class="badge badge-success">{{ $item->download }}</span></td>
                    <td class="text-center">
                        @can ('document_update')
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="badge badge-{{ $item->customConfig()['publish']['color'] }}"
                            title="Status">
                            {{ __($item->customConfig()['publish']['title']) }}
                            <form action="{{ route('document.publish', ['categoryId' => $item->category_id, 'id' => $item->id]) }}" method="POST">
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
                        @if (auth()->user()->can('document_update') && $item->where('category_id', $item->category_id)->min('position') != $item->position)
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="Position Up">
                            <i class="las la-arrow-up"></i>
                            <form action="{{ route('document.position', ['categoryId' => $item->category_id, 'id' => $item->id, 'position' => ($item->position - 1)]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-up"></i></button>
                        @endif
                        @if (auth()->user()->can('document_update') && $item->where('category_id', $item->category_id)->max('position') != $item->position)
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="Position Down">
                            <i class="las la-arrow-down"></i>
                            <form action="{{ route('document.position', ['categoryId' => $item->category_id, 'id' => $item->id, 'position' => ($item->position + 1)]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-down"></i></button>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('document.read', ['slugCategory' => $item->category->slug, 'slugDocument' => $item->slug]) }}" class="btn icon-btn btn-sm btn-info" title="View Detail" target="_blank">
                            <i class="las la-external-link-alt"></i>
                        </a>
                        @can('document_update')
                        <a href="{{ route('document.edit', ['categoryId' => $item->category_id, 'id' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="Edit Document">
                            <i class="las la-pen"></i>
                        </a>
                        @endcan
                        @can('document_delete')
                        <a href="javascript:;" data-categoryid="{{ $item->category_id }}" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="Delete Document">
                            <i class="las la-trash"></i>
                        </a>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['documents']->total() == 0)
                    <tr>
                        <td colspan="10" align="center">
                            <i>
                                <strong style="color:red;">
                                @if (count(Request::query()) > 0)
                                ! Document not found :( !
                                @else
                                ! Document is empty !
                                @endif
                                </strong>
                            </i>
                        </td>
                    </tr>
                @endif
                @foreach ($data['documents'] as $item)
                <tr>
                    <td>
                        <div class="card">
                            <div class="card-body">
                                <div class="item-table">
                                    <div class="data-table">Title</div>
                                    <div class="desc-table">
                                        <strong>{!! Str::limit($item->fieldLang('title'), 50) !!}</strong>
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Viewer</div>
                                    <div class="desc-table">
                                        <span class="badge badge-info">{{ $item->viewer }}</span>
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Download</div>
                                    <div class="desc-table">
                                        <span class="badge badge-success">{{ $item->download }}</span>
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Status</div>
                                    <div class="desc-table">
                                        @can ('document_update')
                                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="badge badge-{{ $item->customConfig()['publish']['color'] }}"
                                            title="Status">
                                            {{ __($item->customConfig()['publish']['title']) }}
                                            <form action="{{ route('document.publish', ['categoryId' => $item->category_id, 'id' => $item->id]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                        </a>
                                        @else
                                        <span class="badge badge-{{ $item->customConfig()['publish']['color'] }}">{{ __($item->customConfig()['publish']['title']) }}</span>
                                        @endcan
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Public</div>
                                    <div class="desc-table">
                                        <span class="badge badge-{{ $item->customConfig()['public']['color'] }}">{{ __($item->customConfig()['public']['title']) }}</span>
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
                                        @if (auth()->user()->can('document_update') && $item->where('category_id', $item->category_id)->min('position') != $item->position)
                                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="Position Up">
                                            <i class="las la-arrow-up"></i>
                                            <form action="{{ route('document.position', ['categoryId' => $item->category_id, 'id' => $item->id, 'position' => ($item->position - 1)]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                        </a>
                                        @else
                                        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-up"></i></button>
                                        @endif
                                        @if (auth()->user()->can('document_update') && $item->where('category_id', $item->category_id)->max('position') != $item->position)
                                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="Position Down">
                                            <i class="las la-arrow-down"></i>
                                            <form action="{{ route('document.position', ['categoryId' => $item->category_id, 'id' => $item->id, 'position' => ($item->position + 1)]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                        </a>
                                        @else
                                        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-down"></i></button>
                                        @endif
                                        <a href="{{ route('document.read', ['slugCategory' => $item->category->slug, 'slugDocument' => $item->slug]) }}" class="btn icon-btn btn-sm btn-info" title="View Detail" target="_blank">
                                            <i class="las la-external-link-alt"></i>
                                        </a>
                                        @can('document_update')
                                        <a href="{{ route('document.edit', ['categoryId' => $item->category_id, 'id' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="Edit Document">
                                            <i class="las la-pen"></i>
                                        </a>
                                        @endcan
                                        @can('document_delete')
                                        <a href="javascript:;" data-categoryid="{{ $item->category_id }}" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="Delete Document">
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
                Showing : <strong>{{ $data['documents']->firstItem() }}</strong> - <strong>{{ $data['documents']->lastItem() }}</strong> of
                <strong>{{ $data['documents']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['documents']->onEachSide(1)->links() }}
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
            var category_id = $(this).attr('data-categoryid');
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
                        url: '/admin/document/' + category_id +'/' + id,
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
                        text: 'document successfully deleted'
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