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
        <div class="box-list">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="row">
                        @forelse ($data['posts'] as $item)  
                        <div class="col-lg-6">
                            <a href="{{ route('post.read.'.$item->section->slug, ['slugPost' => $item->slug]) }}" class="item-event" title="{!! $item->fieldLang('title') !!}">
                                <div class="event-date">
                                    <span class="event-dd">{{ $item->created_at->format('d') }}</span>
                                    <span class="event-mm">{{ $item->created_at->format('M') }}</span>
                                </div>
                                <div class="event-info">
                                    <h6 class="event-title">{!! $item->fieldLang('title') !!}</h6>
                                    <div class="event-schedule">
                                        <div class="item-schedule">
                                            <span>@lang('common.start_caption')</span>
                                            <div class="point-schedule">
                                                <i class="las la-calendar"></i>
                                                <div class="data-schedule">
                                                    <span>{{ $item->event->start_date->format('d.m.Y') }}</span>
                                                </div>
                                            </div>
                                            <div class="point-schedule">
                                                <i class="las la-clock"></i>
                                                <div class="data-schedule">
                                                    <span>{{ $item->event->start_date->format('H:i A') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-schedule">
                                            <span>@lang('common.end_caption')</span>
                                            <div class="point-schedule">
                                                <i class="las la-calendar"></i>
                                                <div class="data-schedule">
                                                    <span>{{ $item->event->end_date->format('d.m.Y') }}</span>
                                                </div>
                                            </div>
                                            <div class="point-schedule">
                                                <i class="las la-clock"></i>
                                                <div class="data-schedule">
                                                    <span>{{ $item->event->end_date->format('H:i A') }}</span>
                                                </div>
                                            </div>
                                        </div>
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
                </div>
            </div>
        </div>
        <div class="box-btn d-flex justify-content-end">
            {{ $data['posts']->onEachSide(1)->links('vendor.pagination.frontend') }}
        </div>
    </div>
</div>
@endsection