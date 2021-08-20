   <div class="box-wrap bg-grey">
    <div class="container-fluid">
        <div class="row">
            @if (!empty($data['artificial']) && $data['artificial']->publish == 1)   
            <div class="col-md-12">
                <div class="bg-pd-ai">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-lg-5">
                            <div class="box-content-ai">
                                <div class="title-heading text-white">
                                    <h1>{!! $data['artificial']->fieldLang('title') !!}</h1>
                                </div>
                                <article class="summary-text text-white">
                                    {!! Str::limit($data['artificial']->fieldLang('content'), 280) !!}
                                </article>
                                <div class="box-btn mt-5">
                                    <a href="{{ route('page.read.'.$data['artificial']->slug) }}" class="btn btn-main" title="@lang('common.view_more')"><span>@lang('common.view_more')</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="box-img-ai">
                                <img src="{{ $data['artificial']->coverSrc() }}" alt="{{ $data['artificial']->cover['alt'] }}" title="{{ $data['artificial']->cover['title'] }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if (!empty($data['p3dn']) && $data['p3dn']->publish == 1)   
            <div class="col-md-6">
                <div class="item-program p3dn">
                    <div class="bg-program">
                        <img src="{{ asset('assets/frontend/images/globe-white.png') }}" alt="Globe White" title="Globe White">
                    </div>
                    <div class="content-program">
                        <div class="title-heading text-white">
                            <h2>{!! $data['p3dn']->fieldLang('title') !!}</h2>
                        </div>
                        <a href="{{ route('page.read.'.$data['p3dn']->slug) }}" class="btn btn-text text-white" title="@lang('common.view_more')"><span>@lang('common.view_more')</span></a>
                    </div>
                    <div class="ilustration-program">
                        <img src="{{ $data['p3dn']->coverSrc() }}" alt="{{ $data['p3dn']->cover['alt'] }}" title="{{ $data['p3dn']->cover['title'] }}">
                    </div>
                </div>
            </div>
            @endif
            @if (!empty($data['digital']) && $data['digital']->publish == 1)   
            <div class="col-md-6">
                <div class="item-program digital">
                    <div class="bg-program">
                        <img src="{{ asset('assets/frontend/images/globe-white.png') }}" alt="Globe White" title="Globe White">
                    </div>
                    <div class="content-program">
                        <div class="title-heading text-white">
                            <h2>{!! $data['digital']->fieldLang('title') !!}</h2>
                        </div>
                        <a href="{{ route('page.read.'.$data['digital']->slug) }}" class="btn btn-text text-white" title="@lang('common.view_more')"><span>@lang('common.view_more')</span></a>
                    </div>
                    <div class="ilustration-program">
                        <img src="{{ $data['digital']->coverSrc() }}" alt="{{ $data['digital']->cover['alt'] }}" title="{{ $data['digital']->cover['title'] }}">
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>