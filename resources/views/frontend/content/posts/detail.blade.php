@extends('layouts.frontend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/frontend/css/swiper.min.css') }}">
@endsection

@section('content')
<div class="box-wrap single-post">
    <div class="container">
        <div class="box-breadcrumb">
            <ul class="list-breadcrumb">
                <li class="item-breadcrumb">
                    <a href="{{ route('home') }}" title="@lang('menu.frontend.title1')">
                        <i class="las la-home"></i><span>@lang('menu.frontend.title1')</span>
                    </a>
                </li>
                <li class="item-breadcrumb">
                    <a href="{{ route('section.read.'.$data['read']->section->slug) }}" title="{!! $data['read']->section->fieldLang('name') !!}">
                        <span>{!! Str::limit($data['read']->section->fieldLang('name'), 30) !!}</span>
                    </a>
                </li>
                <li class="item-breadcrumb">
                    <span>{!! Str::limit($data['read']->fieldLang('title'), 30) !!}</span>
                </li>
            </ul>
        </div>
        <div class="box-post">
           <div class="post-hits">
                <div class="box-hits">{{ $data['read']->viewer }}</div>
                <span>Hits</span>
            </div>
            <div class="post-title">
                <div class="title-heading">
                    <h2>{!! $data['read']->fieldLang('title') !!}</h2>
                </div>
                <div class="box-info">
                    <div class="item-info">
                        <i class="las la-user"></i>
                        <span>{!! $data['read']->createBy->name !!}</span>
                    </div>
                    <a href="{{ route('category.read.'.$data['read']->section->slug, ['slugCategory' => $data['read']->category->slug]) }}" class="item-info" title="{!! $data['read']->category->fieldLang('name') !!}">
                        <i class="las la-tag"></i>
                        <span>{!! $data['read']->category->fieldLang('name') !!}</span>
                    </a>
                    <div class="item-info">
                        <i class="las la-print"></i>
                        <a href="#!" title="Print"><span>Print<span></a>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="box-content pt-4">
            @if (!empty($data['read']->cover['file_path']))
            <div class="box-post-img">
                <img src="{{ $data['read']->coverSrc() }}" alt="{{ $data['read']->cover['alt'] }}" title="{{ $data['read']->cover['title'] }}">
            </div>
            @endif
            <article>
                {!! !empty($data['read']->fieldLang('content')) ? $data['read']->fieldLang('content') : $data['read']->fieldLang('intro') !!}
            </article>
            @if ($data['media']->count() > 0)  
            <div class="list-photo">
                <div class="swiper-container gallery-news">
                    <div class="swiper-wrapper">
                        @foreach ($data['media'] as $media)
                        <div class="swiper-slide">
                            <div class="item-photo" data-src="{{ $media->fileSrc() }}" data-sub-html="<h4>{{ $media->title }}</h4><span>{{ $media->description }}</span>">
                                <div class="thumb-img">
                                    <img src="{{ $media->fileSrc() }}" alt="{{ $media->description }}" title="{{ $media->title }}">
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
            @endif
            <div class="row">
                @if ($data['read']->tags->count() > 0)
                <div class="col-lg-6">
                    <h6>Tags :</h6>
                    <ul class="list-hastag">
                        @foreach ($data['read']->tags as $tag) 
                        <li class="item-hastag">
                            <a href="{{ route('home.search', ['tags' => $tag->tag->name]) }}" title="{!! Str::ucfirst($tag->tag->name) !!}"><span>{!! Str::ucfirst($tag->tag->name) !!}</span></a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="col-lg-6">
                    <div class="share-box mt-0">
                        <h6>@lang('common.share_caption') :</h6>
                        @include('includes.button-share')
                    </div>
                </div>
            </div>
            
        </div>
        @if ($data['latest_post']->count() > 0)
        <div class="box-list">
            <h5 class="my-4">{!! $data['read']->section->fieldLang('name') !!} @lang('common.related_caption')</h5>
            <div class="row">
                
                @foreach ($data['latest_post'] as $latest)  
                <div class="col-md-6">
                    <div class="item-post sm">
                        <a href="{{ route('post.read.'.$latest->section->slug, ['slugPost' => $latest->slug]) }}" class="box-img img-overlay" title="{!! $latest->fieldLang('title') !!}">
                            <div class="thumb-img">
                                <img src="{{ $latest->coverSrc() }}" alt="{{ $latest->cover['alt'] }}" title="{{ $latest->cover['title'] }}">
                            </div>
                        </a>
                        <div class="box-info">
                            <div class="post-info_2">{{ $latest->created_at->format('d F Y') }}</div>
                            <a href="{{ route('post.read.'.$latest->section->slug, ['slugPost' => $latest->slug]) }}" title="{!! $latest->fieldLang('title') !!}">
                                <h6 class="post-title">{!! $latest->fieldLang('title') !!}</h6>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/frontend/js/swiper.min.js') }}"></script>
@endsection

@section('jsbody')
<script>
    //COLLECTION-SLIDER
        var swiper = new Swiper('.gallery-news', {
            slidesPerView: 5,
            spaceBetween: 2,
            speed: 1000,
            autoplay: {
                delay: 2000,
            },
            loop: false,
            breakpoints: {
                // when window width is <= 575.98px
                575.98: {
                    slidesPerView: 3,
                }
            }

        });
</script>
@endsection
