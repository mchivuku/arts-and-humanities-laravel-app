@extends('layouts.app')
@section('navigation-primary')
@include('eventVenues._navigation-primary')
@endsection

@section('content')

{!! Html::beginSection("",'bg-none',true) !!}


@include('partials._formerrors')

    {{ Form::model($model,
    array('route' => array('eventVenues.update', $model->id),
     'method' => 'PUT')) }}
    @include('partials._form')

    {{ Form::close() }}

{!! Html::endSection(true) !!}

@endsection


