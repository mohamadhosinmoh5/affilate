@extends('voyager::master')

@section('head')
       @livewireStyles 
@endsection

@section('content')
       
        <livewire:crawler />
@endsection

@section('javascript')
       @livewireScripts
@endsection
