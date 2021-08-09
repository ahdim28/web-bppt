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
                        <label class="form-label">Search</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="Keywords...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-dark" title="search"><i class="las la-filter"></i></button>
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
        <h5 class="card-header-title mt-1 mb-0">Inquiry List</h5>
        <div class="card-header-elements ml-auto">
            @can ('inquiry_create')
            <a href="{{ route('inquiry.create') }}" class="btn btn-success icon-btn-only-sm" title="Add New Inquiry">
                <i class="las la-plus"></i> <span>Inquiry</span>
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
                    <th class="text-center" style="width: 160px;">Message</th>
                    <th class="text-center" style="width: 80px;">Viewer</th>
                    <th class="text-center" style="width: 100px;">Status</th>
                    <th style="width: 230px;">Created</th>
                    <th style="width: 230px;">Updated</th>
                    <th class="text-center" style="width: 110px;">Position</th>
                    <th class="text-center" style="width: 140px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['inquiries']->total() == 0)
                    <tr>
                        <td colspan="9" align="center">
                            <i>
                                <strong style="color:red;">
                                @if (count(Request::query()) > 0)
                                ! Inquiry not found :( !
                                @else
                                ! Inquiry is empty !
                                @endif
                                </strong>
                            </i>
                        </td>
                    </tr>
                @endif
                @foreach ($data['inquiries'] as $item)
                <tr>
                    <td>{{ $data['no']++ }}</td>
                    <td><strong>{!! Str::limit($item->fieldLang('name'), 50) !!}</strong></td>
                    <td class="text-center">
                        @can ('inquiry_detail')
                        @if ($item->forms->where('status', 0)->count() > 0)
                        UN-READ : <span class="badge badge-danger">{{ $item->forms->where('status', 0)->count() }}</span>
                        @endif
                        <a href="{{ route('inquiry.detail', ['id' => $item->id]) }}" class="btn btn-sm btn-warning" title="list detail">
                            <i class="las la-list"></i> DETAIL
                        </a>
                        @endcan
                    </td>
                    <td class="text-center"><span class="badge badge-info">{{ $item->viewer }}</span></td>
                    <td class="text-center">
                        @can ('inquiry_update')
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="badge badge-{{ $item->customConfig()['publish']['color'] }}"
                            title="Click to change status inquiry">
                            {{ __($item->customConfig()['publish']['title']) }}
                            <form action="{{ route('inquiry.publish', ['id' => $item->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <span class="badge badge-{{ $item->customConfig()['publish']['color'] }}">{{ __($item->customConfig()['publish']['title']) }}</span>
                        @endcan
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
                        @if (auth()->user()->can('inquiry_update') && $item->min('position') != $item->position)
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="Click to up position">
                            <i class="las la-arrow-up"></i>
                            <form action="{{ route('inquiry.position', ['id' => $item->id, 'position' => ($item->position - 1)]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-up"></i></button>
                        @endif
                        @if (auth()->user()->can('inquiry_update') && $item->max('position') != $item->position)
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="Click to down position">
                            <i class="las la-arrow-down"></i>
                            <form action="{{ route('inquiry.position', ['id' => $item->id, 'position' => ($item->position + 1)]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-down"></i></button>
                        @endif
                    </td>
                    <td class="text-center">
                        @can ('inquiry_field')
                        <a href="{{ route('inquiry.field.index', ['inquiryId' => $item->id]) }}" class="btn btn-sm btn-warning" title="fields form">
                            <i class="las la-edit"></i> FIELDS
                        </a>
                        @endcan
                        <a href="{{ route('inquiry.read.'.$item->slug) }}" class="btn icon-btn btn-sm btn-info" title="view inquiry" target="_blank">
                            <i class="las la-external-link-alt"></i>
                        </a>
                        @can('inquiry_update')
                        <a href="{{ route('inquiry.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="edit inquiry">
                            <i class="las la-pen"></i>
                        </a>
                        @endcan
                        @can('inquiry_delete')
                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="delete inquiry">
                            <i class="las la-trash"></i>
                        </a>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['inquiries']->total() == 0)
                    <tr>
                        <td colspan="9" align="center">
                            <i>
                                <strong style="color:red;">
                                @if (count(Request::query()) > 0)
                                ! Inquiry not found :( !
                                @else
                                ! Inquiry is empty !
                                @endif
                                </strong>
                            </i>
                        </td>
                    </tr>
                @endif
                @foreach ($data['inquiries'] as $item)
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
                                    <div class="data-table">Message</div>
                                    <div class="desc-table">
                                        @can ('inquiry_detail')
                                        @if ($item->forms->where('status', 0)->count() > 0)
                                        UN-READ : <span class="badge badge-danger">{{ $item->forms->where('status', 0)->count() }}</span>
                                        @endif
                                        <a href="{{ route('inquiry.detail', ['id' => $item->id]) }}" class="btn btn-sm btn-warning" title="list detail">
                                            <i class="las la-list"></i> DETAIL
                                        </a>
                                        @endcan
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Viewer</div>
                                    <div class="desc-table">
                                        <span class="badge badge-info">{{ $item->viewer }}</span>
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Status</div>
                                    <div class="desc-table">
                                        @can ('inquiry_update')
                                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="badge badge-{{ $item->customConfig()['publish']['color'] }}"
                                            title="Click to change status inquiry">
                                            {{ __($item->customConfig()['publish']['title']) }}
                                            <form action="{{ route('inquiry.publish', ['id' => $item->id]) }}" method="POST">
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
                                        @if (auth()->user()->can('inquiry_update') && $item->min('position') != $item->position)
                                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="Click to up position">
                                            <i class="las la-arrow-up"></i>
                                            <form action="{{ route('inquiry.position', ['id' => $item->id, 'position' => ($item->position - 1)]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                        </a>
                                        @else
                                        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-up"></i></button>
                                        @endif
                                        @if (auth()->user()->can('inquiry_update') && $item->max('position') != $item->position)
                                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="Click to down position">
                                            <i class="las la-arrow-down"></i>
                                            <form action="{{ route('inquiry.position', ['id' => $item->id, 'position' => ($item->position + 1)]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                        </a>
                                        @else
                                        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-down"></i></button>
                                        @endif
                                        @can ('inquiry_field')
                                        <a href="{{ route('inquiry.field.index', ['inquiryId' => $item->id]) }}" class="btn btn-sm btn-warning" title="fields form">
                                            <i class="las la-edit"></i> FIELDS
                                        </a>
                                        @endcan
                                        <a href="{{ route('inquiry.read.'.$item->slug) }}" class="btn icon-btn btn-sm btn-info" title="view inquiry" target="_blank">
                                            <i class="las la-external-link-alt"></i>
                                        </a>
                                        @can('inquiry_update')
                                        <a href="{{ route('inquiry.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="edit inquiry">
                                            <i class="las la-pen"></i>
                                        </a>
                                        @endcan
                                        @can('inquiry_delete')
                                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="delete inquiry">
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
                Showing : <strong>{{ $data['inquiries']->firstItem() }}</strong> - <strong>{{ $data['inquiries']->lastItem() }}</strong> of
                <strong>{{ $data['inquiries']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['inquiries']->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script src="{{ asset('assets/backend/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/backend/js/pages_gallery.js') }}"></script>
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
                        url: '/admin/inquiry/' + id,
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
                        text: 'inquiry successfully deleted'
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