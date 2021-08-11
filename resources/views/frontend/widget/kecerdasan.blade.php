@if (!empty($data['kecerdasan']))    
<div class="box-wrap p-0 bg-ai">
    <div class="container">
        <div class="bg-pd-ai">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-4">
                    <div class="box-content-ai">
                        <div class="title-heading text-white">
                            <h5>{!! $config['website_name'] !!}</h5>
                            <h1>{!! $data['kecerdasan']->fieldLang('title') !!}</h1>
                        </div>
                        <article class="summary-text text-white">
                            {!! Str::limit($data['kecerdasan']->fieldLang('content'), 275) !!}
                        </article>
                        <div class="box-btn mt-5">
                            <a href="{{ route('page.read.'.$data['kecerdasan']->slug) }}" class="btn btn-main" title="@lang('common.more')"><span>@lang('common.more')</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="box-img-ai">
                        <img src="{{ $data['kecerdasan']->coverSrc() }}" alt="{{ $data['kecerdasan']->cover['alt'] }}" title="{{ $data['kecerdasan']->cover['title'] }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif