<footer>
    <div class="footer-content">
        <div class="container">
            <div class="row justify-content-between">
                
                <div class="col-md-6 col-lg-3">
                    <div class="f-widget">
                        <h5 class="mb-4">@lang('common.gallery_caption') @lang('common.photo_caption')</h5>
                        <div class="box-list">
                            <div class="list-photo">
                                @foreach ($linkModule['photos'] as $photo)
                                <div class="item-photo" data-src="{{ $photo->photoSrc() }}" data-sub-html="<h4>{!! $photo->fieldLang('title') !!}</h4><span>{!! strip_tags($photo->fieldLang('description')) !!}</span>">
                                    <div class="thumb-img">
                                        <img src="{{ $photo->photoSrc() }}" alt="{{ $photo->alt }}" title="{!! $photo->fieldLang('title') !!}">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="box-btn d-flex justify-content-end mt-3">
                                <a href="{{ route('gallery.photo') }}" class="btn btn-text" title="@lang('common.view_more')"><span>@lang('common.view_more')</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 ">
                    <div class="f-widget mb-0">
                        <h5 class="mb-4">Tweets By ‎@BPPT_RI</h5>
                        <div class="f-widget">
                            <a class="twitter-timeline" 
                                data-height="425" 
                                data-theme="light" 
                                data-chrome="noheader nofooter" 
                                href="{!! $config['twitter'] !!}?ref_src=twsrc%5Etfw" title="Tweets by BPPT_RI">
                                Tweets by BPPT_RI
                            </a> 
                            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> 
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="f-widget">
                        <h5 class="mb-4">@lang('common.follow_caption')</h5>
                        <ul class="f-social">
                            <li><a href="{!! $config['facebook'] !!}" target="_blank" title="Facebook BPPT"><i class="lab la-facebook-f"></i></a></li>
                            <li><a href="{!! $config['twitter'] !!}" target="_blank" title="Twitter BPPT"><i class="lab la-twitter"></i></a></li>
                            <li><a href="{!! $config['instagram'] !!}" target="_blank" title="Instagram BPPT"><i class="lab la-instagram"></i></a></li>
                            <li><a href="{!! $config['youtube'] !!}" target="_blank" title="Youtube BPPT"><i class="lab la-youtube"></i></a></li>
                        </ul>
                    </div>
                    <div class="f-widget">
                        <h5 class="mb-4">@lang('common.quick_caption')</h5>
                        <ul class="f-flex">
                            @foreach ($menu['quick']->getMenu(3) as $quick)
                            @php
                                $modQuick = $quick->modMenu();
                            @endphp
                            <li>
                                <a href="{{ $modQuick['routes'] }}" 
                                    class="{{ $quick->attr['target_blank'] == 1 ? 'outlink' : '' }}"
                                    title="{!! $modQuick['title'] !!}" 
                                    target="{{ $quick->attr['target_blank'] == 1 ? '_blank' : '' }}">
                                    {!! $modQuick['title'] !!}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    
                </div>
                <div class="col-md-6 col-lg-3 ">
                    <div class="f-widget mb-0">
                        <h5 class="mb-4">{!! $linkModule['contact']->fieldLang('name') !!}</h5>
                        <ul>
                            <li>
                               <span>@lang('common.address_caption')</span>
                               {!! $config['address'] !!}
                            </li>
                            <li>
                                <span>@lang('common.phone_caption')</span>
                                {!! $config['phone'] !!}
                             </li>
                             <li>
                                <span>@lang('common.fax_caption')</span>
                                {!! $config['fax'] !!}
                             </li>
                            <li>
                                <span>@lang('common.email_caption')</span>
                                <a href="mailto:{!! $config['email'] !!}" title="{!! $config['email'] !!}">{!! $config['email'] !!}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright text-center">
           <strong>© {{ now()->format('Y') }} @lang('common.copyright')</strong>
        </div>
    </div>
</footer>