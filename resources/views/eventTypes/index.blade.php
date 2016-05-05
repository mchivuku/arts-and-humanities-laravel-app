@extends('layouts.app')

@section('content')
    {!! Html::beginSection("",'bg-none',true) !!}

            @if(count($collection)>0)

                {{ Form::open(array('action' => 'EventTypesController@saveOrder','method'=>'POST')) }}
                    @include("partials._table")


                {{ Form::close() }}


            @else
            <p>No event types found!</p>
            @endif
    {!! Html::endSection(true) !!}


@endsection



@section('page-js')
    <script type="text/javascript" src="{{asset("js/table.min.js")}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('table').dataTable({  "ordering": false,"info": false,aoColumnDefs: [
                {
                    bSortable: false,
                    aTargets: [ -1 ]
                }]});
        });
    </script>
@endsection