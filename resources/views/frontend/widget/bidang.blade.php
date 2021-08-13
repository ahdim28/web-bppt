@if (!empty($linkModule['fields']))    
<div class="box-wrap">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="title-heading text-center">
                    <h5>{!! $config['website_name'] !!}</h5>
                    {!! $linkModule['fields']->fieldLang('intro') !!}
                </div>
                <article class="summary-text text-center">
                    {!! $linkModule['fields']->fieldLang('content') !!}
                </article>
            </div>
        </div>
        <div class="box-list">
            <div class="row justify-content-center">
                @foreach ($linkModule['fields']->childPublish()->orderBy('position', 'ASC')->limit(8)->get() as $key => $bidang)
                <div class="col-md-6 col-xl-3">
                    <a href="{{ route('page.read.'.$bidang->slug) }}" class="item-bidang img-overlay {{ $bidang->colorBidang() }}" title="{!! $bidang->fieldLang('title') !!}">
                        <div class="title-bidang">
                            <div class="no-bidang">
                                <span>0{{ ($key+1) }}</span>
                                <span><i class="las la-arrow-right"></i></span>
                            </div>
                            <h6>{!! $bidang->fieldLang('title') !!}</h6>
                        </div>
                        <div class="thumb-img">
                            <img src="{!! $bidang->coverSrc() !!}" alt="{{ $bidang->cover['alt'] }}" title="{{ $bidang->cover['title'] }}">
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif