@extends('layouts.app')

@section('navigation-primary')
    @include('eventVenues._navigation-primary')
@endsection

@section('content')
    {!! Html::renderBeginSection("",'bg-none',true) !!}


            @if(count($collection)>0)
            @include("partials._table")
            @else
            <p>No event types found!</p>
            @endif

    {!! Html::renderEndSection(true) !!}

@endsection

@section('navigation-mobile')
    @include('eventVenues._navigation-mobile')
@endsection


@section('page-js')
    <script type="text/javascript" src="{{asset("js/table.min.js")}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('table').dataTable({  "ordering": false,"info": false});
        });
    </script>
@endsection