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
                <th scope="col">Category</th>
              </tr>
            </thead>
            <tbody>
                @forelse ($data['categories'] as $item)
                <tr>
                    <td>
                        <a href="#!">
                        @if ($item->parent == 0)
                        {!! $item->fieldLang('name') !!}
                        @else
                        <i>--- {!! $item->fieldLang('name') !!}</i>
                        @endif
                        </a>
                    </td>
                </tr>
                @empty    
                <tr>
                    <td class="text-center">
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
            {{ $data['categories']->onEachSide(1)->links('vendor.pagination.frontend') }}
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