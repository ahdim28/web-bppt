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
        {{-- <div class="d-flex justify-content-end mb-3">
            <div class="form-group d-flex align-items-center">
                <label class="mb-0 mr-3" for="select-display">Display</label>
                <select id="select-display" class="form-control fit">
                    <option>10</option>
                    <option>30</option>
                    <option>50</option>
                    <option>100</option>
                    <option>All</option>
                </select>
            </div>
        </div> --}}
        <table class="table table-borderless table-striped table-hover mb-5">
            <thead class="thead-blue">
              <tr>
                <th scope="col">Judul</th>
                <th scope="col">Tanggal Publish</th>
                <th scope="col">Hits</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($data['posts'] as $item)  
                <tr>
                    <td><a href="{{ route('post.read.'.$item->section->slug, ['slugPost' => $item->slug]) }}">{!! $item->fieldLang('title') !!}</a></td>
                    <td>{!! $item->created_at->format('d F Y') !!}</td>
                    <td><span class="hits-table">{{ $item->viewer }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="box-btn d-flex justify-content-end">
            {{ $data['posts']->onEachSide(1)->links('vendor.pagination.frontend') }}
        </div>
    </div>
</div>
@endsection