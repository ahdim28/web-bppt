@extends('layouts.frontend.application')

@section('layout-content')
    @include('layouts.frontend.includes.header')
    <main>
        @yield('content')
    </main>
    @include('layouts.frontend.includes.footer')
@endsection
