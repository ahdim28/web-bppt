@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/css/pages/file-manager.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/dropzone/dropzone.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/fancybox/fancybox.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')
<div class="card">
    <div class="card-header with-elements">
        <div class="card-header-elements">
            <h6 class="card-header-title mt-1 mb-0">@lang('mod/master.media.caption') <span class="badge badge-primary"><strong><i class="lab la-slack"></i> {{ strtoupper(Request::segment(4)) }}</strong></span></h6>
        </div>
        <div class="card-header-elements ml-auto">
            <div class="file-manager-actions">
                <a href="{{ route('media.create', ['moduleId' => $data['module']->id, 'moduleName' => Request::segment(4), 'sectionId' => Request::get('sectionId')]) }}" class="btn btn-success icon-btn-only-sm" title="@lang('lang.add_attr_new', [
                    'attribute' => __('mod/master.media.caption')
                ])">
                    <i class="las la-plus"></i> <span>@lang('mod/master.media.caption')</span>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="file-manager-container file-manager-col-view drag">
            @foreach ($data['module']->media as $key => $file)
            <div class="file-item only" id="{{ $file->id }}" style="cursor: move;" title="move position">
                @if ($file->is_youtube == 1)
                    <a href="https://www.youtube.com/embed/{{ $file->youtube_id }}?rel=0;showinfo=0" class="file-item-name" data-fancybox="gallery">
                    <div class="file-item-img" style="background-image: url(https://img.youtube.com/vi/{{ $file->youtube_id }}/mqdefault.jpg)"></div>
                        <div class="desc-of-name">
                            Youtube Video
                        </div>
                    </a>
                @else
                    <a href="{{ $file->fileSrc($file) }}" class="file-item-name" data-fancybox="gallery">
                        @if ($file->icon($file) == 'image')
                        <div class="file-item-img" style="background-image: url({{ $file->fileSrc($file) }})"></div>
                        @else
                        <div class="file-item-icon las la-file-{{ $file->icon($file) }} text-secondary"></div>
                        @endif
                        <div class="desc-of-name">
                            {{ collect(explode("/", $file->file_path['filename']))->last() }}
                        </div>
                    </a>
                @endif
                <div class="file-item-actions btn-group dropdown">
                    <button type="button" class="btn btn-sm btn-default icon-btn dropdown-toggle btn-toggle-radius hide-arrow" data-toggle="dropdown"><i class="ion ion-ios-more"></i></button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a href="{{ route('media.edit', ['moduleId' => Request::segment(3), 'moduleName' => Request::segment(4), 'id' => $file->id, 'sectionId' => Request::get('sectionId')]) }}" class="dropdown-item" title="@lang('lang.edit_attr', [
                        'attribute' => __('mod/master.media.caption')
                    ])">
                        <i class="las la-pen"></i> @lang('lang.edit')
                      </a>
                      <a class="dropdown-item swal-delete" href="javascript:void(0)" data-id="{{ $file->id }}" title="@lang('lang.delete_attr', [
                        'attribute' => __('mod/master.media.caption')
                    ])">
                        <i class="las la-trash-alt"></i> @lang('lang.delete')
                      </a>
                    </div>
                </div>
            </div>
            @endforeach
            @if ($data['module']->media->count() == 0)
            <div class="file-item">
                <div class="file-item-icon las la-ban text-danger"></div>
                <div class="file-item-name">
                    ! @lang('lang.data_attr_empty', [
                        'attribute' => __('mod/master.media.caption')
                    ]) !
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/backend/vendor/libs/dropzone/dropzone.js') }}"></script>
<script src="{{ asset('assets/backend/fancybox/fancybox.min.js') }}"></script>
<script src="{{ asset('assets/backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script src="{{ asset('assets/backend/jquery-ui.js') }}"></script>
<script>
    //sort
    $(function () {
        $(".drag").sortable({
            connectWith: '.drag',
            update : function (event, ui) {
                var data  = $(this).sortable('toArray');
                var id = "{{ Request::segment(3) }}";
                var model = "{{ Request::segment(4) }}";
                $.ajax({
                    data: {'datas' : data},
                    url: '/admin/media/'+ id +'/'+ model +'/sort',
                    type: 'POST',
                    dataType:'json',
                });
                // if (data) {
                //     location.reload();
                // }
            }
        });
        $( "#drag" ).disableSelection();
    });
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
                        url: '/admin/media/{{ Request::segment(3) }}/{{ Request::segment(4) }}/' + id + '/delete',
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
                        text: "@lang('alert.delete_success', ['attribute' => __('mod/master.media.caption')])"
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