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
                            <span>@lang('common.photo_caption')</span>
                        </li>
                    </ul>
                    <div class="title-heading text-center">
                        <h1>@lang('common.gallery_caption') @lang('common.photo_caption')</h1>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box-wrap">
    <div class="container">
        <div class="row justify-content-center">
            @forelse ($data['categories'] as $item)
            <div class="col-md-4">
                <a href="{{ route('gallery.photo.category', ['slugCategory' => $item->slug]) }}" class="item-album" title="{!! $item->fieldLang('name') !!}">
                    <div class="cover-album">
                        <div class="amount-album">
                            <i class="las la-image"></i>
                            <span>{{ $item->albums->count() }} Album</span>
                        </div>
                        <div class="box-img img-overlay">
                            <div class="thumb-img">
                                <img src="{{ $item->albums->first()->photoCover($item->albums->first()->id) }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="album-desc">
                        <div class="title-album">
                            <h6>{!! $item->fieldLang('name') !!}</h6>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-md-12 text-center">
                <i>
                    <strong style="color:red;">
                        @if (count(Request::query()) > 0)
                        ! @lang('lang.data_attr_not_found', [
                            'attribute' => 'Category'
                        ]) !
                        @else
                        ! @lang('lang.data_attr_empty', [
                            'attribute' => 'Category'
                        ]) !
                        @endif
                    </strong>
                </i>
            </div>
            @endforelse
        </div>
        <div class="box-btn d-flex justify-content-end">
            {{ $data['categories']->onEachSide(1)->links('vendor.pagination.frontend') }}
        </div>
    </div>
</div>
@endsection