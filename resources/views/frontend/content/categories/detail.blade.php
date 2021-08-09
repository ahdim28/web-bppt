@extends('layouts.frontend.layout')

@section('content')
<div class="banner-breadcrumb">
    <div class="bg-breadcrumb"> 
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="box-breadcrumb">
                    <div class="title-heading text-center">
                        <h1>{!! $data['read']->fieldLang('name') !!}</h1>
                    </div>
                    <a href="{{ route('home') }}" class="btn-back">
                        <i class="las la-home"></i><span>Kembali ke Home</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box-wrap">
    <div class="container">
        <article class="summary-text mb-5 text-center">
            Under construction
        </article>
    </div>
</div>
@endsection
