<div class="box-intro">
    <div class="intro-flex">
        <div class="row align-items-center justify-content-between">
            <div class="col-xl-7">
               <div class="title-heading">
                   {!! $data['banner']->fieldLang('description') !!}
               </div>
            </div>
            <div class="col-xl-4">
                @include('includes.search')
                <div class="box-badge">
                    <img src="{!! $config['logo_2'] !!}" alt="Logo BPPT" title="Logo BPPT">
                </div>
           </div>
       </div>
    </div>
    <div class="intro-slide swipper-container">
        <div class="swiper-wrapper">
            @forelse ($data['banner']->bannerPublish(1)->get() as $banner)
            <div class="swiper-slide">
                <div class="item-slide">
                    <div class="thumb-img">
                        <img src="{!! $banner->fileSrc()['image'] !!}" alt="{{ $banner->alt }}" title="{!! $banner->fieldLang('title') !!}">
                    </div>
                </div>
            </div>
            @empty
            <div class="swiper-slide">
                <div class="item-slide">
                    <div class="thumb-img">
                        <img src="{!! $config['banner_default'] !!}" alt="Banner default" title="Banner Default">
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>