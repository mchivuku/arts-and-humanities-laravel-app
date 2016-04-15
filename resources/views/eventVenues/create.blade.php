
@extends('layouts.app')

@section('navigation-primary')
    @include('eventVenues._navigation-primary')
@endsection

@section('content')

     {!! Html::renderBeginSection($form_title,'bg-none',true) !!}

        <!-- display errors -->
        {{ Html::ul($errors->all(),array('class'=>'no-bullet')) }}


        {{ Form::open(array('action' => 'EventVenuesController@store')) }}
        @include('partials._form')

        {{ Form::close() }}

    {!! Html::renderEndSection(true) !!}


@endsection

@section('navigation-mobile')
    @include('eventVenues._navigation-mobile')
@endsection


