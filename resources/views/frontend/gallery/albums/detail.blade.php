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
        <div class="row justify-content-start">
            <div class="col-lg-10">
                <div class="box-narration">
                    <article>
                        {!! $data['read']->fieldLang('description') !!}
                    </article>
                </div>
            </div>
        </div>
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
