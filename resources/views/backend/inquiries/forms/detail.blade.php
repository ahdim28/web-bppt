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
                        @foreach (config('custom.label.read') as $key => $val)
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
        <h5 class="card-header-title mt-1 mb-0">Inquiry <i>({!! $data['inquiry']->fieldLang('name') !!})</i> Form List</h5>
        <div class="card-header-elements ml-auto">
            <button type="button" class="btn btn-success icon-btn-only-sm" data-toggle="modal" data-target="#modal-export" title="export">
                <i class="las la-file-excel"></i> <span>Export</span>
            </button>
        </div>
    </div>
    <div class="table-responsive table-mobile-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th style="width: 160px;">IP Address</th>
                    @foreach ($data['inquiry']->inquiryField()->limit(3)->get() as $item)
                    <th>{{ $item->fieldLang('label') }}</th>
                    @endforeach
                    <th class="text-center" style="width: 80px;">Status</th>
                    <th class="text-center" style="width: 80px;">Exported</th>
                    <th style="width: 230px;">Submit Time</th>
                    <th class="text-center" style="width: 110px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['forms']->total() == 0)
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
                @foreach ($data['forms'] as $item)
                <tr>
                    <td>{{ $data['no']++ }}</td>
                    <td><strong>{{ $item->ip_address }}</strong></td>
                    @foreach ($data['inquiry']->inquiryField()->limit(3)->get() as $keyF => $field)
                    <td>
                        {!! $item->fields[$field->name] !!}
                    </td>
                    @endforeach
                    <td class="text-center">
                        <span class="badge badge-{{ $item->customConfig()['read']['color'] }}">{{ __($item->customConfig()['read']['title']) }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-{{ $item->customConfig()['export']['color'] }}">{{ __($item->customConfig()['export']['title']) }}</span>
                    </td>
                    <td>
                        {{ $item->submit_time->format('d F Y (H:i A)') }}
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn icon-btn btn-sm btn-info read-form" 
                            data-inquiryid="{{ $item->inquiry_id }}"
                            data-id="{{ $item->id }}"
                            data-status="{{ $item->status }}"
                            data-toggle="modal"
                            data-target="#modal-read-{{ $item->id }}"
                            title="detail form">
                            <i class="las la-eye"></i>
                        </button>
                        <a href="javascript:;" data-inquiryid="{{ $item->inquiry_id }}" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="delete inquiry form">
                            <i class="las la-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['forms']->total() == 0)
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
                @foreach ($data['forms'] as $item)
                <tr>
                    <td>
                        <div class="card">
                            <div class="card-body">
                                <div class="item-table">
                                    <div class="data-table">IP Address</div>
                                    <div class="desc-table">
                                        <strong>{{ $item->ip_address }}</strong>
                                    </div>
                                </div>
                                @foreach ($data['inquiry']->inquiryField()->limit(3)->get() as $keyF => $field)
                                <div class="item-table">
                                    <div class="data-table">{{ $field->fieldLang('label') }}</div>
                                    <div class="desc-table">
                                        {!! $item->fields[$field->name] !!}
                                    </div>
                                </div>
                                @endforeach
                                <div class="item-table">
                                    <div class="data-table">Status</div>
                                    <div class="desc-table">
                                        <span class="badge badge-{{ $item->customConfig()['read']['color'] }}">{{ __($item->customConfig()['read']['title']) }}</span>
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Exported</div>
                                    <div class="desc-table">
                                        <span class="badge badge-{{ $item->customConfig()['export']['color'] }}">{{ __($item->customConfig()['export']['title']) }}</span>
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Submit Time</div>
                                    <div class="desc-table">
                                        {{ $item->submit_time->format('d F Y (H:i A)') }}
                                    </div>
                                </div>
                                <div class="item-table m-0">
                                    <div class="desc-table text-right">
                                        <button type="button" class="btn icon-btn btn-sm btn-info read-form" 
                                            data-inquiryid="{{ $item->inquiry_id }}"
                                            data-id="{{ $item->id }}"
                                            data-status="{{ $item->status }}"
                                            data-toggle="modal"
                                            data-target="#modal-read-{{ $item->id }}"
                                            title="detail form">
                                            <i class="las la-eye"></i>
                                        </button>
                                        <a href="javascript:;" data-inquiryid="{{ $item->inquiry_id }}" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="delete inquiry form">
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
                Showing : <strong>{{ $data['forms']->firstItem() }}</strong> - <strong>{{ $data['forms']->lastItem() }}</strong> of
                <strong>{{ $data['forms']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['forms']->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>

@include('backend.inquiries.forms.modal-detail')
@include('backend.inquiries.forms.modal-export')
@endsection

@section('scripts')
<script src="{{ asset('assets/backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script src="{{ asset('assets/backend/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/backend/js/pages_gallery.js') }}"></script>
<script>
    $(document).ready(function () {
        //read
        $('.read-form').on('click', function () {
            var inquiry_id = $(this).attr('data-inquiryid');
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');
            if (status == 0) {
                $.ajax({
                    url: '/admin/inquiry/' + inquiry_id + '/detail/' + id + '/status',
                    type: 'PUT',
                });
            }
        });

        //alert delete
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
                        url: '/admin/inquiry/' + inquiry_id + '/form/' + id,
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
                        text: 'inquiry form successfully deleted'
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

        //export
        $('#setting').show();
        $('input[type=checkbox][name=default]').change(function() {
        if (this.value == 1) {
            $('#setting').toggle('slow');
        } else {
            $('#setting').toggle('slow');
        }
    });
    });
</script>
@endsection