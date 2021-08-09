@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header">
      <div class="media flex-wrap align-items-center">
        <img src="{{ $data['comment']->user->avatars() }}" class="d-block ui-w-40 rounded-circle" alt="">
        <div class="media-body ml-3">
          <a href="javascript:void(0)">{{ $data['comment']->user->name }}</a>
          <div class="text-muted small">
            {{ $data['comment']->created_at->diffForHumans() }}
            @if ($data['comment']->created_at != $data['comment']->updated_at)
            <i>(edited)</i>
            @endif
          </div>
        </div>
      </div>
    </div>
    <div class="card-body">
      {!! $data['comment']->comment !!}
    </div>
</div>

@foreach ($data['replies'] as $item)    
<div class="card mb-3 ml-4">
    <div class="card-body">
      <div class="media">
        <img src="{{ $item->user->avatars() }}" alt="" class="d-block ui-w-40 rounded-circle">
        <div class="media-body ml-4">
          <div class="float-right text-muted small">
            @can ('comment_delete')
            <button type="button" class="btn btn-danger icon-btn btn-sm swal-delete" title="@lang('lang.delete_attr', [
                'attribute' => __('mod/master.comment.reply')
            ])"
                data-id="{{ $item->id }}">
                <i class="las la-trash-alt"></i>
            </button>
            @else
            <button type="button" class="btn btn-danger icon-btn btn-sm" title="you are not allowed to take this action" disabled>
                <i class="las la-trash-alt"></i>
            </button>
            @endcan
          </div>
          <a href="javascript:void(0)">{{ $item->user->name }}</a>
          <div class="text-muted small">
            {{ $item->created_at->diffForHumans() }}
            @if ($item->created_at != $item->updated_at)
            <i>(edited)</i>
            @endif
          </div>
          <div class="mt-2">
            {!! $item->comment !!}
          </div>
          <div class="small mt-2">
            @can ('comment_update')
            <a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="badge badge-{{ $item->customConfig()['flags']['color'] }}"
                title="@lang('mod/master.comment.label.field3')">
                {{ __($item->customConfig()['flags']['title']) }}
                <form action="{{ route('comment.flags.reply', ['id' => $item->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                </form>
            </a>
            @else
            <span class="badge badge-{{ $item->customConfig()['flags']['color'] }}">{{ __($item->customConfig()['flags']['title']) }}</span>
            @endcan
          </div>
        </div>
      </div>
    </div>
</div>
@endforeach

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
                        url: '/admin/comment/' + id + '/reply',
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
                        text: "@lang('alert.delete_success', ['attribute' => __('mod/master.comment.reply')])"
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