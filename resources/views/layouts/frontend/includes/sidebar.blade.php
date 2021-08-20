<div class="sidebar-menu">
    <div class="close-toggle-sm">
        <i class="las la-times"></i>
    </div>
    <div class="nav-lang">
        <ul class="list-lang">
            @foreach ($languages as $lang)
            <li class="{{ $lang->iso_codes == App::getLocale() ? 'active' : '' }}">
                <a href="{{ $lang->urlSwitcher() }}" title="{!! $lang->country !!}">{!! $lang->iso_codes !!}</a>
            </li>
            @endforeach
        </ul>
    </div>
    <ul class="list-sm">
        @foreach ($menu['sidebar']->getMenu(2) as $sidebar)
        @php
            $modSidebar = $sidebar->modMenu();
        @endphp
        <li class="sm-has-dropdown">
            <a href="{!! $modSidebar['routes'] !!}">
                <i class="{{ $sidebar->attr['icon'] }}"></i>
                <span  class="link-name" title="{!! $modSidebar['title'] !!}">{!! $modSidebar['title'] !!}</span>
            </a>
            @if ($sidebar->childPublish->count() > 0)
            <ul class="dropdown">
                <li>
                    <a href="{!! $modSidebar['routes'] !!}" class="link-name"><span>{!! $modSidebar['title'] !!}</span></a>
                    <a href="#!" class="btn-back"><i class="las la-angle-left"></i></a>
                </li>
                @foreach ($sidebar->childPublish as $child1)
                @php
                    $modChild1 = $child1->modMenu();
                @endphp
                <li>
                    <a href="{!! $modChild1['routes'] !!}"  
                        title="{!! $modChild1['title'] !!}" 
                        target="{{ $child1->attr['target_blank'] == 1 ? '_blank' : '' }}">
                        <span>{!! $modChild1['title'] !!}</span>
                    </a>
                </li>
                @endforeach
            </ul>
            @endif
        </li>
        @endforeach
    </ul>
</div>