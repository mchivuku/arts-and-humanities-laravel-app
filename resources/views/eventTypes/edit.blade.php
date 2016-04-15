
@extends('layouts.app')
@section('navigation-primary')
    @include('eventTypes._navigation-primary')
@endsection

@section('content')
{!! Html::renderBeginSection($form_title,'bg-none',true) !!}


        <!-- display errors -->
                    {{ Html::ul($errors->all(),array('class'=>'no-bullet')) }}

                    {{ Form::model($model, array('route' => array('eventTypes.update', $model->id),
                     'method' => 'PUT')) }}
                    @include('partials._form')

                    {{ Form::close() }}
{!! Html::renderEndSection(true) !!}

@endsection

@section('navigation-mobile')
    @include('eventTypes._navigation-mobile')
@endsection


