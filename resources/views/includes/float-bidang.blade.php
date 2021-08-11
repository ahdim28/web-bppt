@if (!empty($linkModule['fields']))
<div class="float-bidang">
    <div class="close-toggle-bidang">
        <i class="las la-times"></i>
    </div>
    @foreach ($linkModule['fields']->childPublish()->orderBy('position', 'ASC')->limit(8)->get() as $key => $bidang)
    <div class="item-float-bidang">
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
@endif