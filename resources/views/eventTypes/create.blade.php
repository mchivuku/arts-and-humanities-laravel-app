
@extends('layouts.app')

@section('navigation-primary')
    @include('eventTypes._navigation-primary')
@endsection

@section('content')
    <section class="bg-none section" id="content">
        <div class="row">
            <div class="layout">
                <h4 class="section-title">{{$form_title}}</h4>
                <div class="full-width">

                <!-- display errors -->
                {{ Html::ul($errors->all(),array('class'=>'no-bullet')) }}


                {{ Form::open(array('action' => 'EventTypeController@store')) }}


                    <div class="form-item">

                        <div class="form-item-label">
                            {{ Form::label('description', 'Description') }}
                        </div>

                        <div class="form-item-input">
                            {{Form::text('description')}}
                        </div>

                    </div>

                    <div class="grid right">
                        <input type="submit" id="save" name="save" value="Save" class="button">
                        <input type="button"  class="button invert clear" value="Clear">
                    </div>


                {{ Form::close() }}
            </div>
            </div>
        </div>
    </section>

@endsection

@section('navigation-mobile')
    @include('eventTypes._navigation-mobile')
@endsection


