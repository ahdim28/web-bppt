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
                    <label class="form-label">Extra</label>
                    <select class="extra custom-select" name="e">
                        <option value=" " selected>@lang('lang.any')</option>
                        @foreach (config('custom.label.extra') as $key => $val)
                        <option value="{{ $key }}" {{ Request::get('e') == ''.$key.'' ? 'selected' : '' }} title="Filter by {{ $val['title']}}">{{ $val['title']}}</option>
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
        <h5 class="card-header-title mt-1 mb-0">Section List</h5>
        <div class="card-header-elements ml-auto">
            @can ('content_section_create')
            <a href="{{ route('section.create') }}" class="btn btn-success icon-btn-only-sm" title="Add New Section">
                <i class="las la-plus"></i> <span>Section</span>
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
                    <th class="text-center" style="width: 150px;">Categories</th>
                    <th class="text-center" style="width: 150px;">Posts</th>
                    <th class="text-center" style="width: 80px;">@lang('lang.viewer')</th>
                    <th class="text-center" style="width: 120px;">Extra</th>
                    <th class="text-center" style="width: 80px;">@lang('lang.public')</th>
                    <th style="width: 230px;">@lang('lang.created')</th>
                    <th style="width: 230px;">@lang('lang.updated')</th>
                    <th class="text-center" style="width: 110px;">@lang('lang.position')</th>
                    <th class="text-center" style="width: 140px;">@lang('lang.action')</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['sections']->total() == 0)
                    <tr>
                        <td colspan="11" align="center">
                            <i>
                                <strong style="color:red;">
                                    @if (count(Request::query()) > 0)
                                    ! @lang('lang.data_attr_not_found', [
                                        'attribute' => 'Section'
                                    ]) !
                                    @else
                                    ! @lang('lang.data_attr_empty', [
                                        'attribute' => 'Section'
                                    ]) !
                                    @endif
                                </strong>
                            </i>
                        </td>
                    </tr>
                @endif
                @foreach ($data['sections'] as $item)
                <tr>
                    <td>{{ $data['no']++ }}</td>
                    <td><strong>{!! Str::limit($item->fieldLang('name'), 50) !!}</strong></td>
                    <td class="text-center">
                        {{-- Total : <span class="badge badge-success">{{ $item->categories->count() }}</span><br> --}}
                        @can ('content_categories')
                        <a href="{{ route('category.index', ['sectionId' => $item->id]) }}" class="btn btn-sm btn-warning" title="Category">
                            <i class="las la-list"></i> LIST
                        </a>
                        @endcan
                    </td>
                    <td class="text-center">
                        {{-- Total : <span class="badge badge-success">{{ $item->posts->count() }}</span><br> --}}
                        @can ('content_posts')
                        <a href="{{ route('post.index', ['sectionId' => $item->id]) }}" class="btn btn-sm btn-warning" title="Post">
                            <i class="las la-list"></i> LIST
                        </a>
                        @endcan
                    </td>
                    <td class="text-center"><span class="badge badge-info">{{ $item->viewer }}</span></td>
                    <td class="text-center">
                        <span class="badge badge-{{ $item->customConfig()['extra']['color'] }}">{{ $item->customConfig()['extra']['title'] }}</span>
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
                        @if (auth()->user()->can('content_section_update') && $item->min('position') != $item->position)
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="@lang('lang.position') Up">
                            <i class="las la-arrow-up"></i>
                            <form action="{{ route('section.position', ['id' => $item->id, 'position' => ($item->position - 1)]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-up"></i></button>
                        @endif
                        @if (auth()->user()->can('content_section_update') && $item->max('position') != $item->position)
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="@lang('lang.position') Down">
                            <i class="las la-arrow-down"></i>
                            <form action="{{ route('section.position', ['id' => $item->id, 'position' => ($item->position + 1)]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-down"></i></button>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('section.read.'.$item->slug) }}" class="btn icon-btn btn-sm btn-info" title="View Detail" target="_blank">
                            <i class="las la-external-link-alt"></i>
                        </a>
                        @can('content_section_update')
                        <a href="{{ route('section.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="Edit Section">
                            <i class="las la-pen"></i>
                        </a>
                        @endcan
                        @can('content_section_delete')
                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="Delete Section">
                            <i class="las la-trash"></i>
                        </a>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['sections']->total() == 0)
                    <tr>
                        <td colspan="11" align="center">
                            <i>
                                <strong style="color:red;">
                                @if (count(Request::query()) > 0)
                                ! @lang('lang.data_attr_not_found', [
                                    'attribute' => 'Section'
                                ]) !
                                @else
                                ! @lang('lang.data_attr_empty', [
                                    'attribute' => 'Section'
                                ]) !
                                @endif
                                </strong>
                            </i>
                        </td>
                    </tr>
                @endif
                @foreach ($data['sections'] as $item)
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
                                    <div class="data-table">Categories</div>
                                    <div class="desc-table">
                                        {{-- Total : <span class="badge badge-success">{{ $item->categories->count() }}</span><br> --}}
                                        @can ('content_categories')
                                        <a href="{{ route('category.index', ['sectionId' => $item->id]) }}" class="btn btn-sm btn-warning" title="Category">
                                            <i class="las la-list"></i> LIST
                                        </a>
                                        @endcan
                                    </div>
                                </div>
                                <div class="item-table">
                                    <div class="data-table">Posts</div>
                                    <div class="desc-table">
                                        {{-- Total : <span class="badge badge-success">{{ $item->posts->count() }}</span><br> --}}
                                        @can ('content_posts')
                                        <a href="{{ route('post.index', ['sectionId' => $item->id]) }}" class="btn btn-sm btn-warning" title="Post">
                                            <i class="las la-list"></i> LIST
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
                                    <div class="data-table">Extra</div>
                                    <div class="desc-table">
                                        <span class="badge badge-{{ $item->customConfig()['extra']['color'] }}">{{ $item->customConfig()['extra']['title'] }}</span>
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
                                        @if (auth()->user()->can('content_section_update') && $item->min('position') != $item->position)
                                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="@lang('lang.position') Up">
                                            <i class="las la-arrow-up"></i>
                                            <form action="{{ route('section.position', ['id' => $item->id, 'position' => ($item->position - 1)]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                        </a>
                                        @else
                                        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-up"></i></button>
                                        @endif
                                        @if (auth()->user()->can('content_section_update') && $item->max('position') != $item->position)
                                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="@lang('lang.position') Down">
                                            <i class="las la-arrow-down"></i>
                                            <form action="{{ route('section.position', ['id' => $item->id, 'position' => ($item->position + 1)]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                        </a>
                                        @else
                                        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-down"></i></button>
                                        @endif
                                        <a href="{{ route('section.read.'.$item->slug) }}" class="btn icon-btn btn-sm btn-info" title="View Detail" target="_blank">
                                            <i class="las la-external-link-alt"></i>
                                        </a>
                                        @can('content_section_update')
                                        <a href="{{ route('section.edit', ['id' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="Edit Section">
                                            <i class="las la-pen"></i>
                                        </a>
                                        @endcan
                                        @can('content_section_delete')
                                        <a href="javascript:;" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="Delete Section">
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
                @lang('pagination.showing') : <strong>{{ $data['sections']->firstItem() }}</strong> - <strong>{{ $data['sections']->lastItem() }}</strong> @lang('pagination.of')
                <strong>{{ $data['sections']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['sections']->onEachSide(1)->links() }}
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
                        url: '/admin/section/' + id,
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
                        text: "@lang('alert.delete_success', ['attribute' => 'Section'])"
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