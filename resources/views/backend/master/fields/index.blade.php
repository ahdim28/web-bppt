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
        <h5 class="card-header-title mt-1 mb-0">@lang('mod/master.field.text')</h5>
        <div class="card-header-elements ml-auto">
            <a href="{{ route('field.create', ['categoryId' => $data['category']->id]) }}" class="btn btn-success icon-btn-only-sm" title="@lang('lang.add_attr_new', [
                'attribute' => __('mod/master.field.caption')
            ])">
                <i class="las la-plus"></i> <span>@lang('mod/master.field.caption')</span>
            </a>
        </div>
    </div>
    <div class="table-responsive table-mobile-responsive">
        <table id="user-list" class="table card-table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">No</th>
                    <th>@lang('mod/master.field.label.field1')</th>
                    <th>@lang('mod/master.field.label.field2')</th>
                    <th class="text-center" style="width: 100px;">@lang('mod/master.field.label.field3')</th>
                    <th class="text-center" style="width: 100px;">@lang('mod/master.field.label.field4')</th>
                    <th style="width: 215px;">@lang('lang.created')</th>
                    <th style="width: 215px;">@lang('lang.updated')</th>
                    <th class="text-center" style="width: 110px;">@lang('lang.action')</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['fields']->total() == 0)
                    <tr>
                        <td colspan="8" align="center">
                            <i>
                                <strong style="color:red;">
                                @if (count(Request::query()) > 0)
                                ! @lang('lang.data_attr_not_found', [
                                    'attribute' => __('mod/master.field.caption')
                                ]) !
                                @else
                                ! @lang('lang.data_attr_empty', [
                                    'attribute' => __('mod/master.field.caption')
                                ]) !
                                @endif
                                </strong>
                            </i>
                        </td>
                    </tr>
                @endif
                @foreach ($data['fields'] as $item)
                    <tr>
                        <td>{{ $data['no']++ }}</td>
                        <td><strong>{{ $item->label }}</strong></td>
                        <td>{{ $item->name }}</td>
                        <td class="text-center">
                            <span class="badge badge-primary">{{ $item->customConfig()['module']['title'] }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-success">{{ $item->customConfig()['module']['class'][$item->classes] }}</span>
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
                            <a href="{{ route('field.edit', ['categoryId' => $item->category_id, 'id' => $item->id]) }}" class="btn btn-primary icon-btn btn-sm" title="@lang('lang.edit_attr', [
                                'attribute' => __('mod/master.field.caption')
                            ])">
                                <i class="las la-pen"></i>
                            </a>
                            <button type="button" class="btn btn-danger icon-btn btn-sm swal-delete" title="@lang('lang.delete_attr', [
                                'attribute' => __('mod/master.field.caption')
                            ])"
                                data-category-id="{{ $item->category_id }}"
                                data-id="{{ $item->id }}">
                                <i class="las la-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['fields']->total() == 0)
                    <tr>
                        <td colspan="8" align="center">
                            <i>
                                <strong style="color:red;">
                                @if (count(Request::query()) > 0)
                                ! @lang('lang.data_attr_not_found', [
                                    'attribute' => __('mod/master.field.caption')
                                ]) !
                                @else
                                ! @lang('lang.data_attr_empty', [
                                    'attribute' => __('mod/master.field.caption')
                                ]) !
                                @endif
                                </strong>
                            </i>
                        </td>
                    </tr>
                @endif
                @foreach ($data['fields'] as $item)
                    <tr>
                        <td>
                            <div class="card">
                                <div class="card-body">
                                    <div class="item-table">
                                        <div class="data-table">@lang('mod/master.field.label.field1')</div>
                                        <div class="desc-table"><strong>{{ $item->label }}</strong></div>
                                    </div>
                                    <div class="item-table">
                                        <div class="data-table">@lang('mod/master.field.label.field2')</div>
                                        <div class="desc-table">{{ $item->name }}</div>
                                    </div>
                                    <div class="item-table">
                                        <div class="data-table">@lang('mod/master.field.label.field3')</div>
                                        <div class="desc-table">
                                            <span class="badge badge-primary">{{ $item->customConfig()['module']['title'] }}</span>
                                        </div>
                                    </div>
                                    <div class="item-table">
                                        <div class="data-table">@lang('mod/master.field.label.field4')</div>
                                        <div class="desc-table">
                                            <span class="badge badge-success">{{ $item->customConfig()['module']['class'][$item->classes] }}</span>
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
                                            <a href="{{ route('field.edit', ['categoryId' => $item->category_id, 'id' => $item->id]) }}" class="btn btn-primary icon-btn btn-sm" title="@lang('lang.edit_attr', [
                                                'attribute' => __('mod/master.field.caption')
                                            ])">
                                                <i class="las la-pen"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger icon-btn btn-sm swal-delete" title="@lang('lang.delete_attr', [
                                                'attribute' => __('mod/master.field.caption')
                                            ])"
                                                data-category-id="{{ $item->category_id }}"
                                                data-id="{{ $item->id }}">
                                                <i class="las la-trash-alt"></i>
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
                @lang('pagination.showing') : <strong>{{ $data['fields']->firstItem() }}</strong> - <strong>{{ $data['fields']->lastItem() }}</strong> @lang('pagination.of')
                <strong>{{ $data['fields']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['fields']->onEachSide(1)->links() }}
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
            var category_id = $(this).attr('data-category-id');
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
                        url: '/admin/field/category/' + category_id + '/' + id,
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
                        text: "@lang('alert.delete_success', ['attribute' => __('mod/master.field.caption')])"
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