
@extends('layouts.app')


@section('content')

     {!! Html::beginSection("",'bg-none',true) !!}

     @include('partials._formerrors')

     {{ Form::open(array('action' => 'EventVenuesController@store')) }}
        @include('partials._form')

        {{ Form::close() }}

    {!! Html::endSection(true) !!}


@endsection


