@extends('layouts.frontend.layout')

@section('content')
<div class="banner-breadcrumb">
    <div class="bg-breadcrumb">
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="box-breadcrumb bc-center">
                    <ul class="list-breadcrumb">
                        <li class="item-breadcrumb">
                            <a href="{{ route('home') }}" title="@lang('menu.frontend.title1')">
                                <i class="las la-home"></i><span>@lang('menu.frontend.title1')</span>
                            </a>
                        </li>
                        <li class="item-breadcrumb">
                            <span>@lang('common.gallery_caption')</span>
                        </li>
                        <li class="item-breadcrumb">
                            <span>@lang('common.video_caption')</span>
                        </li>
                    </ul>
                    <div class="title-heading text-center">
                        <h1>@lang('common.gallery_caption') @lang('common.video_caption')</h1>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box-wrap">
    <div class="container">
        {{-- <div class="d-flex justify-content-end mb-3">
            <div class="form-group d-flex align-items-center">
                <label class="mb-0 mr-3" for="select-display">@lang('common.display')</label>
                <select id="select-display" class="form-control fit">
                    @for ($i = 2014; $i <= now()->format('Y'); $i++)
                    <option value="{{ $i }}" {{ $i == Request::get('y') ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div> --}}
        <div class="list-video">
            <div class="row">
                @forelse ($data['video'] as $item)    
                <div class="col-md-4">
                    <div class="item-video"  data-lg-size="1280-720" data-src="https://www.youtube.com/watch?v={{ $item->youtube_id }}">
                        <div class="box-img img-overlay">
                            <div class="play-button">
                                <i class="las la-play"></i>
                            </div>
                            <div class="thumb-img">
                                <img src="https://i.ytimg.com/vi/{{ $item->youtube_id }}/maxresdefault.jpg" title="{!! $item->fieldLang('title') !!}">
                            </div>
                        </div>
                        <div class="video-desc">
                            <div class="title-album">
                                <h6>{!! $item->fieldLang('title') !!}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-md-12 text-center">
                    <i>
                        <strong style="color:red;">
                            @if (count(Request::query()) > 0)
                            ! @lang('lang.data_attr_not_found', [
                                'attribute' => __('common.gallery_caption').' '.__('common.video_caption')
                            ]) !
                            @else
                            ! @lang('lang.data_attr_empty', [
                                'attribute' => __('common.gallery_caption').' '.__('common.video_caption')
                            ]) !
                            @endif
                        </strong>
                    </i>
                </div>
                @endforelse
            </div>
            <div class="box-btn d-flex justify-content-end">
                {{ $data['video']->onEachSide(1)->links('vendor.pagination.frontend') }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('jsbody')
<script src="{{ asset('assets/frontend/js/lg/lg-video.js') }}"></script>
<script>
    //VIDEO
     $('.list-video').lightGallery({
        selector: '.item-video',
        counter: false,
    });

    $('#select-display').on('change', function () {
        var year = $(this).val();

        window.location.href = '/playlist?y='+year;
    });
</script>
@endsection
