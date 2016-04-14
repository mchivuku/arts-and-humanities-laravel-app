@extends('layouts.app')

@section('navigation-primary')
    @include('eventTypes._navigation-primary')
@endsection

@section('content')
<section class="bg-none section">
    <div class="row">
        <div class="layout">
            @if(count($collection)>0)
            @include("partials._table")
            @else
            <p>No event types found!</p>
            @endif
        </div>
    </div>
</section>

@endsection

@section('navigation-mobile')
    @include('eventTypes._navigation-mobile')
@endsection

