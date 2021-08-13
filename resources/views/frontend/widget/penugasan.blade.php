@if (!empty($data['penugasan']))
<div class="box-wrap bg-grey">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-8">
                <div class="title-heading">
                    <h5>{!! $config['website_name'] !!}</h5>
                    <h1>{!! $data['penugasan']->fieldLang('title') !!}</h1>
                </div>
                <article class="summary-text">
                    {!! $data['penugasan']->fieldLang('content') !!}
                </article>
                
            </div>
            <div class="col-lg-4">
                <div class="swiper-button-wrapper d-none d-lg-flex justify-content-end align-items-center">
                    <div class="swiper-button-prev swiper-btn sbp-2"><i class="las la-arrow-left"></i></div>
                    <div class="swiper-button-next swiper-btn sbn-2"><i class="las la-arrow-right"></i></div>
                </div>
            </div>
        </div>
        <div class="assignment-slide swiper-container">
            <div class="swiper-wrapper">
                @foreach ($data['penugasan']->childPublish()->orderBy('position', 'ASC')->limit(8)->get() as $penugasan)    
                <div class="swiper-slide">
                    <a href="{{ route('page.read.'.$penugasan->slug) }}" class="item-assignment" title="{!! $penugasan->fieldLang('title') !!}">
                        <div class="box-img img-overlay">
                            <div class="title-assignment">
                                <div class="no-bidang">
                                    <span><i class="las la-arrow-right"></i></span>
                                    <span><i class="las la-arrow-right"></i></span>
                                </div>
                                <h6>{!! $penugasan->fieldLang('title') !!}</h6>
                            </div>
                            <div class="thumb-img">
                                <img src="{{ $penugasan->coverSrc() }}" alt="{{ $penugasan->cover['alt'] }}" title="{{ $penugasan->cover['title'] }}">
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination d-block d-lg-none"></div>
        </div>
    </div>
</div>
@endif