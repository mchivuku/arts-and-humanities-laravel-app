@extends('layouts.app')

@section('content')
    {!! Html::beginSection("",'bg-none',true) !!}

            @if(count($collection)>0)
            @include("partials._table")
            @else
            <p>No event types found!</p>
            @endif
    {!! Html::endSection(true) !!}


@endsection



@section('page-js')
    <script type="text/javascript" src="{{asset("js/table.min.js")}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('table').dataTable({  "ordering": false,"info": false});
        });
    </script>
@endsection