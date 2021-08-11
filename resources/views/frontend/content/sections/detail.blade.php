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
                            <span>{!! $data['read']->fieldLang('name') !!}</span>
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
        {{-- <div class="row justify-content-end mb-3">
            <div class="col-md-4">
                <div class="form-group d-flex align-items-center">
                    <!-- <label class="mb-0 mr-2" for="select-display">Kategori</label> -->
                    <select id="select-display" class="form-control">
                        <option>All</option>
                        <option>Layanan Info Publik</option>
                        <option>Kebijakan Teknologi</option>
                        <option>Teknologi Sumberdaya Alam dan Kebencanaan</option>
                        <option>Teknologi Agroindustri dan Bioteknologi</option>
                        <option>Teknologi Informasi, Energi dan Material</option>
                        <option>Teknologi Hankam,Transportasi & Manufakturing </option>
                    </select>
                </div>
            </div>
        </div> --}}
        <div class="row">
            @foreach ($data['posts'] as $item)
            <div class="col-sm-6 col-lg-4">
                <div class="item-post">
                    <a href="{{ route('post.read.'.$item->section->slug, ['slugPost' => $item->slug]) }}" class="box-img img-overlay">
                        <div class="box-date">
                            <span class="dd">{{ $item->created_at->format('d') }}</span>
                            <span class="mmyy">{{ $item->created_at->format('F Y') }}</span>
                        </div>
                        <div class="thumb-img">
                            <img src="{{ $item->coverSrc() }}" alt="">
                        </div>
                    </a>
                    <div class="box-info">
                        <a href="{{ route('post.read.'.$item->section->slug, ['slugPost' => $item->slug]) }}" class="post-info_2">
                            {!! $item->category->fieldLang('name') !!}
                        </a>
                        <a href="{{ route('post.read.'.$item->section->slug, ['slugPost' => $item->slug]) }}">
                            <h6 class="post-title">{!! $item->fieldLang('title') !!}</h6>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="box-btn d-flex justify-content-end">
            {{ $data['posts']->onEachSide(1)->links('vendor.pagination.frontend') }}
        </div>
    </div>
</div>
@endsection
