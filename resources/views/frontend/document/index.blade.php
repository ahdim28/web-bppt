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
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
                @forelse ($data['documents'] as $item)  
                <tr>
                    <td>{!! $item->fieldLang('title') !!}</td>
                    <td width="40px">
                        <a href="{{ $item->from == 1 ? $item->document_url : route('document.download', ['id' => $item->id]) }}">
                            <span class="btn w-icon small"><i class="las la-download"></i><span>Download</span>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="text-center">
                        <i>
                            <strong style="color:red;">
                                @if (count(Request::query()) > 0)
                                ! @lang('lang.data_attr_not_found', [
                                    'attribute' => __('common.document_caption')
                                ]) !
                                @else
                                ! @lang('lang.data_attr_empty', [
                                    'attribute' => __('common.document_caption')
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
            {{ $data['documents']->onEachSide(1)->links('vendor.pagination.frontend') }}
        </div>
    </div>
</div>
@endsection

@section('jsbody')
<script>
    $('#select-display').on('change', function () {
        var limit = $(this).val();

        if (limit != ' ') {
            window.location.href = '/dokumen'+'?l='+limit;
        } else {
            window.location.href = '/dokumen';
        }

    });
</script>
@endsection
