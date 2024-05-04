@extends('voyager::master')

@section('css')

@endsection
@section('content')
    <nav class="nav">
         <ul class="">
                @foreach ($notifs as $item)
                    <li>
                        @if ($item->day_avg > 0 )
                            <div class="alert alert-warning">
                                مدت {{$item->day_avg}} روز تا پایان قرار داد {{ $item->title}}     باقی مانده است .
                                <a href="{{url('')}}/admin/delivery-terminations">جهت تحویل یا خاتمه اقدام کنید </a>
                            </div>
                        @else
                            <div class="alert alert-danger">
                                مدت {{ $item->day_last}}روز از قرار داد {{ $item->title}} گذشته است
                                <a href="{{url('')}}/admin/papers/create">جهت ارسال نامه کلیک کنید </a> 
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
            <div class="row text-center">
                {{$notifs->links('pagination::bootstrap-4')}}
            </div>
    </nav>
@stop