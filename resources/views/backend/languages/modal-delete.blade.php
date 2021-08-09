<div class="modal fade" id="modals-delete">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center">
          <span class="font-weight-light">
            @lang('alert.delete_attr_confirm_text', [
              'attribute' => __('mod/language.caption')
            ])
          </span>
          <strong id="name"></strong>
          {{-- <br>
          <small class="text-muted">form is required & name is unique</small> --}}
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
      </div>
      {{-- <div class="modal-body text-center">
        
      </div> --}}
      <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-warning soft-delete id" data-dismiss="modal" title="@lang('lang.move_trash')">
            <i class="las la-trash-alt"></i> @lang('lang.move_trash')
          </button>
          <button type="submit" class="btn btn-danger permanent-delete id" title="@lang('lang.delete_permanent')">
            <i class="las la-times"></i> @lang('lang.delete_permanent')
          </button>
      </div>
    </div>
  </div>
</div>
