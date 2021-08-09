<div class="modal fade" id="modal-export">
    <div class="modal-dialog">
      <form class="modal-content" action="{{ route('inquiry.export', ['id' => $data['inquiry']->id]) }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">
            Export
            <span class="font-weight-light">Form</span>
            {{-- <br>
            <small class="text-muted">form is required & name is unique</small> --}}
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
        </div>
        <div class="modal-body">
            <div class="form-row">
                <div class="form-group col">
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="default" value="1">
                        <span class="custom-control-label">Default Setting</span>
                    </label>
                </div>
            </div>
            <div id="setting">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <div class="col-md-2 text-md-left">
                              <label class="col-form-label text-sm-left">Read</label>
                            </div>
                            <div class="col-md-10">
                                <label class="switcher switcher-success">
                                    <input type="checkbox" class="switcher-input check-parent" name="status" value="1" 
                                        {{ (old('status') == 1 ? 'checked' : '') }}>
                                    <span class="switcher-indicator">
                                      <span class="switcher-yes">
                                        <span class="ion ion-md-checkmark"></span>
                                      </span>
                                      <span class="switcher-no">
                                        <span class="ion ion-md-close"></span>
                                      </span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <div class="col-md-2 text-md-left">
                              <label class="col-form-label text-sm-left">Export</label>
                            </div>
                            <div class="col-md-10">
                                <label class="switcher switcher-success">
                                    <input type="checkbox" class="switcher-input check-parent" name="exported" value="1" 
                                        {{ (old('exported') == 1 ? 'checked' : '') }}>
                                    <span class="switcher-indicator">
                                      <span class="switcher-yes">
                                        <span class="ion ion-md-checkmark"></span>
                                      </span>
                                      <span class="switcher-no">
                                        <span class="ion ion-md-close"></span>
                                      </span>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                      <label class="form-label">Limit</label>
                      <input type="number" class="form-control" name="limit" value="{{ old('limit') }}" placeholder="enter limit">
                    </div>
                  </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" title="@lang('lang.close')">
            <i class="las la-times"></i> @lang('lang.close')
        </button>
          <button type="submit" class="btn btn-primary" title="export">
            <i class="las la-file-export"></i> Export
          </button>
        </div>
      </form>
    </div>
</div>