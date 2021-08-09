@extends('layouts.backend.layout')

@section('content')
<div class="card mb-4">
    <h6 class="card-header">
        @lang('mod/users.role.give_permission') <strong><span class="badge badge-primary"><i class="lab la-slack"></i>{{ Str::upper($data['role']->name) }}</span></strong>
    </h6>
    <form action="{{ route('role.permission', ['id' => $data['role']->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="table-responsive mb-4">
                @foreach ($data['permission'] as $item)
                @php
                    $totalChild = $item->where('parent', $item->id)->count();
                @endphp
                <table class="table mb-2 table-bordered text-center">
                    <thead>
                        <tr>
                            <th class="text-center" colspan="{{ $totalChild+1 }}">{!! Str::upper(Str::replace('_', ' ', $item->name)) !!}</th>
                        </tr>
                        <tr>
                            <td>READ</td>
                            @foreach ($item->where('parent', $item->id)->get() as $child)
                            @php
                                $parentName = substr_replace($item->name, '', -1);
                                $childName = Str::replace($parentName.'_', '', $child->name)
                            @endphp
                            <td>{{ Str::replace('_', ' ', Str::upper($childName)) }}</td>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <label class="switcher switcher-success">
                                    <input type="checkbox" class="switcher-input check-parent" data-id="{{ $item->id }}" name="permission[]" value="{{ $item->id }}" 
                                        {{ in_array($item->id, $data['permission_id']) ? 'checked' : '' }}>
                                    <span class="switcher-indicator">
                                      <span class="switcher-yes">
                                        <span class="ion ion-md-checkmark"></span>
                                      </span>
                                      <span class="switcher-no">
                                        <span class="ion ion-md-close"></span>
                                      </span>
                                    </span>
                                </label>
                            </td>
                            @foreach ($item->where('parent', $item->id)->get() as $child)
                            <td>
                                <label class="switcher switcher-success">
                                    <input type="checkbox" class="switcher-input check-child-{{ $child->parent }}" name="permission[]" value="{{ $child->id }}"
                                    {{ in_array($child->id, $data['permission_id']) ? 'checked' : '' }}>
                                    <span class="switcher-indicator">
                                      <span class="switcher-yes">
                                        <span class="ion ion-md-checkmark"></span>
                                      </span>
                                      <span class="switcher-no">
                                        <span class="ion ion-md-close"></span>
                                      </span>
                                    </span>
                                </label>
                            </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
                @endforeach
            </div>
        </div>
        <div class="card-footer text-center">
            <button type="submit" class="btn btn-primary" name="action" value="back" title="@lang('lang.save_change')">
                <i class="las la-save"></i> @lang('lang.save_change')
            </button>&nbsp;&nbsp;
            <button type="submit" class="btn btn-danger" name="action" value="exit" title="@lang('lang.save_change_exit')">
                <i class="las la-save"></i> @lang('lang.save_change_exit')
            </button>&nbsp;&nbsp;
            <button type="reset" class="btn btn-secondary" title="@lang('lang.reset')">
                <i class="las la-redo-alt"></i> @lang('lang.reset')
            </button>
        </div>
    </form>
</div>
@endsection

@section('jsbody')
<script>
    $(".check-parent").click(function () {
        var parent = $(this).attr('data-id');
       $('.check-child-' + parent).not(this).prop('checked', this.checked);
   });
</script>
@endsection