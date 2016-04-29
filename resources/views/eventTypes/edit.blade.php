
@extends('layouts.app')


@section('content')
{!! Html::beginSection($form_title,'bg-none',true) !!}

{{ Form::model($model, array('route' => array('eventTypes.update', $model->id),
                     'method' => 'PUT')) }}

@include('partials._formerrors')
                    @include('partials._form')

                    {{ Form::close() }}
{!! Html::endSection(true) !!}

@endsection


