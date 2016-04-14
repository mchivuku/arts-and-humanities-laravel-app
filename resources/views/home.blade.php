@extends('layouts.app')

@section('content')

    <section class="section bg-gray">
        <div class="row">
            <div class="layout">
                <div class="grid halves">

                    {!! Html::dashboardPanel('Manage Events', array(array('url'=>URL::to('events'),'label'=>'view all events'))) !!}
                    {!! Html::dashboardPanel('Manage Events Types', array(array('url'=>URL::to('eventTypes'),'label'=>'view all event types'),array('url'=>URL::to('eventTypes/create'),'label'=>'create new event type'))) !!}

                    {!! Html::dashboardPanel('Manage Events Venues', array(array('url'=>URL::to('eventVenues'),'label'=>'view all event venues'),array('url'=>URL::to('eventVenues/create'),'label'=>'create new event venue'))) !!}
                    {!! Html::dashboardPanel('Manage Administrators', array(array('url'=>URL::to('admins'),'label'=>'view all administrators'),array('url'=>URL::to('admin/create'),'label'=>'add new admin'))) !!}

                </div>
            </div>
        </div>
    </section>
@endsection
