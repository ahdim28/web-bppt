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
            <div class="col-lg-8">
                <div class="row justify-content-center">
                    @forelse ($data['posts'] as $item)
                    <div class="col-md-6">
                        <a href="{{ route('post.read.'.$item->section->slug, ['slugPost' => $item->slug]) }}" class="item-innovation" title="{!! $item->fieldLang('title') !!}">
                            <div class="box-img">
                                <div class="thumb-img">
                                    <img src="{{ $item->coverSrc() }}" alt="{{ $item->cover['alt'] }}" title="{{ $item->cover['title'] }}">
                                </div>
                            </div>
                            <div class="innovation-desc">
                                <div class="title-innovation">
                                    <h6>{!! $item->fieldLang('title') !!}</h6>
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
                                    'attribute' => $data['read']->fieldLang('name')
                                ]) !
                                @else
                                ! @lang('lang.data_attr_empty', [
                                    'attribute' => $data['read']->fieldLang('name')
                                ]) !
                                @endif
                            </strong>
                        </i>
                    </div>
                    @endforelse
                </div>
                <div class="box-btn d-flex justify-content-end mt-5">
                    {{ $data['posts']->onEachSide(1)->links('vendor.pagination.frontend') }}
                </div>
            </div>
            <div class="col-lg-3">
                <h5 class="my-3">@lang('common.category_caption')</h5>
                <div class="sidebar-nav">
                    <ul>
                        @foreach ($data['read']->categories as $cat)
                        <li>
                            <a href="{{ route('section.read.'.$data['read']->slug, ['category_id' => $cat->id]) }}" title="{!! $cat->fieldLang('name') !!}">{!! $cat->fieldLang('name') !!}</a>
                        </li>                                
                        @endforeach                            
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection