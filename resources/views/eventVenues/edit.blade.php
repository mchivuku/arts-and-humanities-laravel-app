@extends('layouts.app')
@section('navigation-primary')
@include('eventVenues._navigation-primary')
@endsection

@section('content')

{!! Html::beginSection($form_title,'bg-none',true) !!}

        <!-- display errors -->
    {{ Html::ul($errors->all(),array('class'=>'no-bullet')) }}

    {{ Form::model($model, array('route' => array('eventVenues.update', $model->id),
     'method' => 'PUT')) }}
    @include('partials._form')

    {{ Form::close() }}

{!! Html::endSection(true) !!}

@endsection

@section('navigation-mobile')
    @include('eventVenues._navigation-mobile')
@endsection


