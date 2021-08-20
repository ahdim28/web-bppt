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
        <div class="event-info" style="width: 100%; padding-left: 20px; border-left: 4px solid var(--c-blue);">
            <div class="event-schedule">
                <div class="item-schedule">
                    <span>@lang('common.start_caption')</span>
                    <div class="point-schedule">
                        <i class="las la-calendar"></i>
                        <div class="data-schedule">
                            <span>{{ $data['event']->start_date->format('d.m.Y') }}</span>
                        </div>
                    </div>
                    <div class="point-schedule">
                        <i class="las la-clock"></i>
                        <div class="data-schedule">
                            <span>{{ $data['event']->start_date->format('H:i A') }}</span>
                        </div>
                    </div>
                </div>
                <div class="item-schedule">
                    <span>@lang('common.end_caption')</span>
                    <div class="point-schedule">
                        <i class="las la-calendar"></i>
                        <div class="data-schedule">
                            <span>{{ $data['event']->end_date->format('d.m.Y') }}</span>
                        </div>
                    </div>
                    <div class="point-schedule">
                        <i class="las la-clock"></i>
                        <div class="data-schedule">
                            <span>{{ $data['event']->end_date->format('H:i A') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="event-schedule my-4">
                <div class="item-schedule" style="padding: 0; margin: 0; border: none;">
                    <span>@lang('common.location_caption')</span>
                    <div class="point-schedule">
                        <i class="las la-map-marker"></i>
                        <div class="data-schedule">
                            <span>{{ $data['event']->location ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <article>
            {!! !empty($data['read']->fieldLang('content')) ? $data['read']->fieldLang('content') : $data['read']->fieldLang('intro') !!}
        </article>
        <div class="share-box">
            <h6>@lang('common.share_caption') :</h6>
            @include('includes.button-share')
        </div>
    </div>
</div>
@endsection