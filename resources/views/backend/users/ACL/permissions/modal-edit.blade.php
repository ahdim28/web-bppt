<div class="modal fade" id="modals-edit">
  <div class="modal-dialog">
    <form class="modal-content" action="" method="POST" id="form-edit">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title">
          @lang('lang.edit')
          <span class="font-weight-light">@lang('mod/users.permission.caption')</span>
          {{-- <br>
          <small class="text-muted">form is required & name is unique</small> --}}
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group col">
            <label class="form-label">@lang('mod/users.permission.label.field1')</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" 
              placeholder="@lang('mod/users.permission.placeholder.field1')" autofocus>
            @include('components.field-error', ['field' => 'name'])
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" title="@lang('lang.close')">
          <i class="las la-times"></i> @lang('lang.close')
        </button>
        <button type="submit" class="btn btn-primary" title="@lang('lang.save_change')">
          <i class="las la-save"></i> @lang('lang.save_change')
        </button>
      </div>
    </form>
  </div>
</div>