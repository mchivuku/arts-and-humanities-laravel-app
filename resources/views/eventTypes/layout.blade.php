@extends('layouts.app')

@section('navigation-primary')
    @include('eventTypes._navigation-primary')
@endsection

@section('content')
@yield('content')
    @endsection
@section('navigation-mobile')
    @include('eventTypes._navigation-mobile')
@endsection

