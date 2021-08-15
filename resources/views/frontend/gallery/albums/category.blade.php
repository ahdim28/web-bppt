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
                            <a href="{{ route('gallery.photo') }}">
                                <span>@lang('common.photo_caption')</span>
                            </a>
                        </li>
                        <li class="item-breadcrumb">
                            <span>{!! Str::limit($data['read']->fieldLang('name'), 30) !!}</span>
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
        <div class="row justify-content-center">
            @forelse ($data['albums'] as $item)
            <div class="col-md-4">
                <a href="{{ route('gallery.photo.category.album', ['slugAlbum' => $item->slug, 'slugCategory' => $item->category->slug]) }}" class="item-album" title="{!! $item->fieldLang('name') !!}">
                    <div class="cover-album">
                        <div class="amount-album">
                            <i class="las la-image"></i>
                            <span>{{ $item->photos->count() }} Foto</span>
                        </div>
                        <div class="box-img img-overlay">
                            <div class="thumb-img">
                                <img src="{{ $item->photoCover($item->id) }}" alt="">
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
                            'attribute' => 'Album'
                        ]) !
                        @else
                        ! @lang('lang.data_attr_empty', [
                            'attribute' => 'Album'
                        ]) !
                        @endif
                    </strong>
                </i>
            </div>
            @endforelse
        </div>
        <div class="box-btn d-flex justify-content-end">
            {{ $data['albums']->onEachSide(1)->links('vendor.pagination.frontend') }}
        </div>
    </div>
</div>
@endsection