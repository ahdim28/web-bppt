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
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="box-img tall">
                    <div class="thumb-img">
                        <img src="{!! $data['read']->coverSrc('profile') !!}" alt="{!! $data['read']->cover['alt'] !!}" title="{!! $data['read']->cover['title'] !!}">
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="speak-lead">
                    <div class="title-heading">
                        {!! $data['read']->fieldLang('intro') !!}
                    </div>
                    <article>
                        {!! $data['read']->fieldLang('content') !!}
                    </article>
                    <div class="share-box">
                        <h6>@lang('common.share_caption') :</h6>
                        @include('includes.button-share')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
