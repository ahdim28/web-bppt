@isset($breadcrumbs)
<div class="box-breadcrumb">
    <ul class="list-breadcrumb">
        <li class="item-breadcrumb">
            <a href="{{ route('home') }}" title="@lang('menu.frontend.title1')">
                <i class="las la-home"></i><span>@lang('menu.frontend.title1')</span>
            </a>
        </li>
        @foreach ($breadcrumbs as $key => $val)
        <li class="item-breadcrumb">
            @if (!empty($val))
            <a href="{{ $val }}" title="{!! $key !!}">
                <span>{!! $key !!}</span>
            </a>
            @else
            <span>{!! $key !!}</span>
            @endif
        </li>
        @endforeach
    </ul>
    @if (!empty(Request::route('slugPost')) && Request::route('slug') == 'agenda-kegiatan' || !empty(Request::route('slugPost')) && Request::route('slug') == 'inovasi-bppt' || empty(Request::route('slugPost')))
    <div class="title-heading">
        <h2>{!! $title !!}</h2>
    </div>
    @endif
</div>
@endisset