@extends('layouts.frontend.layout')

@section('content')
<div class="banner-breadcrumb">
    <div class="bg-breadcrumb"> 
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="box-breadcrumb">
                    <div class="title-heading text-center">
                        <h1>{!! $data['read']->fieldLang('name') !!}</h1>
                    </div>
                    <a href="{{ route('home') }}" class="btn-back" title="@lang('common.back_home')">
                        <i class="las la-home"></i><span>@lang('common.back_home')</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box-wrap">
    <div class="container">
        <div class="box-list">
            <div class="row justify-content-center">
                @foreach ($data['posts'] as $item)   
                <div class="col-md-6 col-lg-4">
                    <div class="item-lead">
                        <div class="box-img tall">
                            <div class="thumb-img">
                                <img src="{!! $item->coverEmpty() !!}" alt="">
                            </div>
                            <div class="box-board">
                                {!! $item->profile->fields['position'] !!}
                            </div>
                        </div>
                        <div class="box-info">
                            <h6>{{ $item->fieldLang('title') }}</h6>
                            <span class="boxmail">{!! $item->profile->fields['email'] !!}</span>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
@endsection
