@extends('layouts.frontend.layout')

@section('jshead')
{!! htmlScriptTagJsApi() !!}
@endsection

@section('content')

{{-- recaptcha
<div class="form-group">
    {!! htmlFormSnippet() !!}
    @error('g-recaptcha-response')
    <p style="color:red;">{{ $message }}<p>
    @enderror
</div> --}}
@endsection
