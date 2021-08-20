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
        <div class="share-box">
            <h6>@lang('common.share_caption') :</h6>
            @include('includes.button-share')
        </div>
    </div>
</div>
@endsection
