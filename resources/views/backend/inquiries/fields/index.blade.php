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
        <h5 class="card-header-title mt-1 mb-0">Inquiry Field List</h5>
        <div class="card-header-elements ml-auto">
            <a href="{{ route('inquiry.field.create', ['inquiryId' => $data['inquiry']->id]) }}" class="btn btn-success icon-btn-only-sm" title="Add New Field">
                <i class="las la-plus"></i> <span>Field</span>
            </a>
        </div>
    </div>
    <div class="table-responsive table-mobile-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>Label</th>
                    <th>Name</th>
                    <th style="width: 350px;">Properties</th>
                    <th class="text-center" style="width: 100px;">Type</th>
                    <th class="text-center" style="width: 140px;">Validation</th>
                    <th style="width: 230px;">Created</th>
                    <th style="width: 230px;">Updated</th>
                    <th class="text-center" style="width: 110px;">Position</th>
                    <th class="text-center" style="width: 110px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['fields']->count() == 0)
                    <tr>
                        <td colspan="10" align="center">
                            <i>
                                <strong style="color:red;">
                                @if (count(Request::query()) > 0)
                                ! Inquiry Field not found :( !
                                @else
                                ! Inquiry Field is empty !
                                @endif
                                </strong>
                            </i>
                        </td>
                    </tr>
                @endif
                @foreach ($data['fields'] as $key => $item)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td><strong>{{ $item->fieldLang('label') }}</strong></td>
                    <td><code>{{ $item->name }}</code></td>
                    <td><code>{{ json_encode($item->properties) }}</code></td>
                    <td class="text-center"><span class="badge badge-primary">{{ $item->customConfig()['type'] }}</span></td>
                    <td><code>{{ $item->validation }}</code></td>
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
                        @if ($item->where('inquiry_id', $item->inquiry_id)->min('position') != $item->position)
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="Click to up position">
                            <i class="las la-arrow-up"></i>
                            <form action="{{ route('inquiry.field.position', ['inquiryId' => $item->inquiry_id, 'id' => $item->id, 'position' => ($item->position - 1)]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-up"></i></button>
                        @endif
                        @if ($item->where('inquiry_id', $item->inquiry_id)->max('position') != $item->position)
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="Click to down position">
                            <i class="las la-arrow-down"></i>
                            <form action="{{ route('inquiry.field.position', ['inquiryId' => $item->inquiry_id, 'id' => $item->id, 'position' => ($item->position + 1)]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-down"></i></button>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('inquiry.field.edit', ['inquiryId' => $item->inquiry_id, 'id' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="edit field">
                            <i class="las la-pen"></i>
                        </a>
                        <a href="javascript:;" data-inquiryid="{{ $item->inquiry_id }}" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="delete field">
                            <i class="las la-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['fields']->count() == 0)
                    <tr>
                        <td colspan="10" align="center">
                            <i>
                                <strong style="color:red;">
                                @if (count(Request::query()) > 0)
                                ! Inquiry Field not found :( !
                                @else
                                ! Inquiry Field is empty !
                                @endif
                                </strong>
                            </i>
                        </td>
                    </tr>
                @endif
                @foreach ($data['fields'] as $key => $item)
                <tr>
                    <td>
                        <div class="card">
                            <div class="card-body">
                                <div class="item-table">
                                    <div class="data-table">Label</div>
                                    <div class="desc-table">
                                        <strong>{!! Str::limit($item->fieldLang('label'), 50) !!}</strong>
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Name</div>
                                    <div class="desc-table">
                                        <code>{{ $item->name }}</code>
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Properties</div>
                                    <div class="desc-table">
                                        <code>{{ json_encode($item->properties) }}</code>
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Type</div>
                                    <div class="desc-table">
                                        <span class="badge badge-primary">{{ $item->customConfig()['type'] }}</span>
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Validation</div>
                                    <div class="desc-table">
                                        <code>{{ $item->validation }}</code>
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
                                        @if ($item->where('inquiry_id', $item->inquiry_id)->min('position') != $item->position)
                                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="Click to up position">
                                            <i class="las la-arrow-up"></i>
                                            <form action="{{ route('inquiry.field.position', ['inquiryId' => $item->inquiry_id, 'id' => $item->id, 'position' => ($item->position - 1)]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                        </a>
                                        @else
                                        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-up"></i></button>
                                        @endif
                                        @if ($item->where('inquiry_id', $item->inquiry_id)->max('position') != $item->position)
                                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="Click to down position">
                                            <i class="las la-arrow-down"></i>
                                            <form action="{{ route('inquiry.field.position', ['inquiryId' => $item->inquiry_id, 'id' => $item->id, 'position' => ($item->position + 1)]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                        </a>
                                        @else
                                        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-down"></i></button>
                                        @endif
                                        <a href="{{ route('inquiry.field.edit', ['inquiryId' => $item->inquiry_id, 'id' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="edit field">
                                            <i class="las la-pen"></i>
                                        </a>
                                        <a href="javascript:;" data-inquiryid="{{ $item->inquiry_id }}" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="delete field">
                                            <i class="las la-trash"></i>
                                        </a>
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
                Total : <strong>{{ $data['fields']->count() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
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
            var inquiry_id = $(this).attr('data-inquiryid');
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
                        url: '/admin/inquiry/' + inquiry_id + '/field/' + id,
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
                        text: 'inquiry field successfully deleted'
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
