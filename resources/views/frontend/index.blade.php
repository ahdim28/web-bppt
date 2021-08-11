@extends('layouts.frontend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/frontend/css/swiper.min.css') }}">
@endsection

@section('content')
    @include('frontend.widget.news-selected')
    @include('frontend.widget.pengantar')
    @include('frontend.widget.penugasan')
    @include('frontend.widget.bidang')
    @include('frontend.widget.kecerdasan')
    @include('frontend.widget.static')
    @include('frontend.widget.berita')
    @include('frontend.widget.agenda')
    @include('frontend.widget.link')
@endsection

@section('scripts')
<script src="{{ asset('assets/frontend/js/swiper.min.js') }}"></script>
<script type="text/javascript" src="https://widget.kominfo.go.id/gpr-widget-kominfo.min.js"></script>
@endsection

@section('jsbody')
<script>
    //INTRO-SLIDER
    var introContent = new Swiper('.intro-content-slide', {
        spaceBetween: 10,
        touchRatio: 0.2,
        slideToClickedSlide: true,
        loop: true,
        speed: 1000,
        parallax: true,
        
    });

    var introImage = new Swiper('.intro-img-slide', {
        spaceBetween: 0,
        slidesPerView: 1,
        navigation: {
            nextEl: '.sbn-1',
            prevEl: '.sbp-1',
        },
        loop: true,
        parallax: true,
        effect: 'fade',
        autoplay: {
            delay: 5000,
        },
        speed: 1000,
        breakpoints: {
            // when window width is <= 575.98px
            991.98: {
                draggable: true,
                simulateTouch: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                },
                
            }
            
        }
    });
    
    introContent.controller.control = introImage;
    introImage.controller.control = introContent;

    //COLLECTION-SLIDER
    var swiper = new Swiper('.assignment-slide', {
        slidesPerView: 4,
        spaceBetween: 30,
        slidesPerGroup: 2,
        speed: 1000,
        autoplay: {
            delay: 5000,
        },
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            },
        navigation: {
            nextEl: '.sbn-2',
            prevEl: '.sbp-2',
            },
        breakpoints: {
           
            // when window width is <= 767.98px
            767.98: {
                slidesPerView: 1,
                slidesPerGroup: 1,
            },

            // when window width is <= 1198.98px
            1198.98: {
                slidesPerView: 2,
                slidesPerGroup: 2,
            }
        }

    });
</script>
@endsection
