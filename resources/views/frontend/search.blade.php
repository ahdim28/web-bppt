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
                            <span>Search</span>
                        </li>
                    </ul>
                    <div class="title-heading text-center">
                        <h1>Hasil Pencarian :</h1>
                        <h5>"<i>{!! !empty(Request::get('keyword')) ? Request::get('keyword') : Request::get('tags') !!}</i>"</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box-wrap">
    <div class="container">
        <div class="row">
            @forelse ($data['posts'] as $item)
            <div class="col-sm-6 col-lg-4">
                <div class="item-post">
                    <a href="{{ route('post.read.'.$item->section->slug, ['slugPost' => $item->slug]) }}" class="box-img img-overlay" title="{!! $item->fieldLang('title') !!}">
                        <div class="box-date">
                            <span class="dd">{{ $item->created_at->format('d') }}</span>
                            <span class="mmyy">{{ $item->created_at->format('F Y') }}</span>
                        </div>
                        <div class="thumb-img">
                            <img src="{{ $item->coverSrc() }}" alt="{{ $item->cover['alt'] }}" title="{{ $item->cover['title'] }}">
                        </div>
                    </a>
                    <div class="box-info">
                        <a href="{{ route('category.read.'.$item->section->slug, ['slugCategory' => $item->category->slug]) }}" class="post-info_2" title="{!! $item->category->fieldLang('name') !!}">
                            {!! $item->category->fieldLang('name') !!}
                        </a>
                        <a href="{{ route('post.read.'.$item->section->slug, ['slugPost' => $item->slug]) }}" title="{!! $item->fieldLang('title') !!}">
                            <h6 class="post-title">{!! $item->fieldLang('title') !!}</h6>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-md-12 text-center">
                <i>
                    <strong style="color:red;">
                        @if (count(Request::query()) > 0)
                        ! @lang('lang.data_attr_not_found', [
                            'attribute' => 'Search'
                        ]) !
                        @else
                        ! @lang('lang.data_attr_empty', [
                            'attribute' => 'Search'
                        ]) !
                        @endif
                    </strong>
                </i>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
