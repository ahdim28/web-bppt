<footer>
    <div class="footer-content">
        <div class="container">
            <div class="row justify-content-between">
                
                <div class="col-lg-3">
                    <div class="f-widget">
                        <h5 class="mb-4">@lang('common.gallery_caption') @lang('common.photo_caption')</h5>
                        <div class="box-list">
                            <div class="list-photo">
                                @foreach ($linkModule['photos'] as $photo)
                                <div class="item-photo" 
                                    data-src="{{ $photo->photoSrc() }}" 
                                    data-sub-html="<h4>{!! $photo->fieldLang('title') !!}</h4><span>{!! strip_tags($photo->fieldLang('description')) !!}</span>">
                                    <div class="thumb-img">
                                        <img src="{{ $photo->photoSrc() }}" alt="{{ $photo->alt }}" title="{!! $photo->fieldLang('title') !!}">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="box-btn d-flex justify-content-end mt-3">
                                <a href="{{ route('gallery.photo') }}" class="btn btn-text" title="@lang('common.gallery_caption') @lang('common.photo_caption') @lang('common.other')"><span>@lang('common.gallery_caption') @lang('common.photo_caption') @lang('common.other')</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 ">
                    <div class="f-widget mb-0">
                        <h5 class="mb-4">Tweets By ‎@BPPT_RI</h5>
                        <a class="twitter-timeline" title="Tweets by BPPT_R" data-height="400" data-theme="light" data-chrome="noheader nofooter" href="{!! $config['twitter'] !!}?ref_src=twsrc%5Etfw">Tweets by BPPT_RI</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> 
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="f-widget">
                        <h5 class="mb-4">@lang('common.follow_us_caption')</h5>
                        <ul class="f-social">
                            <li><a href="{!! $config['facebook'] !!}" title="Facebook BPPT" target="_blank"><i class="lab la-facebook-f"></i></a></li>
                            <li><a href="{!! $config['twitter'] !!}" title="Twitter BPPT" target="_blank"><i class="lab la-twitter"></i></a></li>
                            <li><a href="{!! $config['instagram'] !!}" title="Instagram BPPT" target="_blank"><i class="lab la-instagram"></i></a></li>
                            <li><a href="{!! $config['youtube'] !!}" title="Youtube BPPT" target="_blank"><i class="lab la-youtube"></i></a></li>
                        </ul>
                    </div>
                    <div class="f-widget">
                        <h5 class="mb-4">@lang('common.quick_link_caption')</h5>
                        <ul class="f-flex">
                            @foreach ($menu['quick_link']->getMenu(2) as $menuLink)
                            @php
                                $modLink = $menuLink->modMenu();
                            @endphp
                            <li>
                                <a href="{{ $modLink['routes'] }}" 
                                    class="{{ $menuLink->attr['target_blank'] == 1 ? 'outlink' : '' }}"
                                    title="{!! $modLink['title'] !!}" 
                                    target="{{ $menuLink->attr['target_blank'] == 1 ? '_blank' : '' }}">
                                    {!! $modLink['title'] !!}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    
                </div>
                <div class="col-lg-3 ">
                    <div class="f-widget mb-0">
                        <h5 class="mb-4">@lang('common.contact_caption')</h5>
                        <ul>
                            <li>
                                <span>@lang('common.address_caption')</span>{!! $config['address'] !!}
                            </li>
                            <li>
                                <span>@lang('common.phone_caption')</span>{!! $config['phone'] !!}
                            </li>
                            <li>
                                <span>@lang('common.fax_caption')</span>{!! $config['fax'] !!}
                            </li>
                            <li>
                                <span>@lang('common.email_caption')</span>{!! $config['email'] !!}
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