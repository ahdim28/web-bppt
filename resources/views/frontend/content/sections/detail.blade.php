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
        @if ($data['read']->categories->count() > 1)
        <div class="row justify-content-end mb-3">
            <div class="col-md-4">
                <div class="form-group d-flex align-items-center">
                    <!-- <label class="mb-0 mr-2" for="select-display">Kategori</label> -->
                    <select id="select-display" class="form-control">
                        <option value=" ">All</option>
                        @foreach ($data['read']->categories as $cat)
                        <option value="{{ $cat->slug }}">{!! $cat->fieldLang('name') !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @endif
        <div class="row">
            @forelse ($data['posts'] as $item)
            <div class="col-sm-6 col-lg-4">
                <div class="item-post">
                    <a href="{{ route('post.read.'.$item->section->slug, ['slugPost' => $item->slug]) }}" class="box-img img-overlay" title="{!! $item->fieldLang('title') !!}">
                        <div class="box-date">
                            <span class="dd">{{ $item->created_at->format('d') }}</span>
                            <span class="mmyy">{{ $item->created_at->format('F Y') }}</span>
                        </div>
                        <div class="thumb-img">
                            <img src="{{ $item->coverSrc() }}" alt="{{ $item->cover['alt'] }}" title="{{ $item->cover['title'] }}">
                        </div>
                    </a>
                    <div class="box-info">
                        <a href="{{ route('category.read.'.$item->section->slug, ['slugCategory' => $item->category->slug]) }}" class="post-info_2" title="{!! $item->category->fieldLang('name') !!}">
                            {!! $item->category->fieldLang('name') !!}
                        </a>
                        <a href="{{ route('post.read.'.$item->section->slug, ['slugPost' => $item->slug]) }}" title="{!! $item->fieldLang('title') !!}">
                            <h6 class="post-title">{!! $item->fieldLang('title') !!}</h6>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-md-12 text-center">
                <i>
                    <strong style="color:red;">
                        @if (count(Request::query()) > 0)
                        ! @lang('lang.data_attr_not_found', [
                            'attribute' => $data['read']->fieldLang('name')
                        ]) !
                        @else
                        ! @lang('lang.data_attr_empty', [
                            'attribute' => $data['read']->fieldLang('name')
                        ]) !
                        @endif
                    </strong>
                </i>
            </div>
            @endforelse
        </div>
        <div class="box-btn d-flex justify-content-end">
            {{ $data['posts']->onEachSide(1)->links('vendor.pagination.frontend') }}
        </div>
    </div>
</div>
@endsection

@section('jsbody')
<script>
    $('#select-display').on('change', function () {
        var slug = "{{ $data['read']->slug }}";
        var slugCat = $(this).val();

        if (slugCat != '') {
            window.location.href = '/'+slug+'/cat/'+slugCat;
        } else {
            window.location.href = '/'+slug;
        }

    });
</script>
@endsection
