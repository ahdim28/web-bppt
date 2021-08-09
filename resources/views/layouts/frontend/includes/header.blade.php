<header>
    <div class="main-header">
        <div class="container">
            <div class="mh-flex">
                <div class="mh-left">
                    <a href="{{ route('home') }}" class="mh-logo" title="@lang('menu.frontend.title1')">
                        <img src="{!! $config['logo'] !!}" alt="Logo BPPT" title="Logo BPPT">
                    </a>
                </div>
                <div class="mh-center">
                    <nav class="main-nav">
                        <div class="close-toggle">
                            <i class="las la-times"></i>
                        </div>
                        <ul class="list-mv">
                            @foreach ($menu['header']->getMenu(1) as $header)
                            @php
                                $mod = $header->modMenu();
                            @endphp
                            <li {!! $header->childPublish->count() > 0 ? 'class="has-dropdown"' : '' !!}>
                                <a href="{!! $mod['routes'] !!}" class="nav-link {!! $header->attr['url'] == '#!' ? '' : 'nav-link outlink' !!}" title="{!! $mod['title'] !!}" target="{{ $header->attr['target_blank'] == 1 ? '_blank' : '' }}">
                                    <span>{!! $mod['title'] !!}</span>
                                </a>
                                @if ($header->childPublish->count() > 0)
                                <ul class="dropdown">
                                    <li class="btn-back"><a href="#!"><span><i class="las la-angle-left"></i></span></a></li>
                                    @foreach ($header->childPublish as $child1)
                                    @php
                                        $modChild1 = $child1->modMenu();
                                    @endphp
                                    <li {!! $child1->childPublish->count() > 0 ? 'class="has-dropdown"' : '' !!}>
                                        <a href="{!! $modChild1['routes'] !!}" title="{!! $modChild1['title'] !!}" target="{{ $child1->attr['target_blank'] == 1 ? '_blank' : '' }}">
                                            <span>{!! $modChild1['title'] !!}</span>
                                        </a>
                                        @if ($child1->childPublish->count() > 0)
                                        <ul class="sub-dropdown">
                                            @foreach ($child1->childPublish as $child2)
                                            @php
                                                $modChild2 = $child2->modMenu();
                                            @endphp
                                            <li class="btn-back"><a href="#!"><span><i class="las la-angle-left"></i></span></a></li>
                                            <a href="{!! $modChild2['routes'] !!}" title="{!! $modChild2['title'] !!}" target="{{ $child2->attr['target_blank'] == 1 ? '_blank' : '' }}">
                                                <span>{!! $modChild2['title'] !!}</span>
                                            </a>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </nav>
                </div>
                <div class="mh-right">
                    <div class="mh-item">
                        <div id="bidang-toggle" class="btn btn-main"><span>8 Fokus Bidang</span></div>
                    </div>
                    <div class="mh-item nav-search">
                        <div class="search-toggle">
                            <i class="las la-search"></i>
                        </div>
                        <!-- <div class="search-wrap">
                            <form>
                                <div class="form-group mb-0">
                                    <input id="search-header" type="search" class="form-control" placeholder="Type here to search">
                                    <button type="submit" class="btn-submit"><i class="las la-search"></i></button>
                                </div>
                            </form>
                        </div> -->
                    </div>
                    <div class="mh-item nav-burger">
                        <div class="nav-toggle">
                            <i class="las la-bars"></i>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <div class="bottom-header">
        <div class="container">
            <div class="bh-flex">
                <div class="bh-left">
                    <div class="bh-item">
                        <a href="" class="ct-item">
                            <div class="ic-ct">
                                <i class="las la-phone"></i>
                            </div>
                            <div class="summary-ct">
                                <span class="content-ct">{!! $config['phone'] !!}</span>
                                <span class="desc-ct">@lang('common.discuss')</span>
                            </div>
                        </a>
                        <a href="" class="ct-item">
                            <div class="ic-ct">
                                <i class="las la-envelope"></i>
                            </div>
                            <div class="summary-ct">
                                <span class="content-ct">{!! $config['email'] !!}</span>
                                <span class="desc-ct">@lang('common.discuss')</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="bh-right">
                    <div class="bh-item">
                        <div class="box-language">
                            <i class="las la-globe-asia"></i>
                            <ul class="nav-lang">
                                @foreach ($languages as $lang)
                                <li class="{{ $lang->iso_codes == App::getLocale() ? 'active' : '' }}">
                                    <a href="{{ $lang->urlSwitcher() }}" title="{!! $lang->country !!}">{!! $lang->country !!}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        
                    </div>
                    <div class="bh-item">
                        <div class="box-search">
                            <div class="search-wrap">
                                <form>
                                    <div class="form-group mb-0">
                                        <input id="search-header" type="search" class="form-control" placeholder="Type here to search">
                                        <button type="submit" class="btn-submit"><i class="las la-search"></i></button>
                                    </div>
                                </form>
                            </div>
                            <!-- <div class="search-nav">
                                <span class="search-btn" data-selector=".search-nav">
                                <i class="ti ti-search"></i>
                                </span>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>