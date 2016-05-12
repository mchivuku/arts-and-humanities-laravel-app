@extends('layouts.app')


@section('content')
    {!! Html::beginSection("",'bg-none',true) !!}

    <div class="grid thirds ">
        <a data-reveal-id="viewModal" href="{{URL::to("admins/add")}}" class="button right modal" title="Add New Administrator">Add New Administrator</a>
    </div>

    <table class="table table-bordered" id="admins-table">
        <thead>
        <tr>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Date</th>
            <th>Updated By</th>
            <th>Action</th>
        </tr>
        </thead>
    </table>

    <div id="viewModal" class="reveal-modal" data-reveal></div>

    {!! Html::endSection(true) !!}

@endsection


@section('page-js')
    <script type="text/javascript" src="{{asset("js/table.min.js")}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            $('#admins-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! URL::to('admins/data') !!}',
                columns: [
                    { data: 'username', name: 'username' },
                    { data: 'first_name', name: 'first_name' },
                    { data: 'last_name', name: 'last_name' },
                    { data: 'date', name: 'date' },
                    { data: 'update_user', name: 'update_user' },
                    { data: 'action',name:'action'},

                ]
            });

        });

    </script>
@endsection