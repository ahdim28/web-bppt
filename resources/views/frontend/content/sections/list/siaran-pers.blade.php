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
        <div class="d-flex justify-content-end mb-3">
            <div class="form-group d-flex align-items-center">
                <label class="mb-0 mr-3" for="select-display">Display</label>
                <select id="select-display" class="form-control fit">
                    <option value=" " {{ Request::get('l') == '' ? 'selected' : '' }}>Any</option>
                    @foreach (config('custom.filtering.limit') as $key => $val)
                    <option value="{{ $key }}" {{ Request::get('l') == ''.$key.'' ? 'selected' : '' }} title="@lang('lang.limit') {{ $val }}">{{ $val }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <table class="table table-borderless table-striped table-hover mb-5">
            <thead class="thead-blue">
              <tr>
                <th scope="col">Title</th>
                <th scope="col">Publish</th>
                <th scope="col">Hits</th>
              </tr>
            </thead>
            <tbody>
                @forelse ($data['posts'] as $item)  
                <tr>
                    <td>
                        <a href="{{ route('post.read.'.$item->section->slug, ['slugPost' => $item->slug]) }}" {!! $item->fieldLang('title') !!}>
                        {!! $item->fieldLang('title') !!}
                        </a>
                    </td>
                    <td>{!! $item->created_at->format('d F Y') !!}</td>
                    <td>
                        <span class="hits-table">{{ $item->viewer }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">
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
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
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
        var limit = $(this).val();

        if (limit != ' ') {
            window.location.href = '/'+slug+'?l='+limit;
        } else {
            window.location.href = '/'+slug;
        }

    });
</script>
@endsection