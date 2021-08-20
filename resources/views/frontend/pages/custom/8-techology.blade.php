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
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <article class="summary-text text-center">
                    {!! $data['read']->fieldLang('content') !!}
                </article>
            </div>
        </div>
        <div class="box-list">
            <div class="row justify-content-center">
                @foreach ($data['childs'] as $child)
                <div class="col-md-6 col-xl-3">
                    <a href="{{ route('page.read.'.$child->slug) }}" class="item-bidang img-overlay {{ $child->colorBidang() }}" title="{!! $child->fieldLang('title') !!}">
                        <div class="title-bidang">
                            <div class="no-bidang">
                                <span>0{{ $loop->iteration }}</span>
                                <span><i class="las la-arrow-right"></i></span>
                            </div>
                            <h6>{!! $child->fieldLang('title') !!}</h6>
                        </div>
                        <div class="thumb-img">
                            <img src="{!! $child->coverSrc() !!}" alt="{{ $child->cover['alt'] }}" title="{{ $child->cover['title'] }}">
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection