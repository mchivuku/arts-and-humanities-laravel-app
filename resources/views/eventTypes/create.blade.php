
@extends('layouts.app')

@section('navigation-primary')
    @include('eventTypes._navigation-primary')
@endsection

@section('content')
{!! Html::beginSection($form_title,'bg-none',true) !!}

                <!-- display errors -->
                {{ Html::ul($errors->all(),array('class'=>'no-bullet')) }}


                {{ Form::open(array('action' => 'EventTypesController@store')) }}
                    @include('partials._form')

                {{ Form::close() }}
{!! Html::endSection(true) !!}

@endsection

@section('navigation-mobile')
    @include('eventTypes._navigation-mobile')
@endsection


