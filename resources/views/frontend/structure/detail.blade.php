@extends('layouts.frontend.layout')

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
                            <span>Struktur Organisasi</span>
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
        <div class="box-list">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="item-lead">
                        <div class="box-img tall">
                            <div class="thumb-img">
                                <img src="{{ asset('assets/frontend/images/kepala-bppt.jpg') }}" alt="">
                            </div>
                            <div class="box-board box-large">
                                Kepala BPPT
                            </div>
                        </div>
                        <div class="box-info">
                            <h6>Dr. Ir. Hammam Riza, M.Sc.</h6>
                            <span class="boxmail">hammam.riza[at]bppt.go.id  </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection