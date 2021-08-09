<div class="modal fade" id="modals-change-photo">
    <div class="modal-dialog">
      <form class="modal-content" action="{{ route('profile.photo.change') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title">
            @lang('lang.change')
            <span class="font-weight-light">@lang('mod/users.user.label.field10')</span>
            {{-- <br>
            <small class="text-muted">form is required & name is unique</small> --}}
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
        </div>
        <div class="modal-body">
            <div class="form-row">
              <div class="form-group col">
                <label class="form-label">@lang('mod/users.user.label.field10')</label>
                <label class="custom-file-label" for="upload-2"></label>
                <input type="hidden" name="old_avatars" value="{{ $data['user']->profile_photo_path['filename'] }}">
                <input class="form-control custom-file-input file @error('avatars') is-invalid @enderror" type="file" id="upload-2" lang="en" name="avatars">
                @include('components.field-error', ['field' => 'avatars'])
                <small class="text-muted">
                    File Type : <strong>{{ Str::upper(config('custom.files.avatars.mimes')) }}</strong>, 
                    Pixel : <strong>{{ Str::upper(config('custom.files.avatars.pixel')) }}</strong>, 
                    Max Size : <strong>{{ Str::upper(config('custom.files.avatars.size')) }} Kilobyte</strong>
                </small>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col mb-0">
                <label class="form-label">@lang('mod/users.user.label.field10_1')</label>
                <input type="text" class="form-control" name="photo_title" value="{{ old('photo_title', $data['user']->profile_photo_path['title']) }}" 
                  placeholder="@lang('mod/users.user.placeholder.field10_1')">
              </div>
              <div class="form-group col mb-0">
                <label class="form-label">@lang('mod/users.user.label.field10_2')</label>
                <input type="text" class="form-control" name="photo_alt" value="{{ old('photo_alt', $data['user']->profile_photo_path['alt']) }}" 
                  placeholder="@lang('mod/users.user.placeholder.field10_2')">
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
