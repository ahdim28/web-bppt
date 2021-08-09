<div class="modal fade" id="modals-create">
  <div class="modal-dialog">
    <form class="modal-content" action="{{ route('permission.store') }}" method="POST" id="form-create">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">
          @lang('lang.add_new')
          <span class="font-weight-light">@lang('mod/users.permission.caption')</span>
          {{-- <br>
          <small class="text-muted">form is required & name is unique</small> --}}
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="parent" id="parent">
        <div class="form-row" id="show-parent">
          <div class="form-group col">
            <label class="form-label">@lang('lang.parent')</label>
            <input type="text" class="form-control" id="parent-name" readonly>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col">
            <label class="form-label">@lang('mod/users.permission.label.field1')</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" 
              placeholder="@lang('mod/users.permission.placeholder.field1')" autofocus>
            @include('components.field-error', ['field' => 'name'])
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" title="@lang('lang.close')">
          <i class="las la-times"></i> @lang('lang.close')
        </button>
        <button type="submit" class="btn btn-primary" title="@lang('lang.save')">
          <i class="las la-save"></i> @lang('lang.save')
        </button>
      </div>
    </form>
  </div>
</div>