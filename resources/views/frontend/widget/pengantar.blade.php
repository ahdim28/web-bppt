@if (!empty($data['pengantar']))
<div class="box-wrap" id="next-scroll">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-6">
                <div class="box-lead">
                    <div class="sg-white">
                        <img src="images/sg-white.svg" alt="">
                    </div>
                    <div class="content-lead">
                        <span>@lang('common.kepala_bppt_caption')</span>
                        <h6>{!! $config['kepala_bppt'] !!}</h6>
                    </div>
                    <img src="{{ $data['pengantar']->bannerSrc() }}" alt="{!! $config['kepala_bppt'] !!}" title="{!! $config['kepala_bppt'] !!}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="speak-lead">
                    <div class="title-heading">
                        <h5>@lang('common.welcome_caption')</h5>
                        {!! $data['pengantar']->fieldLang('intro') !!}
                    </div>
                    <article class="summary-text">
                        {!! Str::limit($data['pengantar']->fieldLang('content'), 450) !!}
                    </article>
                    <div class="box-btn mt-5">
                        <a href="{{ route('page.read.'.$data['pengantar']->slug) }}" class="btn btn-main" title=">@lang('common.more')"><span>@lang('common.more')</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif