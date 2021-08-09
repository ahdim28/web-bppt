@foreach ($data['forms'] as $item)
<div class="modal fade" id="modal-read-{{ $item->id }}">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            Detail
            <span class="font-weight-light">Form</span>
            {{-- <br>
            <small class="text-muted">form is required & name is unique</small> --}}
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
        </div>
        <div class="modal-body">
          <table class="table table-bordered">
              @foreach ($data['inquiry']->inquiryField()->get() as $keyF => $field)
              <tr>
                  <th style="width: 240px;">{{ $field->fieldLang('label') }}</th>
                  <td>{!! $item->fields[$field->name] !!}</td>
              </tr>
              @endforeach
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" title="@lang('lang.close')">
            <i class="las la-times"></i> @lang('lang.close')
          </button>
          @if (!empty($item->fields['email']))
          <a href="mailto:{{ $item->fields['email'] }}?subject={{ !empty($item->fields['subject']) ? $item->fields['subject'] : 'Inquiry Form' }}"
            class="btn btn-primary">
            <i class="las la-reply"></i> Reply
          </a>
          @endif
        </div>
      </div>
    </div>
</div>
@endforeach