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
        <article>
            {!! $data['read']->fieldLang('content') !!}
        </article>
        <div class="title-heading text-center">
            {!! $data['read']->fieldLang('intro') !!}
        </div>
        <div class="box-list">
            <div class="row justify-content-center">
                @foreach ($data['medias'] as $item)
                <div class="col-md-6 col-lg-3">
                    <div class="item-lead">
                        <div class="box-img tall">
                            <div class="thumb-img">
                                <img src="{!! $item->fileSrc() !!}" alt="photo" title="">
                            </div>
                            <div class="box-board">
                                {{ $item->caption['description'] }}
                            </div>
                        </div>
                        <div class="box-info">
                            <h6>{{ $item->caption['title'] }}</h6>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
