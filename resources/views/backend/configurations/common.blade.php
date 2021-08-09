@extends('layouts.backend.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/backend/vendor/css/pages/account.css') }}">
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="card mb-4 col-md-10">
        @if (config('custom.language.multiple') == true)
        <div class="list-group list-group-flush account-settings-links flex-row">
            @foreach ($data['languages'] as $item)
            <a class="list-group-item list-group-item-action {{ $item->iso_codes == Request::segment(4) ? 'active' : '' }}" 
                href="{{ route('configuration.common', ['lang' => $item->iso_codes]) }}">
                <img src="{{ $item->flags() }}" style="width: 20px;"> {{ Str::upper($item->country) }}</a>
            @endforeach
        </div>
        @endif
        <form action="" method="get">
            @csrf
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active">
                        @foreach ($data['files'] as $key => $value)
                        <div class="form-group row">
                            <div class="col-md-2 text-md-right">
                            <label class="col-form-label text-sm-right">{{ Str::replace('_', ' ', Str::upper($key)) }}</label>
                            </div>
                            <div class="col-md-10">
                                <textarea class="form-control mb-1" name="lang[{{ $key }}]" placeholder="enter text...">{{ $value }}</textarea>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary" name="action" value="exit" title="@lang('lang.save_change')">
                    <i class="las la-save"></i> @lang('lang.save_change')
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('jsbody')
<script src="{{ asset('assets/backend/js/pages_account-settings.js') }}"></script>
@endsection
