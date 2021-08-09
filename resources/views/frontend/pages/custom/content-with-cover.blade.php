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
                            <a href="{{ route('home') }}" title="@lang('common.home')">
                                <i class="las la-home"></i><span>@lang('common.home')</span>
                            </a>
                        </li>
                        <li class="item-breadcrumb">
                            <span>{!! $data['read']->fieldLang('title') !!}</span>
                        </li>
                    </ul>
                    <div class="title-heading text-center">
                        <h1>{!! $data['read']->fieldLang('title') !!}</h1>
                    </div>
                </div>
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
                        <img src="{!! $data['read']->coverEmpty() !!}" alt="cover images" title="cover images">
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
                    @include('includes.button-share')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
