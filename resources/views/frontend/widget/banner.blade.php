<div class="box-intro">
    <div class="sg-intro">
        <img src="{{ asset('assets/frontend/images/sg-sm.svg') }}" alt="Banner" title="Banner">
    </div>
    <div class="intro-flex">
        <div class="container">
            <div class="intro-content">
                <div class="swiper-container intro-content-slide">
                    <div class="swiper-wrapper">

                        @forelse ($data['news_selected'] as $selected)
                        <div class="swiper-slide">
                            <div class="box-intro-content">
                                <a href="{{ route('post.read.'.$selected->section->slug, ['slugPost' => $selected->slug]) }}" title="{!! $selected->fieldLang('title') !!}">
                                    <div class="title-heading" >
                                        <h1>{!! $selected->fieldLang('title') !!}</h1>
                                    </div>
                                </a>
                                <artilce class="summary-text">
                                    {!! Str::limit($selected->fieldLang('content'), 250) !!}
                                </artilce>
                                <div class="box-btn">
                                    <a href="{{ route('post.read.'.$selected->section->slug, ['slugPost' => $selected->slug]) }}" class="btn btn-main" title="@lang('common.more')"><span>@lang('common.more')</span></a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="swiper-slide">
                            <div class="box-intro-content">
                                <a href="">
                                    <div class="title-heading" >
                                        <h1>BPPT Luncurkan Prototype PUNA MALE Elang Hitam</h1>
                                    </div>
                                </a>
                                <artilce class="summary-text">
                                   <p>Inovasi dalam bidang pertahanan ini dihadirkan melalui pengembangan Pesawat Udara Nir Awak (PUNA) atau Drone, tipe Medium Altitude Long Endurance (MALE) atau disebut PUNA MALE.</p>
                                </artilce>
                                <div class="box-btn">
                                    <a href="" class="btn btn-main"><span>Selengkapnya</span></a>
                                </div>
                            </div>
                        </div>
                        @endforelse
                        
                    </div>
                </div>
                
            </div>
        </div>
        <div class="intro-img">
            <div class="box-intro-img">
                <div class="swiper-container intro-img-slide">
                    <div class="swiper-wrapper">

                        @forelse ($data['news_selected'] as $selected)
                        <div class="swiper-slide">
                            <div class="box-intro-img-slide img-overlay">
                                <div class="thumb-img">
                                    <img src="{{ $selected->coverSrc() }}" alt="{{ $selected->cover['alt'] }}" title="{{ $selected->cover['title'] }}">
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="swiper-slide">
                            <div class="box-intro-img-slide img-overlay">
                                <div class="thumb-img">
                                    <img src="{{ asset('assets/frontend/images/inovasi-tech.jpg') }}" alt="">
                                </div>
                            </div>
                        </div>
                        @endforelse
                        
                    </div>
                </div>
            </div>
            <div class="swiper-button-wrapper">
                <div class="swiper-button-prev swiper-btn skew sbp-1"><i class="las la-arrow-left"></i></div>
                <div class="swiper-button-next swiper-btn skew sbn-1"><i class="las la-arrow-right"></i></div>
            </div>
        </div>
        <div class="box-scroll-down">
            <div class="container">
                <a href="#next-scroll" class="scroll-down page-scroll" id="btn-scroll" title="@lang('common.scroll_caption')">
                    <i class="las la-mouse"></i>
                    <span>@lang('common.scroll_caption')</span>
                </a>
            </div>
        </div>
    </div>
</div>