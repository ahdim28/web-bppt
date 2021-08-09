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
                    <label class="form-label">Category</label>
                    <select class="status custom-select" name="c">
                        <option value=" " selected>Any</option>
                        @foreach ($data['categories'] as $category)
                        <option value="{{ $category->id }}" {{ Request::get('c') == $category->id ? 'selected' : '' }} title="Filter by {{ $category->fieldLang('name') }}">{{ $category->fieldLang('name') }}</option>
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
        <h5 class="card-header-title mt-1 mb-0">Post List</h5>
        <div class="card-header-elements ml-auto">
            @can ('content_categories')
            <a href="{{ route('category.index', ['sectionId' => $data['section']->id]) }}" class="btn btn-primary icon-btn-only-sm" title="Category">
                <i class="las la-list"></i> <span>Category</span>
            </a>
            @endcan
            @can ('content_post_create')
            <a href="{{ route('post.create', ['sectionId' => $data['section']->id]) }}" class="btn btn-success icon-btn-only-sm" title="Add New Post">
                <i class="las la-plus"></i> <span>Post</span>
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
                    <th style="width: 170px;">Category</th>
                    <th class="text-center" style="width: 80px;">Viewer</th>
                    <th class="text-center" style="width: 100px;">Status</th>
                    <th class="text-center" style="width: 80px;">Public</th>
                    <th style="width: 230px;">Created</th>
                    <th style="width: 230px;">Updated</th>
                    @if ($data['section']->order_field == 'position')
                    <th class="text-center" style="width: 110px;">Position</th>
                    @endif
                    <th class="text-center" style="width: 210px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($data['posts']->total() == 0)
                    <tr>
                        <td colspan="@if ($data['section']->order_field == 'position') 10 @else 9 @endif" align="center">
                            <i>
                                <strong style="color:red;">
                                @if (count(Request::query()) > 0)
                                ! Posts not found :( !
                                @else
                                ! Posts is empty !
                                @endif
                                </strong>
                            </i>
                        </td>
                    </tr>
                @endif
                @foreach ($data['posts'] as $item)
                <tr>
                    <td>{{ $data['no']++ }}</td>
                    <td><strong>{!! Str::limit($item->fieldLang('title'), 50) !!}</strong></td>
                    <td>{!! $item->category->fieldLang('name') !!}</td>
                    <td class="text-center"><span class="badge badge-info">{{ $item->viewer }}</span></td>
                    <td class="text-center">
                        @can ('content_post_update')
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="badge badge-{{ $item->customConfig()['publish']['color'] }}"
                            title="Status">
                            {{ __($item->customConfig()['publish']['title']) }}
                            <form action="{{ route('post.publish', ['sectionId' => $item->section_id, 'id' => $item->id]) }}" method="POST">
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
                    @if ($data['section']->order_field == 'position')
                    <td class="text-center">
                        @if (auth()->user()->can('content_post_update') && $item->where('section_id', $item->section_id)->min('position') != $item->position)
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="Position Up">
                            <i class="las la-arrow-up"></i>
                            <form action="{{ route('post.position', ['sectionId' => $item->section_id, 'id' => $item->id, 'position' => ($item->position - 1)]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-up"></i></button>
                        @endif
                        @if (auth()->user()->can('content_post_update') && $item->where('section_id', $item->section_id)->max('position') != $item->position)
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="Position Down">
                            <i class="las la-arrow-down"></i>
                            <form action="{{ route('post.position', ['sectionId' => $item->section_id, 'id' => $item->id, 'position' => ($item->position + 1)]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-down"></i></button>
                        @endif
                    </td>
                    @endif
                    <td>
                        <a href="{{ route('post.read.'.$item->section->slug, ['slugPost' => $item->slug]) }}" class="btn icon-btn btn-sm btn-info" title="View Detail" target="_blank">
                            <i class="las la-external-link-alt"></i>
                        </a>
                        @can('medias')
                        <a href="{{ route('media.index', ['moduleId' => $item->id, 'moduleName' => 'post', 'sectionId' => $item->section_id]) }}" class="btn icon-btn btn-sm btn-info" title="Media">
                            <i class="las la-folder"></i>
                        </a>
                        @endcan
                        @can('content_post_update')
                        <a href="javascript:void(0);" class="btn icon-btn btn-sm btn-{{ $item->selection == 1 ? 'warning' : 'secondary' }}" title="select / unselect post" onclick="$(this).find('form').submit();">
                            <i class="las la-star"></i>
                            <form action="{{ route('post.selection', ['sectionId' => $item->section_id, 'id' => $item->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @endcan
                        @can('content_post_update')
                        <a href="{{ route('post.edit', ['sectionId' => $item->section_id, 'id' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="Edit Post">
                            <i class="las la-pen"></i>
                        </a>
                        @endcan
                        @can('content_post_delete')
                        <a href="javascript:;" data-sectionid="{{ $item->section_id }}" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="Delete Post">
                            <i class="las la-trash"></i>
                        </a>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody class="tbody-responsive">
                @if ($data['posts']->total() == 0)
                    <tr>
                        <td colspan="@if ($data['section']->order_field == 'position') 10 @else 9 @endif" align="center">
                            <i>
                                <strong style="color:red;">
                                @if (count(Request::query()) > 0)
                                ! Posts not found :( !
                                @else
                                ! Posts is empty !
                                @endif
                                </strong>
                            </i>
                        </td>
                    </tr>
                @endif
                @foreach ($data['posts'] as $item)
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
                                    <div class="data-table">Category</div>
                                    <div class="desc-table">
                                        {!! $item->category->fieldLang('name') !!}
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
                                        @can ('content_post_update')
                                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="badge badge-{{ $item->customConfig()['publish']['color'] }}"
                                            title="Status">
                                            {{ __($item->customConfig()['publish']['title']) }}
                                            <form action="{{ route('post.publish', ['sectionId' => $item->section_id, 'id' => $item->id]) }}" method="POST">
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
                                        @if ($data['section']->order_field == 'position')
                                            @if (auth()->user()->can('content_post_update') && $item->where('section_id', $item->section_id)->min('position') != $item->position)
                                            <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="Position Up">
                                                <i class="las la-arrow-up"></i>
                                                <form action="{{ route('post.position', ['sectionId' => $item->section_id, 'id' => $item->id, 'position' => ($item->position - 1)]) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                </form>
                                            </a>
                                            @else
                                            <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-up"></i></button>
                                            @endif
                                            @if (auth()->user()->can('content_post_update') && $item->where('section_id', $item->section_id)->max('position') != $item->position)
                                            <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="Position Down">
                                                <i class="las la-arrow-down"></i>
                                                <form action="{{ route('post.position', ['sectionId' => $item->section_id, 'id' => $item->id, 'position' => ($item->position + 1)]) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                </form>
                                            </a>
                                            @else
                                            <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-down"></i></button>
                                            @endif
                                        @endif
                                        <a href="{{ route('post.read.'.$item->section->slug, ['slugPost' => $item->slug]) }}" class="btn icon-btn btn-sm btn-info" title="View Detail" target="_blank">
                                            <i class="las la-external-link-alt"></i>
                                        </a>
                                        @can('medias')
                                        <a href="{{ route('media.index', ['moduleId' => $item->id, 'moduleName' => 'post', 'sectionId' => $item->section_id]) }}" class="btn icon-btn btn-sm btn-info" title="Media">
                                            <i class="las la-folder"></i>
                                        </a>
                                        @endcan
                                        @can('content_post_update')
                                        <a href="javascript:void(0);" class="btn icon-btn btn-sm btn-{{ $item->selection == 1 ? 'warning' : 'secondary' }}" title="select / unselect post" onclick="$(this).find('form').submit();">
                                            <i class="las la-star"></i>
                                            <form action="{{ route('post.selection', ['sectionId' => $item->section_id, 'id' => $item->id]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                        </a>
                                        @endcan
                                        @can('content_post_update')
                                        <a href="{{ route('post.edit', ['sectionId' => $item->section_id, 'id' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="Edit Post">
                                            <i class="las la-pen"></i>
                                        </a>
                                        @endcan
                                        @can('content_post_delete')
                                        <a href="javascript:;" data-sectionid="{{ $item->section_id }}" data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="Delete Post">
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
                Showing : <strong>{{ $data['posts']->firstItem() }}</strong> - <strong>{{ $data['posts']->lastItem() }}</strong> of
                <strong>{{ $data['posts']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['posts']->onEachSide(1)->links() }}
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
            var section_id = $(this).attr('data-sectionid');
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
                        url: '/admin/section/' + section_id +'/post/' + id,
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
                        text: 'post successfully deleted'
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