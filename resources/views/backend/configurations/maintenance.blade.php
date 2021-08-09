@extends('layouts.backend.layout')

@section('content')
<div class="container px-0">
    <h2 class="text-center font-weight-bolder pt-5">
      <i class="lnr lnr-construction d-block"></i> @lang('mod/setting.maintenance.sub')
    </h2>
    <div class="text-center text-muted text-big mx-auto mt-3" style="max-width: 500px;">
      @lang('mod/setting.maintenance.text')
    </div>

    <br>
    <div class="d-flex justify-content-center">

        <form action="" method="GET">
            @foreach ($data['maintenance'] as $key => $item)
            @if (($item) == false)
            <input type="hidden" name="{{ $key }}" value="1">
            <button class="btn btn-xl btn-outline-success" title="@lang('mod/setting.maintenance.btn.on')">
              <i class="las la-power-off"></i> @lang('mod/setting.maintenance.btn.on')
            </button>
            @else
            <input type="hidden" name="{{ $key }}" value="0">
            <button class="btn btn-xl btn-outline-danger" title="@lang('mod/setting.maintenance.btn.off')">
              <i class="las la-power-off"></i> @lang('mod/setting.maintenance.btn.off')
            </button>
            @endif
            @endforeach
        </form>
        &nbsp;
    </div>
</div>
@endsection
