@extends('layouts.frontend.layout')

@section('content')
<div class="banner-breadcrumb">
    <div class="bg-breadcrumb"> 
    </div>
    <div class="flex-breadcrumb">
        <div class="row justify-content-between">
            <div class="col-xl-7">
                @include('components.breadcrumbs-frontend')
            </div>
            <div class="col-xl-4">
                @include('includes.search')
            </div>
        </div>
    </div>
</div>

<div class="box-wrap">
    <div class="container">
        <div class="box-list">
            <div class="row justify-content-center">
                @foreach ($data['sidadu'] as $key => $item)
                @php
                    $url = 'https://sidadu.bppt.go.id/operator/webservice/sidadu_foto.php';
                    $token = [
                        'nip' => $item->nip,
                        'token' => '256817c6c95400c7628c2c3fc1'
                    ];

                    $options = [
                        'http' => [
                            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                            'method' => 'POST',
                            'content' => http_build_query($token),
                        ],
                        'ssl' => [
                            'verify_peer' => false,
                            'verify_peer_name' => false
                        ]
                    ];

                    $context = stream_context_create($options);
                    $nip = file_get_contents($url, false, $context);
                @endphp
                <div class="col-md-6 col-lg-4">
                    <div class="item-lead">
                        <div class="box-img tall">
                            <div class="thumb-img">
                                <img src="{{ $nip }}" alt="{{ $item->jabatan }}" title="{{ $item->nama }}">
                            </div>
                            <div class="box-board box-large">
                                {{ $item->jabatan }}
                            </div>
                        </div>
                        <div class="box-info">
                            <h6>{{ $item->nama }}</h6>
                            <span class="boxmail">{{ $item->username }}[at]bppt.go.id  </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection