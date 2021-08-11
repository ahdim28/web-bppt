@extends('layouts.frontend.layout')

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
                    <a href="{{ route('section.read.'.$data['read']->section->slug) }}">
                        <span>{!! $data['read']->section->fieldLang('name') !!}</span>
                    </a>
                </li>
                <li class="item-breadcrumb">
                    <span>{!! $data['read']->fieldLang('title') !!}</span>
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
                        <span>{{ $data['read']->createBy->name }}</span>
                    </div>
                    <a href="{{ route('section.read.'.$data['read']->section->slug) }}" class="item-info">
                        <i class="las la-tag"></i>
                        <span>{!! $data['read']->section->fieldLang('name') !!}</span>
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
                {!! $data['read']->fieldLang('content') !!}
            </article>
            <div class="row">
                <div class="col-lg-6">
                    <h6>Tags :</h6>
                    <ul class="list-hastag">
                        @foreach ($data['read']->tags as $tag)
                        <li class="item-hastag"><a href="#!"><span>{{ $tag->tag->name }}</span></a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-6">
                    @include('includes.button-share')
                </div>
            </div>
            
        </div>
        
    </div>
</div>
@endsection