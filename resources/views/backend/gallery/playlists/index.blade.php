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

<div class="text-left mb-2">
    @can ('playlist_create')
    <a href="{{ route('gallery.playlist.create') }}" class="btn btn-success rounded-pill mr-2" title="Add New Playlist"><i class="las la-plus"></i>Playlist</a>
    @endcan
    <a href="{{ route('gallery.playlist.category.index') }}" class="btn btn-warning rounded-pill" title="Category List"><i class="las la-list"></i>Category</a>
</div>

<div class="card mb-4">
    <ul class="row drag list-group list-group-flush">

        @foreach ($data['playlists'] as $item)
        <li class="list-group-item py-4" id="{{ $item->id }}">
            <div class="media flex-wrap">
                <div class="d-none d-sm-block ui-w-140">
                <a href="javascript:void(0)" class="d-block ui-rect-67 ui-bg-cover" style="background-image: url('{{ $item->coverSrc($item->id) }}');"></a>
                </div>
                <div class="media-body ml-sm-4">
                <h5 class="mb-2">
                    <div class="float-right dropdown ml-3">
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" title="actions"><i class="las la-ellipsis-v"></i><span>Actions</span></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            @can ('videos')
                            <a href="{{ route('gallery.playlist.video.index', ['playlistId' => $item->id]) }}" class="dropdown-item" title="Video">
                                <i class="las la-video"></i><span>Video</span>
                            </a>
                            @endcan
                            <a href="{{ route('gallery.playlist.edit', ['id' => $item->id]) }}" class="dropdown-item" title="Edit Playlist">
                                <i class="las la-pen"></i><span>Edit</span>
                            </a>
                            <a href="javascript:void(0);" data-id="{{ $item->id }}" class="dropdown-item swal-delete" title="Delete Playlist">
                                <i class="las la-trash-alt"></i><span>Delete</span>
                            </a>
                            @if (auth()->user()->can('playlist_update') && $item->min('position') != $item->position)
                            <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="dropdown-item" data-original-title="Click to up position">
                                <i class="las la-arrow-up"></i> Position Up
                                <form action="{{ route('gallery.playlist.position', [$item->id, 'position' => ($item->position - 1)]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                </form>
                            </a>
                            @endif
                            @if (auth()->user()->can('playlist_update') && $item->max('position') != $item->position)
                            <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="dropdown-item" data-original-title="Click to down position">
                                <i class="las la-arrow-down"></i> Position Down
                                <form action="{{ route('gallery.playlist.position', ['id' => $item->id, 'position' => ($item->position + 1)]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                </form>
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="text-body">{!! $item->fieldLang('name') !!} (<strong>{{ $item->videos->count() }}</strong>)
                        <a href="{{ route('gallery.playlist.read', ['slugPlaylist' => $item->slug]) }}" target="_blank"><i class="las la-external-link-alt"></i></a>
                    </div> 
                </h5>
                <div class="d-flex flex-wrap align-items-center mb-2">
                    <div class="text-muted small mr-2">
                        <i class="las la-calendar text-primary"></i>
                        <span>{{ $item->created_at->format('d F Y (H:i A)') }}</span>
                    </div>
                    <div class="text-muted small mr-2">
                        <i class="las la-user text-primary"></i>
                        <span>{{ $item->createBy->name }}</span>
                    </div>
                    <div class="text-muted small">
                        <i class="las la-eye text-primary"></i>
                        <span>{{ $item->viewer }}</span>
                    </div>
                </div>
                <div>[{!! !empty($item->fieldLang('description')) ? Str::limit(strip_tags($item->fieldLang('description')), 130) : __('lang.no', [
                    'attribute' => 'Description'
                ]) !!}]</div>
                    <div class="mt-2">
                        @can ('playlist_update')
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" title="click to {{ $item->publish == 1 ? 'publish' : 'un-publish' }} playlist">
                            <span class="badge badge-{{ $item->publish == 1 ? 'success' : 'warning' }}">{{ $item->publish == 1 ? 'PUBLISH' : 'DRAFT' }}</span>
                            <form action="{{ route('gallery.playlist.publish', ['id' => $item->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            </form>
                        </a>
                        @else
                        <span class="badge badge-{{ $item->customConfig()['publish']['color'] }}">{{ __($item->customConfig()['publish']['title']) }}</span>
                        @endcan
                    </div>
                </div>
            </div>
        </li>
        @endforeach

    </ul>
</div>

@if ($data['playlists']->total() == 0)
<div class="card files">
    <div class="card-body text-center">
        <strong style="color: red;">
            @if (count(Request::query()) > 0)
            ! Playlist not found :( !
            @else
            ! Playlist is empty !
            @endif
        </strong>
    </div>
</div>
@endif

@if ($data['playlists']->total() > 0)
<div class="card files">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Showing : <strong>{{ $data['playlists']->firstItem() }}</strong> - <strong>{{ $data['playlists']->lastItem() }}</strong> of
                <strong>{{ $data['playlists']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['playlists']->onEachSide(1)->links() }}
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
<script src="{{ asset('assets/backend/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/backend/js/pages_gallery.js') }}"></script>
<script>
     //sort
     $(function () {
        $(".drag").sortable({
            connectWith: '.drag',
            update : function (event, ui) {
                var data  = $(this).sortable('toArray');
                $.ajax({
                    data: {'datas' : data},
                    url: '/admin/gallery/playlist/sort',
                    type: 'POST',
                    dataType:'json',
                });
            }
        });
        $( "#drag" ).disableSelection();
    });
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
                        url: '/admin/gallery/playlist/' + id,
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
                        text: 'playlist successfully deleted'
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