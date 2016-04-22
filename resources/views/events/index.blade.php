@extends('layouts.app')

@section('navigation-primary')
    @include('events._navigation-primary')
@endsection

@section('content')

     {!! Html::beginSection("Event Lookup",'bg-none',true) !!}

    <!-- Search Form -->
    {!! Form::open(array('url' => 'events','method' => 'get'),array('class'=>'filter')) !!}

    <div class="grid halves">

        {!! Form::formGroup(Form::label('event-title', 'Event Title:') ,Form::text('title','',array('id'=>'title'))) !!}
        {!! Form::formGroup(Form::label('event-date', 'Event Date:') ,Form::text('date','',array('id'=>'dpd1','class'=>'span2'))) !!}


    </div>

    {!! Form::close() !!}


     {!! Html::endSection(true) !!}

     <!-- search results -->
     {!! Html::BeginSection("",'bg-none',false,true) !!}

    <div id="search-results">
        @include('events.results')
    </div>

     {!! Html::endSection(true) !!}

@endsection


@section('page-js')
    <script type="text/javascript" src="{{asset("js/foundation-datepicker.min.js")}}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#dpd1').fdatepicker();

            //function title change
            $('#title').keyup(function() {
                   getResults();
            });

            $('#dpd1').change(function(){
                getResults();
            });
        });

        function getResults() {

            data = $('form').serialize();
            $('#search-results').html('<img src="{{asset("/css/img/ajax-loader.gif")}}"/>');

            $.get('{{Url::to("events/results")}}',data,function(content){
                 $('#search-results').empty().html(content);
                IUComm.uiModules['accordion'].init();
            });
        }






    </script>
@endsection