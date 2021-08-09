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
        <h5 class="card-header-title mt-1 mb-0">@lang('mod/language.caption') @lang('lang.trash')</h5>
    </div>
    <div class="table-responsive table-mobile-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>@lang('mod/language.label.field2')</th>
                    <th style="width: 100px;" class="text-center">@lang('mod/language.label.field1')</th>
                    <th style="width: 120px;" class="text-center">@lang('mod/language.label.field3')</th>
                    <th>@lang('mod/language.label.field7')</th>
                    <th>@lang('mod/language.label.field5')</th>
                    <th>@lang('mod/language.label.field6')</th>
                    <th style="width: 215px;">@lang('lang.deleted')</th>
                    <th class="text-center" style="width: 110px;">@lang('lang.action')</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['languages']->total() == 0)
                    <tr>
                        <td colspan="9" class="text-center">
                            <i>
                                <strong style="color:red;">
                                @if (count(Request::query()) > 0)
                                ! @lang('lang.data_attr_not_found', [
                                    'attribute' => __('lang.trash')
                                ]) !
                                @else
                                ! @lang('lang.data_attr_empty', [
                                    'attribute' => __('lang.trash')
                                ]) !
                                @endif
                                </strong>
                            </i>
                        </td>
                    </tr>
                @endif
                @foreach ($data['languages'] as $item)
                    <tr>
                        <td>{{ $data['no']++ }} </td>
                        <td>
                            <img src="{{ $item->flags() }}" style="width: 40px;">&nbsp;
                            <strong>{{ $item->country }}</strong>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-primary icon-btn">{{ $item->iso_codes }}</button>
                        </td>
                        <td class="text-center">
                            @if (!empty($item->country_code))
                            <button type="button" class="btn btn-sm btn-success icon-btn">{{ $item->country_code }}</button>
                            @else
                            -
                            @endif
                        </td>
                        <td><code>{{ $item->faker_locale ?? '-' }}</code></td>
                        <td>{{ $item->time_zone ?? '-' }}</td>
                        <td>{{ $item->gmt ?? '-' }}</td>
                        <td>
                            {{ $item->deleted_at->format('d F Y (H:i A)') }}
                            <br>
                            <span class="text-muted"> By : {{ $item->deleteBy->name }}</span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-success icon-btn btn-sm restore" onclick="$(this).find('#form-restore').submit();" title="@lang('lang.restore')" data-id="{{ $item->id }}">
                                <i class="las la-trash-restore-alt"></i>
                                <form action="{{ route('language.restore', ['id' => $item->id])}}" method="POST" id="form-restore-{{ $item->id }}">
                                    @csrf
                                    @method('PUT')
                                </form>
                            </button>
                            <button type="button" class="btn btn-danger icon-btn btn-sm swal-delete" data-id="{{ $item->id }}" title="@lang('lang.delete')">
                                <i class="las la-ban"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['languages']->total() == 0)
                    <tr>
                        <td colspan="9" align="center">
                            <i>
                                <strong style="color:red;">
                                @if (count(Request::query()) > 0)
                                ! @lang('lang.data_attr_not_found', [
                                    'attribute' => __('lang.trash')
                                ]) !
                                @else
                                ! @lang('lang.data_attr_empty', [
                                    'attribute' => __('lang.trash')
                                ]) !
                                @endif
                                </strong>
                            </i>
                        </td>
                    </tr>
                @endif
                @foreach ($data['languages'] as $item)
                <tr>
                    <td>
                        <div class="card">
                            <div class="card-body">
                                <div class="item-table">
                                    <div class="data-table">@lang('mod/language.label.field2')</div>
                                    <div class="desc-table">
                                        <img src="{{ $item->flags() }}" style="width: 40px;">&nbsp;
                                        <strong>{{ $item->country }}</strong>
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('mod/language.label.field1')</div>
                                    <div class="desc-table">
                                        <button type="button" class="btn btn-sm btn-primary icon-btn">{{ $item->iso_codes }}</button>
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('mod/language.label.field3')</div>
                                    <div class="desc-table">
                                        @if (!empty($item->country_code))
                                        <button type="button" class="btn btn-sm btn-success icon-btn">{{ $item->country_code }}</button>
                                        @else
                                        -
                                        @endif
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('mod/language.label.field7')</div>
                                    <div class="desc-table"><code>{{ $item->faker_locale ?? '-' }}</code></div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('mod/language.label.field5')</div>
                                    <div class="desc-table">{{ $item->time_zone ?? '-' }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('mod/language.label.field6')</div>
                                    <div class="desc-table">{{ $item->gmt ?? '-' }}</div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">@lang('lang.deleted')</div>
                                    <div class="desc-table">
                                        {{ $item->deleted_at->format('d F Y (H:i A)') }}
                                        <br>
                                        <span class="text-muted"> By : {{ $item->deleteBy->name }}</span>
                                    </div>
                                </div>
                                <div class="item-table m-0">
                                    <div class="desc-table text-right">
                                        <button type="button" class="btn btn-success icon-btn btn-sm restore" onclick="$(this).find('#form-restore').submit();" title="@lang('lang.restore')" data-id="{{ $item->id }}">
                                            <i class="las la-trash-restore-alt"></i>
                                            <form action="{{ route('language.restore', ['id' => $item->id])}}" method="POST" id="form-restore-{{ $item->id }}">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                        </button>
                                        <button type="button" class="btn btn-danger icon-btn btn-sm swal-delete" data-id="{{ $item->id }}" title="@lang('lang.delete')">
                                            <i class="las la-ban"></i>
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
                @lang('pagination.showing') : <strong>{{ $data['languages']->firstItem() }}</strong> - <strong>{{ $data['languages']->lastItem() }}</strong> @lang('pagination.of')
                <strong>{{ $data['languages']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['languages']->onEachSide(1)->links() }}
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
                        url: '/admin/language/' + id + '/permanent?is_trash=yes',
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
                        text: "@lang('alert.delete_success', ['attribute' => __('mod/language.caption')])"
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

    //restore
    $('.restore').click(function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var url = $(this).attr('href');
        Swal.fire({
        title: "@lang('alert.delete_confirm_restore_title')",
        text: "@lang('alert.delete_confirm_text')",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "@lang('lang.restore')",
        cancelButtonText: "@lang('lang.cancel')",
        }).then((result) => {
        if (result.value) {
            $("#form-restore-" + id).submit();
        }
        })
    });
</script>
@endsection
