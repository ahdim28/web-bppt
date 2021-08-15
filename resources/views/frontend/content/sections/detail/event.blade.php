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
                            <a href="{{ route('section.read.'.$data['read']->section->slug) }}" title="{!! $data['read']->section->fieldLang('name') !!}">
                                <span>{!! Str::limit($data['read']->section->fieldLang('name'), 30) !!}</span>
                            </a>
                        </li>
                        <li class="item-breadcrumb">
                            <span>{!! Str::limit($data['read']->fieldLang('title'), 30) !!}</span>
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
        <div class="event-info" style="width: 100%; padding-left: 20px; border-left: 4px solid var(--c-blue);">
            <div class="event-schedule">
                <div class="item-schedule">
                    <span>Mulai</span>
                    <div class="point-schedule">
                        <i class="las la-calendar"></i>
                        <div class="data-schedule">
                            <span>{{ $data['read']->event->start_date->format('d.m.Y') }}</span>
                        </div>
                    </div>
                    <div class="point-schedule">
                        <i class="las la-clock"></i>
                        <div class="data-schedule">
                            <span>{{ $data['read']->event->start_date->format('H:i A') }}</span>
                        </div>
                    </div>
                </div>
                <div class="item-schedule">
                    <span>Selesai</span>
                    <div class="point-schedule">
                        <i class="las la-calendar"></i>
                        <div class="data-schedule">
                            <span>{{ $data['read']->event->end_date->format('d.m.Y') }}</span>
                        </div>
                    </div>
                    <div class="point-schedule">
                        <i class="las la-clock"></i>
                        <div class="data-schedule">
                            <span>{{ $data['read']->event->end_date->format('H:i A') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="event-schedule my-4">
                <div class="item-schedule" style="padding: 0; margin: 0; border: none;">
                    <span>Tempat</span>
                    <div class="point-schedule">
                        <i class="las la-map-marker"></i>
                        <div class="data-schedule">
                            <span>{!! $data['read']->event->location ?? '-' !!}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <article>
            {!! $data['read']->fieldLang('content') !!}
        </article>
        <div class="share-box">
            <h6>@lang('common.share_caption') :</h6>
            @include('includes.button-share')
        </div>
    </div>
</div>
@endsection
