@extends('layouts.frontend.layout')

@section('content')
<div class="banner-breadcrumb">
    <div class="bg-breadcrumb"> 
    </div>
    <div class="flex-breadcrumb">
        <div class="row justify-content-between">
            <div class="col-xl-7">
                @include('components.breadcrumbs-frontend')
            </div>
            <div class="col-xl-4">
                @include('includes.search')
            </div>
        </div>
    </div>
</div>
<div class="box-wrap">
    <div class="container">
        <article>
            @if (!empty($data['read']->cover['file_path']))
            <img src="{{ $data['read']->coverSrc() }}" alt="{{ $data['read']->cover['alt'] }}" title="{{ $data['read']->cover['title'] }}">
            @endif
            <strong>{!! $data['read']->fieldLang('title') !!}</strong>
            {!! !empty($data['read']->fieldLang('content')) ? $data['read']->fieldLang('content') : $data['read']->fieldLang('intro') !!}
        </article>
        <div class="share-box">
            <h6>@lang('common.share_caption') :</h6>
            @include('includes.button-share')
        </div>
    </div>
    @if ($data['latest_post']->count() > 0)
    <div class="container">
        <h5 class="mt-4">{!! $data['read']->section->fieldLang('name') !!} @lang('common.other')</h5>
        <div class="row">
            @foreach ($data['latest_post']->take(3) as $latest)  
            <div class="col-md-6 col-xl-4">
                <a href="{{ route('post.read.'.$latest->section->slug, ['slugPost' => $latest->slug]) }}" class="item-innovation" title="{!! $latest->fieldLang('title') !!}">
                    <div class="box-img">
                        <div class="thumb-img">
                            <img src="{{ $latest->coverSrc() }}" alt="{{ $latest->cover['alt'] }}" title="{{ $latest->cover['title'] }}">
                        </div>
                    </div>
                    <div class="innovation-desc">
                        <div class="title-innovation">
                            <h6>{!! $latest->fieldLang('title') !!}</h6>
                        </div>
                    </div>
                    
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection