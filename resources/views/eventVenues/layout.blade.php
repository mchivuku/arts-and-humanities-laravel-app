@extends('layouts.app')

@section('navigation-primary')
    @include('eventVenues._navigation-primary')
@endsection

@section('content')
@yield('content')
    @endsection
@section('navigation-mobile')
    @include('eventVenues._navigation-mobile')
@endsection

