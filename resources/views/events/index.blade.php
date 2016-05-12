@extends('layouts.app')

@section('content')
    {!! Html::beginSection($section_title,'bg-none',true) !!}

        <div class="grid thirds">
    <!-- status select dropdown -->
    {!! Form::formGroup(Form::label('select review type', 'Select review status') ,
    Form::select('reviewId',$reviews,$review_id,array('id'=>'review'))) !!}
        </div>

    <!-- Events table - with dataTables -->
    <div id="results">
    <table class="table table-bordered" id="events-table">
        <thead>
        <tr>
            <th>Thumbnail</th>
            <th>Summary</th>
            <th>Event Location</th>
            <th>Event Status</th>
            <th>Event Schedule</th>
            <th>Action</th>
            <th>Link</th>
        </tr>
        </thead>
    </table>
    </div>
    <div id="viewModal" class="reveal-modal" data-reveal></div>

    {!! Html::endSection(true) !!}


@endsection



@section('page-js')
    <script type="text/javascript" src="{{asset("js/table.min.js")}}"></script>
    <script type="text/javascript">
        $(function() {

            $('#review').change(function(){
                $.get("{{URL::to("events?")}}review="+$(this).val(),function(response){
                   html= $(response).find("#results").html();
                    title = $(response).find('.section-title').html();
                      $('#results').empty().html(html);
                      $('.section-title').empty().html(title);
                       DataTablesInit();
                })
            });

            DataTablesInit();
            // onselect

        });

        function DataTablesInit(){
            $('#events-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! URL::to('events/data')."?review=" !!}'+$('#review').val(),
                columns: [
                    { data: 'thumbnail', name: 'thumbnail' },
                    { data: 'summary', name: 'summary' },
                    { data: 'location', name: 'location' },
                    { data: 'status', name: 'status' },
                    { data: 'schedule', name: 'schedule' },
                    { data: 'action',name:'action'},
                    {data:'link',name:'link'}
                ]
            });

        }


    </script>
@endsection