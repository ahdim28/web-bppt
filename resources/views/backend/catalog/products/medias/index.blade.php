@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/backend/fancybox/fancybox.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/dropzone/dropzone.css') }}">
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

<div class="text-left">
    <div class="btn-group dropdown ml-2">
        <button type="button" class="btn btn-success dropdown-toggle hide-arrow icon-btn-only-sm" data-toggle="dropdown"><i class="las la-plus"></i><span>Media</span></button>
        <div class="dropdown-menu dropdown-menu-right">
            <a href="{{ route('catalog.product.media.create', ['productId' => $data['product']->id]) }}" class="dropdown-item" title="upload from form">
                <i class="las la-file-upload"></i>
                <span>Form</span>
            </a>
            <a href="javascript:;" id="upload" class="dropdown-item" title="upload from drag">
                <i class="las la-hand-pointer"></i>
                <span>Drag / Drop</span>
            </a>
        </div>
    </div>
</div>
<br>

<div class="row drag files">
    @foreach ($data['medias'] as $item)
    <div class="col-sm-6 col-xl-4" id="{{ $item->id }}" style="cursor: move;" title="change position">
        <div class="card card-list">
            <div class="w-100">
                <div class="card-img-top d-block ui-rect-60 ui-bg-cover" style="background-image: url({{ $item->fileSrc()['image'] }});">
                    <div class="d-flex justify-content-between align-items-end ui-rect-content p-3">
                        <div class="flex-shrink-1">
                            
                        </div>
                        <div class="text-big">
                            <div class="badge badge-dark font-weight-bold">{{ $item->fileSrc()['name'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h5 class="mb-3">
                    <a href="#" class="text-body">
                        [{!! !empty($item->caption['title']) ? Str::limit(strip_tags($item->caption['title']), 60) : __('lang.no', [
                            'attribute' => 'Title'
                        ]) !!}]
                    </a>
                </h5>
                <p class="text-muted mb-3">
                    [{!! !empty($item->caption['description']) ? Str::limit(strip_tags($item->caption['description']), 70) : __('lang.no', [
                            'attribute' => 'Description'
                        ]) !!}]
                </p>
                <div class="media">
                    <div class="media-body">
                        @if ($item->is_video == 1 && !empty($item->file))
                        <button class="btn icon-btn btn-sm btn-info modals-preview" data-toggle="modal" data-target="#preview-video" data-video="{!! $item->fileSrc()['video'] !!}" title="preview media">
                            <i class="las la-play text-white"></i>
                        </button>
                        @else
                        <a href="{{ !empty($item->youtube_id) ? $item->fileSrc()['video'] : $item->fileSrc()['image'] }}" class="btn icon-btn btn-sm btn-info" title="preview media" data-fancybox="gallery">
                            <i class="las la-play text-white"></i>
                        </a>
                        @endif
                        <a href="{{ route('catalog.product.media.edit', ['productId' => $item->catalog_product_id, 'id' => $item->id]) }}" class="btn icon-btn btn-sm btn-primary" title="edit media">
                            <i class="las la-pen text-white"></i>
                        </a>
                        <a href="javascript:void(0);" data-productid="{{ $item->catalog_product_id }}"  data-id="{{ $item->id }}" class="btn icon-btn btn-sm btn-danger swal-delete" title="delete media">
                          <i class="las la-trash-alt text-white"></i>
                        </a>
                        &nbsp;&nbsp;
                        @if ($item->where('catalog_product_id', $item->catalog_product_id)->min('position') != $item->position)
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="Click to up position">
                            <i class="las la-arrow-up"></i>
                            <form action="{{ route('catalog.product.media.position', ['productId' => $item->catalog_product_id, 'id' => $item->id, 'position' => ($item->position - 1)]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-up"></i></button>
                        @endif
                        @if ($item->where('catalog_product_id', $item->catalog_product_id)->max('position') != $item->position)
                        <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn icon-btn btn-sm btn-dark" data-toggle="tooltip" data-original-title="Click to down position">
                            <i class="las la-arrow-down"></i>
                            <form action="{{ route('catalog.product.media.position', ['productId' => $item->catalog_product_id, 'id' => $item->id, 'position' => ($item->position + 1)]) }}" method="POST">
                                @csrf
                                @method('PUT')
                            </form>
                        </a>
                        @else
                        <button type="button" class="btn icon-btn btn-sm btn-default" title="you are not allowed to take this action" disabled><i class="las la-arrow-down"></i></button>
                        @endif
                    </div>
                    <div class="text-muted small">
                        <i class="las la-user text-primary"></i>
                        <span>{{ $item->createBy->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div id="dropzone">
    <div class="dropzone needsclick" id="dropzone-upload">
        <div class="dz-message needsclick">
          Drop files here or click to upload
          <span class="note needsclick">(File Type : <strong>{{ strtoupper(config('custom.files.product.mimes').','.config('custom.files.product.mimes_video')) }}</strong>, Max Upload File <strong>10</strong>, Max Upload Size : <strong>{{ config('custom.files.product.size') }} Kilobyte</strong>)</span>
        </div>
        <div class="fallback">
          <input name="file" type="file" multiple>
        </div>
    </div>
</div>

@if ($data['medias']->total() == 0)
<div class="card files">
    <div class="card-body text-center">
        <strong style="color: red;">
            @if (count(Request::query()) > 0)
            ! Media not found :( !
            @else
            ! Media is empty !
            @endif
        </strong>
    </div>
</div>
@endif

@if ($data['medias']->total() > 0)
<div class="card files">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-lg-6 m--valign-middle">
                Showing : <strong>{{ $data['medias']->firstItem() }}</strong> - <strong>{{ $data['medias']->lastItem() }}</strong> of
                <strong>{{ $data['medias']->total() }}</strong>
            </div>
            <div class="col-lg-6 m--align-right">
                {{ $data['medias']->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</div>
@endif

@include('backend.catalog.products.medias.modal-preview')
@endsection

@section('scripts')
<script src="{{ asset('assets/backend/vendor/libs/dropzone/dropzone.js') }}"></script>
<script src="{{ asset('assets/backend/fancybox/fancybox.min.js') }}"></script>
<script src="{{ asset('assets/backend/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endsection

@section('jsbody')
<script src="{{ asset('assets/backend/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/backend/js/pages_gallery.js') }}"></script>
<script>
    //dropzone
    $(document).ready(function () {
        //form upload
        $('.files').show();
        $("#dropzone").hide();
        $('#upload').click(function(){
            $('.files').toggle('slow');
            $("#dropzone").toggle('slow');
        });
    });
    $('#dropzone-upload').dropzone({
        url: '/admin/catalog/product/{{ $data['product']->id }}/media/multiple',
        method:'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        parallelUploads: 2,
        maxFilesize: 0,
        maxFiles: 10,
        filesizeBase: 1000,
        // acceptedFiles:"image/*",
        paramName:"file",
        dictInvalidFileType:"Type file not allowed",
        addRemoveLinks: true,

        init : function () {
            this.on('complete', function () {
                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-center",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };
                    toastr.success('Upload media successfully', 'Success');

                    setTimeout(() => window.location.reload(), 1500);
                }
            });
        }
    });
    //modals edit
    $('.modals-preview').click(function() {
        var video = $(this).data('video');

        $('.modal-body').html(`
            <video style="width:100%; height:100%;" controls>
                <source src="`+video+`" type="video/mp4">
                Your browser does not support HTML video.
            </video>
        `);
    });
    //sort
    $(function () {
        $(".drag").sortable({
            connectWith: '.drag',
            update : function (event, ui) {
                var data  = $(this).sortable('toArray');
                var id = '{{ $data['product']->id }}';
                $.ajax({
                    data: {'datas' : data},
                    url: '/admin/catalog/product/'+ id +'/media/sort',
                    type: 'POST',
                    dataType:'json',
                });
            }
        });
        $( "#drag" ).disableSelection();
    });
    //delete
    $(document).ready(function () {
        $('.swal-delete').on('click', function () {
            var product_id = $(this).attr('data-productid');
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
                        url: '/admin/catalog/product/'+ product_id +'/media/'+ id,
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
                        text: 'media successfully deleted'
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
        })
    });
</script>
@endsection
