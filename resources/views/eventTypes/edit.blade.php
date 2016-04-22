
@extends('layouts.app')


@section('content')
{!! Html::beginSection($form_title,'bg-none',true) !!}



@include('partials._formerrors')

                    {{ Form::model($model, array('route' => array('eventTypes.update', $model->id),
                     'method' => 'PUT')) }}
                    @include('partials._form')

                    {{ Form::close() }}
{!! Html::endSection(true) !!}

@endsection


