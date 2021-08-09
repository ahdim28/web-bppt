@extends('layouts.frontend.layout')

{{-- call recaptcah JS --}}
@section('jshead')
{!! htmlScriptTagJsApi() !!}
@endsection

@section('content')
{{-- check status map --}}
@if ($data['read']->show_map == 1)    
<div class="col-lg-6">
    <div class="map-box-contact">
        <div class="pattern-bg large right-top"></div>
        <div id="map" class="box-shadow"></div>
    </div>
</div>
@endif
{{-- check status form --}}
@if ($data['read']->show_form == 1)    
<div class="col-lg-5">
    <form class="inquiry" action="{{ route('inquiry.submit', ['id' => $data['read']->id]) }}" method="POST">
        @csrf
        <div class="title-heading text-center">
            <h6>@lang('common.contact_form_title')</h6>
            <h2 class="">@lang('common.contact_form_text').</h2>
        </div>
        @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            {!! strip_tags($data['read']->fieldLang('after_body')) !!}
        </div>
        @else
            @if (Cookie::get($data['read']->slug))
            <div class="alert alert-success alert-dismissible">
                {!! strip_tags($data['read']->fieldLang('after_body')) !!}
            </div>
            @else
            <div class="row">
                @foreach ($data['inquiry_fields'] as $field)   
                <div class="{{ $field->properties['class'] }}">
                    <div class="form-group">
                        <label for="{!! $field->name !!}">{!! $field->fieldLang('label') !!}</label>
                        @if ($field->type == 1)
                        <textarea class="form-control @error($field->name) is-invalid @enderror" name="{!! $field->name !!}" value="{{ old($field->name) }}"></textarea>
                        @else
                        <input type="{{ $field->properties['type'] }}" class="form-control @error($field->name) is-invalid @enderror" name="{!! $field->name !!}" value="{{ old($field->name) }}">
                        @endif
                        @include('components.field-error', ['field' => $field->name])
                    </div>
                </div> 
                @endforeach
                <div class="col-md-12">
                    <div class="form-group">
                        {!! htmlFormSnippet() !!}
                        @error('g-recaptcha-response')
                        <p style="color:red;">{{ $message }}<p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="box-btn d-flex justify-content-center">
                <button class="btn btn-gradient mt-4" type="submit" title="@lang('common.contact_form_btn')">
                    <span>@lang('common.contact_form_btn')</span>
                </button>
            </div>
            @endif
        @endif
    </form>
</div>
@endif
@endsection

@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0CuuQ5YQNoIc91Ser9cbum8gYy0oOf4w&callback=initMap" async defer></script>
@endsection

@section('jsbody')
@if ($data['read']->show_map == 1) 
<script>
    // MAP
    var map;
        function initMap() {
        var myLatlng = new google.maps.LatLng('{{ $data['read']->latitude }}', '{{ $data['read']->longitude }}');

        map = new google.maps.Map(document.getElementById('map'), {
            center: myLatlng,
            zoom: 6,
            gestureHandling: 'greedy',
            scrollwheel: false,
            // style
            // styles: []
            // end style
        });

        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: '{!! $config['website_name'] !!}',
        });
    }
</script>
@endif
@endsection
