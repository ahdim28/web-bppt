@extends('layouts.frontend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/frontend/css/swiper.min.css') }}">
@endsection

@section('content')
    @include('frontend.widget.banner')
    @include('frontend.widget.inovation')
    @include('frontend.widget.technology')
    @include('frontend.widget.artificial')
    @include('frontend.widget.news')
    @include('frontend.widget.link')
@endsection

@section('scripts')
<script src="{{ asset('assets/frontend/js/swiper.min.js') }}"></script>
@endsection

@section('jsbody')
<script>
    //COLLECTION-SLIDER
    var swiper = new Swiper('.intro-slide', {
        slidesPerView: 1,
        spaceBetween: 0,
        speed: 1500,
        effect: 'fade',
        autoplay: {
            delay: 7000,
        },
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            },
        navigation: {
            nextEl: '.sbn-2',
            prevEl: '.sbp-2',
            },
    });
</script>
@endsection
