@if (!empty($data['technology']) && $data['technology']->publish == 1)   
<div class="box-wrap">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="title-heading text-center">
                    <h1>{!! $data['technology']->fieldLang('title') !!}</h1>
                </div>
                <article class="summary-text text-center">
                    {!! Str::limit($data['technology']->fieldLang('content'), 280) !!}
                </article>
            </div>
        </div>
        <div class="box-list">
            <div class="row justify-content-center">
                @foreach ($data['technology']->childPublish()->orderBy('position', 'ASC')->limit(8)->get() as $tech)
                <div class="col-md-6 col-xl-3">
                    <a href="{{ route('page.read.'.$tech->slug) }}" class="item-bidang img-overlay {{ $tech->colorBidang() }}" title="{!! $tech->fieldLang('title') !!}">
                        <div class="title-bidang">
                            <div class="no-bidang">
                                <span>0{{ $loop->iteration }}</span>
                                <span><i class="las la-arrow-right"></i></span>
                            </div>
                            <h6>{!! $tech->fieldLang('title') !!}</h6>
                        </div>
                        <div class="thumb-img">
                            <img src="{!! $tech->coverSrc() !!}" alt="{{ $tech->cover['alt'] }}" title="{{ $tech->cover['title'] }}">
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif