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
        <article>
            {!! $data['read']->fieldLang('content') !!}
        </article>
        <div class="title-heading text-center">
            {!! $data['read']->fieldLang('intro') !!}
        </div>
        <div class="box-list">
            <div class="row justify-content-center">
                @foreach ($data['medias'] as $item)
                <div class="col-md-6 col-lg-3">
                    <div class="item-lead">
                        <div class="box-img tall">
                            <div class="thumb-img">
                                <img src="{!! $item->fileSrc() !!}" alt="{{ $item->caption['description'] }}" title="{{ $item->caption['title'] }}">
                            </div>
                            <div class="box-board">
                                {{ $item->caption['description'] }}
                            </div>
                        </div>
                        <div class="box-info">
                            <h6>{{ $item->caption['title'] }}</h6>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
