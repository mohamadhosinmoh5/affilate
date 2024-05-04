<!-- resources/views/excel-import.blade.php -->
 
@extends('voyager::master')
 
@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
 
    <form action="{{ route('importExcel') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="file">انتخاب فایل</label>
            <input type="file" name="file" id="file" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">اپلود فایل اکسل</button>
    </form>
</div>
@endsection