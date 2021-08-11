<div class="float-deputi">
    <div class="close-toggle-deputi">
        <i class="las la-times"></i>
    </div>
    <ul class="list-deputi">
        @foreach ($linkModule['deputys'] as $deputi)
        <li class="item-float-deputi">
            <a href="{{ route('structure.read', ['slugStructure' => $deputi->slug]) }}" class="item-deputi" title="{!! $deputi->fieldLang('name') !!}">
                <div class="box-icon-deputi">
                    <i class="las la-user-tie"></i>
                </div>
                <h6>{!! $deputi->fieldLang('name') !!}</h6>
            </a>
        </li>
        @endforeach
    </ul>
</div>