@if (!empty($data['p3dn']) || !empty($data['digital']))
<div class="box-wrap" style="padding: 2em 0;">
    <div class="container">
        <div class="row">
            @if (!empty($data['p3dn']))
            <div class="col-md-6">
                <div class="item-program p3dn">
                    <div class="bg-program">
                        <img src="{{ asset('assets/frontend/images/globe-white.png') }}" alt="Globe" title="Globe">
                    </div>
                    <div class="content-program">
                        <div class="title-heading text-white">
                            <h4>{!! $data['p3dn']->fieldLang('title') !!}</h4>
                        </div>
                        <a href="{{ route('page.read.'.$data['p3dn']->slug) }}" class="btn btn-text text-white" title="@lang('common.more')</"><span>@lang('common.more')</span></a>
                    </div>
                    <div class="ilustration-program">
                        <img src="{{ $data['p3dn']->coverSrc() }}" alt="{{ $data['p3dn']->cover['alt'] }}" title="{{ $data['p3dn']->cover['title'] }}">
                    </div>
                </div>
            </div>
            @endif
            @if (!empty($data['digital']))
            <div class="col-md-6">
                <div class="item-program digital">
                    <div class="bg-program">
                        <img src="{{ asset('assets/frontend/images/globe-white.png') }}" alt="Globe" title="Globe">
                    </div>
                    <div class="content-program">
                        <div class="title-heading text-white">
                            <h4>{!! $data['digital']->fieldLang('title') !!}</h4>
                        </div>
                        <a href="{{ route('page.read.'.$data['digital']->slug) }}" class="btn btn-text text-white" title="@lang('common.more')</"><span>@lang('common.more')</span></a>
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
@endif