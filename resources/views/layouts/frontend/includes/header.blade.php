<header>
    <div class="main-header">
        <div class="mh-flex">
            <div class="mh-left">
                <a href="{{ route('home') }}" class="mh-logo" title="@lang('menu.frontend.title1')">
                    <img src="{!! $config['logo_2'] !!}" alt="Logo BPPT" title="Logo BPPT">
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
                            $modHeader = $header->modMenu();
                        @endphp
                        <li>
                            <a href="{!! $modHeader['routes'] !!}" class="nav-link" title="{!! $modHeader['title'] !!}"><span>{!! $modHeader['title'] !!}</a>
                        </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
            <div class="mh-right">
                <div class="mh-item nav-lang">
                    <ul class="list-lang">
                        @foreach ($languages as $lang)
                        <li class="{{ $lang->iso_codes == App::getLocale() ? 'active' : '' }}">
                            <a href="{{ $lang->urlSwitcher() }}" title="{!! $lang->country !!}">{!! $lang->iso_codes !!}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <a href="{{ route('inquiry.read.'.$linkModule['contact']->slug) }}" class="mh-item nav-phone" title="@lang('common.call_center_caption')">
                    <div class="phone-icon">
                        <i class="las la-phone-volume"></i>
                    </div>
                    <span>@lang('common.call_center_caption')</span>
                </a>
                <div class="mh-item nav-is" title="@lang('common.inovation_service_caption')">
                    <span class="is-toggle">@lang('common.inovation_service_caption')</span>
                </div>
                <div class="mh-item nav-search">
                    <div class="search-toggle">
                        <i class="las la-search"></i>
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
</header>