

<input @if($row->required == 1) required @endif type="text" class="form-control datePersion{{ $row->field }}"
value="@if(isset($dataTypeContent->{$row->field})){{ \Carbon\Carbon::parse(old($row->field, $dataTypeContent->{$row->field}))->format('Y-m-d') }}@else{{old($row->field)}}@endif"  name="{{ $row->field }}">
       {{-- {{$date}} --}}
{{-- <input type="hidden" name="{{ $row->field }}" class="dateEn{{ $row->field }}" value="{{old($row->field)}}"> --}}
<script>
  var $dateField = $(".datePersion{{ $row->field }}");
  var $dateEnField = $(".dateEn{{ $row->field }}");
  $dateField.pDatepicker({
    initialValueType: "persian",
    format: "YYYY/MM/DD",
    onSelect: "year",
    persianDigit:true,
    calendar:{
       persian:{
        locale:'en'
       }
    }
  });


</script>