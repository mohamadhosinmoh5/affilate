@extends('voyager::master')

@section('head')
       @livewireStyles 
@endsection

@section('content')
       {{-- @livewire('crawler', ['user' => Auth::user()], key(Auth::user()->id)) --}}
        <livewire:crawler />
@endsection

@section('javascript')
       @livewireScripts
@endsection
