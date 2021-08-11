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
                            <a href="{{ route('gallery.album.list') }}">
                                <span>@lang('common.photo_caption')</span>
                            </a>
                        </li>
                        <li class="item-breadcrumb">
                            <span>{!! $data['read']->fieldLang('name') !!}</span>
                        </li>
                    </ul>
                    <div class="title-heading text-center">
                        <h1>{!! $data['read']->fieldLang('name') !!}</h1>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box-wrap">
    <div class="container">
        <div class="list-photo">
            
            @forelse ($data['photo'] as $item)
            <div class="item-photo" data-src="{{ $item->photoSrc() }}" data-sub-html="<h4>{!! $item->fieldLang('title') !!}</h4><span>{!! strip_tags($item->fieldLang('description')) !!}</span>">
                <div class="thumb-img">
                    <img src="{{ $item->photoSrc() }}" alt="{!! $item->fieldLang('title') !!}" title="{{ $item->alt }}">
                </div>
            </div>
            @empty
            <i class="text-center">
                <strong style="color:red;">
                    @if (count(Request::query()) > 0)
                    ! @lang('lang.data_attr_not_found', [
                        'attribute' => 'Photo'
                    ]) !
                    @else
                    ! @lang('lang.data_attr_empty', [
                        'attribute' => 'Photo'
                    ]) !
                    @endif
                </strong>
            </i>
            @endforelse
            
        </div>
    </div>
</div>
@endsection
