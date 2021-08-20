@extends('layouts.frontend.layout')

@section('content')
<div class="box-wrap single-post">
    <div class="container">
        @include('components.breadcrumbs-frontend')
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
                        <span>{!! $data['creator']!!}</span>
                    </div>
                    <a href="{{ route('category.read.'.$data['read']->section->slug, ['slugCategory' => $data['read']->category->slug]) }}" class="item-info" title="{!! $data['read']->category->fieldLang('name') !!}">
                        <i class="las la-tag"></i>
                        <span>{!! $data['read']->category->fieldLang('name') !!}</span>
                    </a>
                    <div class="item-info">
                        <i class="las la-print"></i>
                        <a href="#!"><span>print<span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-content pt-4">
            <article>
                {!! !empty($data['read']->fieldLang('content')) ? $data['read']->fieldLang('content') : $data['read']->fieldLang('intro') !!}
            </article>
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
    </div>
</div>
@endsection
