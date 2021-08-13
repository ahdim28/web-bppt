@extends('layouts.frontend.layout')

@section('jshead')
{!! htmlScriptTagJsApi() !!}
@endsection

@section('content')
<div class="banner-breadcrumb">
    <div class="bg-breadcrumb">
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="box-breadcrumb bc-center">
                    <ul class="list-breadcrumb">
                        <li class="item-breadcrumb">
                            <a href="{{ route('home') }}" title="@lang('menu.frontend.title1')">
                                <i class="las la-home"></i><span>@lang('menu.frontend.title1')</span>
                            </a>
                        </li>
                        <li class="item-breadcrumb">
                            <span>{!! Str::limit($data['read']->fieldLang('name'), 30) !!}</span>
                        </li>
                    </ul>
                    <div class="title-heading text-center">
                        <h1>{!! $data['read']->fieldLang('name') !!}</h1>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box-wrap">
    <div class="container">
        <div class="row flex-lg-row-reverse justify-content-between">
            <div class="col-lg-6">
                {!! $data['read']->fieldLang('body') !!}
                <div class="row">
                    <div class="col-6">
                        <div class="item-contact">
                            <span>@lang('common.phone_caption'):</span>
                            <div class="content-contact">
                                <i class="las la-phone-volume"></i>
                                <div class="desc-contact">{!! $config['phone'] !!}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-contact">
                            <span>@lang('common.email_caption') :</span>
                            <div class="content-contact">
                                <i class="las la-envelope"></i>
                                <div class="desc-contact">{!! $config['email'] !!}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-contact">
                            <span>@lang('common.fax_caption'):</span>
                            <div class="content-contact">
                                <i class="las la-fax"></i>
                                <div class="desc-contact">{!! $config['fax'] !!}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-contact">
                            <span>Website :</span>
                            <div class="content-contact">
                                <i class="las la-globe"></i>
                                <div class="desc-contact">bppt.go.id</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="item-contact">
                            <span>@lang('common.address_caption')< :</span>
                            <div class="content-contact">
                                <i class="las la-map-marked-alt"></i>
                                <div class="desc-contact">{!! $config['address'] !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($data['read']->show_map == 1) 
                <a href="https://www.google.com/maps/place/Public+Relations+Office+BPPT/@{{ $data['read']->latitute }},{{ $data['read']->longitude }},17z/data=!3m1!4b1!4m5!3m4!1s0x2e69f428e34d0899:0x1b73a123ae591cb0!8m2!3d-6.1848907!4d106.8227703" target="_blank" class="box-map mt-4">
                    <div class="icon-map">
                        <i class="las la-map-marker"></i>
                    </div>
                    <div class="btn btn-text"><span>View on Google Map</span></div>
                </a>
                @endif
            </div>
            @if ($data['read']->show_form == 1)    
            <div class="col-lg-5">
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
                    <form class="inquiry" action="{{ route('inquiry.submit', ['id' => $data['read']->id]) }}" method="POST">
                        @csrf
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
                        <div class="box-btn d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-main" title="@lang('common.contact_send_btn')"><span>@lang('common.contact_send_btn')</span></button>
                        </div>
                    </form>
                    @endif
                @endif
            </div>
            @endif
            
        </div>
    </div>
</div>
@endsection
