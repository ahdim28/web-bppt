@if (!empty($data['link']))    
<div class="box-wrap bg-blue">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-3">
                <div class="title-heading text-white">
                    <h5>{!! $config['website_name'] !!}</h5>
                    <h1>{!! $data['link']->fieldLang('name') !!}</h1>
                </div>
                <article class="text-summmary text-white">
                </article>
            </div>
            <div class="col-lg-8">
                <div class="row align-items-center justify-content-around">
                    @foreach ($data['link']->medias()->orderBy('position', 'ASC')->limit(4)->get() as $link)
                    <div class="col-6 col-lg-3">
                        <a href="{{ $link->url }}" class="item-partner" target="_blank" title="{{ $link->fieldLang('title') }}">
                            <img src="{{ $link->coverSrc() }}" alt="{{ $link->cover['alt'] }}" title="{{ $link->cover['title'] }}">
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif