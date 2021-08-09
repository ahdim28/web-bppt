@foreach ($data[$module]->field->fields as $key => $item)
@if ($item->type == 0 && $item->classes == 0)    
<div class="form-group row">
    <label class="col-form-label col-sm-2 text-sm-right">{{ $item->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control mb-1" name="field_{{ $item->name }}" value="{{ old('field_'.$item->name, $data[$module]->custom_field[$key][$item->name]) }}"
            placeholder="Enter {{ $item->label }}...">
    </div>
</div>
@elseif ($item->type == 0 && $item->classes == 1)  
<div class="form-group row">
    <label class="col-form-label col-sm-2 text-sm-right">{{ $item->label }}</label>
    <div class="col-sm-10">
        <input type="number" class="form-control mb-1" name="field_{{ $item->name }}" value="{{ old('field_'.$item->name, $data[$module]->custom_field[$key][$item->name]) }}"
            placeholder="Enter {{ $item->label }}...">
    </div>
</div>
@elseif ($item->type == 0 && $item->classes == 2)  
<div class="form-group row">
    <label class="col-form-label col-sm-2 text-sm-right">{{ $item->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control mb-1 dates" name="field_{{ $item->name }}" value="{{ old('field_'.$item->name, $data[$module]->custom_field[$key][$item->name]) }}"
            placeholder="Enter {{ $item->label }}...">
    </div>
</div>
@elseif ($item->type == 0 && $item->classes == 3)  
<div class="form-group row">
    <label class="col-form-label col-sm-2 text-sm-right">{{ $item->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control mb-1 times" name="field_{{ $item->name }}" value="{{ old('field_'.$item->name, $data[$module]->custom_field[$key][$item->name]) }}"
            placeholder="Enter {{ $item->label }}...">
    </div>
</div>
@elseif ($item->type == 0 && $item->classes == 4)  
<div class="form-group row">
    <label class="col-form-label col-sm-2 text-sm-right">{{ $item->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control mb-1 datetimes" name="field_{{ $item->name }}" value="{{ old('field_'.$item->name, $data[$module]->custom_field[$key][$item->name]) }}"
            placeholder="Enter {{ $item->label }}...">
    </div>
</div>
@elseif ($item->type == 1 && $item->classes == 0)  
<div class="form-group row">
    <label class="col-form-label col-sm-2 text-sm-right">{{ $item->label }}</label>
    <div class="col-sm-10">
        <textarea class="form-control mb-1" name="field_{{ $item->name }}" placeholder="Enter {{ $item->label }}...">{{ old('field_'.$item->name, $data[$module]->custom_field[$key][$item->name]) }}</textarea>
    </div>
</div>
@elseif ($item->type == 1 && $item->classes == 1)  
<div class="form-group row">
    <label class="col-form-label col-sm-2 text-sm-right">{{ $item->label }}</label>
    <div class="col-sm-10">
        <textarea class="form-control mb-1 tiny-mce" name="field_{{ $item->name }}" placeholder="Enter {{ $item->label }}...">{{ old('field_'.$item->name, $data[$module]->custom_field[$key][$item->name]) }}</textarea>
    </div>
</div>
@endif
@endforeach   

@section('body-field')    
<script>
    //date
    $( ".dates" ).datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
    });
    //time
    $('.times').bootstrapMaterialDatePicker({
        date: false,
        shortTime: false,
        format: 'HH:mm'
    });
    //datetime
    $('.datetimes').bootstrapMaterialDatePicker({
        date: true,
        shortTime: false,
        format: 'YYYY-MM-DD HH:mm'
    });
</script>
@endsection