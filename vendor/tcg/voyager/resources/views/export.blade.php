@extends('voyager::master')

@section('css')
<style>
    .nav-box{
        margin-top: 20px;
    }
    label{
        margin: 10px 0 ;
    }

    .table{
        text-wrap: nowrap;
    }

    .row > [class*="col-"] {
        margin-bottom: 10px !important;
    }

    .dateLable{
        font-size: 16px;
        padding: 20px
    }
</style>
@stop

@section('content')
<div class="row">
    @livewire('export-data')
</div>
@stop


@section('javascript')
<script src="{{asset('assets/js/persianDate.js')}}"></script>
{{-- <script src="{{asset('assets/js/persianDate.js')}}"></script> --}}
<script src="{{asset('assets/js/date.js')}}"></script>
<script src="{{asset('assets/js/toExel.js')}}"></script>
<script>
 
function exel(){
    $("#customers_table").table2excel({
    exclude: ".excludeThisClass",
    name: "Worksheet Name",
    filename: "SomeFile.xls", // do include extension
    preserveColors: false // set to true if you want background colors and font colors preserved
});

}


</script>
<script src="{{url('assets')}}/js/table.js"></script>
@endsection