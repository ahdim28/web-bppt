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
                            @foreach ($menu['header']->getMenu(1) as $mainMenu)
                            @php
                                $modMain = $mainMenu->modMenu();
                            @endphp
                            <li class="{!! $mainMenu->childPublish->count() > 0 ? 'has-dropdown' : '' !!}">
                                <a href="{!! $modMain['routes'] !!}" 
                                    class="nav-link {{ $mainMenu->attr['target_blank'] == 1 ? 'outlink' : '' }}" 
                                    title="{!! $modMain['title'] !!}" 
                                    target="{{ $mainMenu->attr['target_blank'] == 1 ? '_blank' : '' }}">
                                    <span>{!! $modMain['title'] !!}</span>
                                </a>
                                @if ($mainMenu->childPublish->count() > 0)
                                <ul class="dropdown">
                                    <li class="btn-back"><a href="#!" title="back"><span><i class="las la-angle-left"></i></span></a></li>
                                    @foreach ($mainMenu->childPublish as $child1)
                                    @php
                                        $modChild1 = $child1->modMenu();
                                    @endphp
                                    @if ($child1->childPublish->count() == 0)
                                    <li>
                                        <a href="{!! $modChild1['routes'] !!}"  
                                            class="{!! !empty($child1->attr['icon']) ? 'nav-link-icon' : '' !!}"
                                            title="{!! $modChild1['title'] !!}" 
                                            target="{{ $child1->attr['target_blank'] == 1 ? '_blank' : '' }}">
                                            @if (!empty($child1->attr['icon']))
                                            <i class="{{ $child1->attr['icon'] }}"></i>
                                            @endif
                                            <span>{!! $modChild1['title'] !!}</span>
                                        </a>
                                    </li>
                                    @else
                                    <li class="has-sub-dropdown">
                                        <a href="{!! $modChild1['routes'] !!}" title="{!! $modChild1['title'] !!}" target="{{ $child1->attr['target_blank'] == 1 ? '_blank' : '' }}">
                                            <span>{!! $modChild1['title'] !!}</span>
                                        </a>
                                        <ul class="sub-dropdown">
                                            <li class="btn-back"><a href="#!" title="back"><span><i class="las la-angle-left"></i></span></a></li>
                                            @foreach ($child1->childPublish as $child2)
                                            @php
                                                $modChild2 = $child2->modMenu();
                                            @endphp
                                            <li>
                                                <a href="{!! $modChild2['routes'] !!}" 
                                                    class="{!! !empty($child2->attr['icon']) ? 'nav-link-icon' : '' !!}"
                                                    title="{!! $modChild2['title'] !!}" 
                                                    target="{{ $child2->attr['target_blank'] == 1 ? '_blank' : '' }}">
                                                    @if (!empty($child2->attr['icon']))
                                                    <i class="{{ $child2->attr['icon'] }}"></i>
                                                    @endif
                                                    <span>{!! $modChild2['title'] !!}</span>
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </nav>
                </div>
                <div class="mh-right">
                    @if (!empty($linkModule['fields']))
                    <div class="mh-item">
                        <div id="bidang-toggle" class="btn btn-main" title="{!! $linkModule['fields']->fieldLang('title') !!}">
                            <span>{!! $linkModule['fields']->fieldLang('title') !!}</span>
                        </div>
                    </div>
                    @endif
                    <div class="mh-item nav-search">
                        <div class="search-toggle">
                            <i class="las la-search"></i>
                        </div>
                        <div class="search-wrap">
                            <form action="{{ route('home.search') }}" method="GET">
                                <div class="form-group mb-0">
                                    <input id="search-header" type="search" class="form-control" name="keyword" value="{{ Request::get('keyword') }}"
                                        placeholder="@lang('common.search_placeholder')">
                                    <button type="submit" class="btn-submit" title="@lang('common.search_caption')"><i class="las la-search"></i></button>
                                </div>
                            </form>
                        </div>
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
                        <div id="deputi-toggle" class="ct-item" title="@lang('common.deputy_caption')">
                            <div class="ic-ct">
                                <i class="las la-user-tie"></i>
                            </div>
                            <div class="summary-ct">
                                <span class="content-ct">@lang('common.deputy_caption')</span>
                                <span class="desc-ct">@lang('common.deputy_caption')</span>
                            </div>
                        </div>
                        <a href="{!! $config['layanan_bppt'] !!}" target="_blank" class="ct-item" title="@lang('common.service_caption')">
                            <div class="ic-ct">
                                <i class="las la-bullhorn"></i>
                            </div>
                            <div class="summary-ct">
                                <span class="content-ct">@lang('common.service_caption')</span>
                                <span class="desc-ct">@lang('common.service_text')</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="bh-right">
                    <div class="bh-item">
                        <div class="box-language ml-auto">
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
                                <form action="{{ route('home.search') }}" method="GET">
                                    <div class="form-group mb-0">
                                        <input id="search-header" type="search" class="form-control" name="keyword" value="{{ Request::get('keyword') }}"
                                            placeholder="@lang('common.search_placeholder')">
                                        <button type="submit" class="btn-submit" title="@lang('common.search_caption')"><i class="las la-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>