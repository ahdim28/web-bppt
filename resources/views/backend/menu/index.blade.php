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
                    <label class="form-label">@lang('lang.status')</label>
                    <select class="custom-select" name="s">
                        <option value=" " selected>@lang('lang.any')</option>
                        @foreach (config('custom.label.publish') as $key => $val)
                        <option value="{{ $key }}" {{ Request::get('s') == ''.$key.'' ? 'selected' : '' }} title="{{ __($val['title']) }}">{{ __($val['title']) }}</option>
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

<div class="text-left">
    @can ('menu_create')
    <a href="{{ route('menu.create', ['categoryId' => $data['category']->id]) }}" class="btn btn-success rounded-pill" title="@lang('lang.add_attr_new', [
        'attribute' => __('mod/menu.title')
    ])"><i class="las la-plus"></i>@lang('mod/menu.title')</a>
    @endcan
</div>
<br>

@if ($data['menus']->total() > 0)
<div id="accordion2">

    @foreach ($data['menus'] as $item)
    <div class="card mb-2">
      <div class="card-header">
        <a class="collapsed d-flex justify-content-between text-body" data-toggle="collapse" href="#chidl-{{ $item->id }}">
          <strong>{!! $item->modMenu()['title'] !!}</strong> 
          <div class="collapse-icon"></div>
        </a>
      </div>
      <div id="chidl-{{ $item->id }}" class="collapse" data-parent="#accordion2">
        <div class="table-responsive">
            <table id="user-list" class="table card-table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="width: 10px;">ID</th>
                        <th class="text-center" style="width: 100px;">@lang('lang.status')</th>
                        <th class="text-center" style="width: 80px;">@lang('lang.public')</th>
                        <th style="width: 230px;">@lang('lang.created')</th>
                        <th style="width: 230px;">@lang('lang.updated')</th>
                        <th class="text-center" style="width: 110px;">@lang('lang.position')</th>
                        <th class="text-center" style="width: 215px;">@lang('lang.action')</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#{{ $item->id }}</td>
                        <td class="text-center">
                            @can ('menu_update')
                            <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="badge badge-{{ $item->customConfig()['publish']['color'] }}"
                                title="@lang('lang.change_status')">
                                {{ __($item->customConfig()['publish']['title']) }}
                                <form action="{{ route('menu.publish', ['categoryId' => $item->menu_category_id, 'id' => $item->id]) }}" method="POST">
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
                            @if (Auth::user()->can('menu_update') && $item->where('menu_category_id', $item->menu_category_id)->where('parent', $item->parent)->min('position') != $item->position)
                            <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" title="@lang('lang.change_position')">
                                <i class="las la-arrow-up"></i>
                                <form action="{{ route('menu.position', ['categoryId' => $data['category']->id, 'id' => $item->id, 'position' => ($item->position - 1)]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                </form>
                            </a>
                            @else
                            <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-up"></i></button>
                            @endif
                            @if (Auth::user()->can('page_update') && $item->where('menu_category_id', $item->menu_category_id)->where('parent', $item->parent)->max('position') != $item->position)
                            <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" title="@lang('lang.change_position')">
                                <i class="las la-arrow-down"></i>
                                <form action="{{ route('menu.position', ['categoryId' => $data['category']->id, 'id' => $item->id, 'position' => ($item->position + 1)]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                </form>
                            </a>
                            @else
                            <button type="button" class="btn icon-btn btn-sm btn-default" title="@lang('alert.access_denied')" disabled><i class="las la-arrow-down"></i></button>
                            @endif
                        </td>
                        <td class="text-center">
                            @can ('menu_create')
                            <a href="{{ route('menu.create', ['categoryId' => $data['category']->id, 'parent' => $item->id]) }}" class="btn icon-btn btn-sm btn-success" title="@lang('lang.add_attr', [
                                'attribute' => __('mod/menu.title')
                            ])">
                                <i class="las la-plus"></i>
                            </a>
                            @endcan
                            @can ('menu_update')
                            @if (Auth::user()->hasRole('super') || !Auth::user()->hasRole('super') && $item->edit_public_menu == 1)
                            <a href="{{ route('menu.edit', ['categoryId' => $data['category']->id, 'id' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="@lang('lang.edit_attr', [
                                'attribute' => __('mod/menu.title')
                            ])">
                                <i class="las la-pen"></i>
                            </a>
                            @endif
                            @endcan
                            @can ('menu_delete')
                            <a href="javascript:;" data-categoryid="{{ $item->menu_category_id }}" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="@lang('lang.delete_attr', [
                                'attribute' => __('mod/menu.title')
                            ])">
                                <i class="las la-trash"></i>
                            </a>
                            @endcan
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
      </div>
    </div>
    @if (count($item->childs))
        @include('backend.menu.child', ['childs' => $item->childs, 'level' => 15])
    @endif
    @endforeach

</div>
@endif

@if ($data['menus']->total() == 0)
<div class="card">
    <div class="card-body text-center">
        <strong style="color: red;">
            @if (count(Request::query()) > 0)
            ! @lang('lang.data_attr_not_found', [
                'attribute' => __('mod/menu.title')
            ]) !
            @else
            ! @lang('lang.data_attr_empty', [
                'attribute' => __('mod/menu.title')
            ]) !
            @endif
        </strong>
    </div>
</div>
@endif

@if ($data['menus']->total() > 0)
<div class="card">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                @lang('pagination.showing') : <strong>{{ $data['menus']->firstItem() }}</strong> - <strong>{{ $data['menus']->lastItem() }}</strong> @lang('pagination.of')
                <strong>{{ $data['menus']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['menus']->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>
@endif
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
            var category_id = $(this).attr('data-categoryid');
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
                        url: '/admin/menu/category/' + category_id + '/' + id,
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
                        text: "@lang('alert.delete_success', ['attribute' => __('mod/menu.title')])"
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