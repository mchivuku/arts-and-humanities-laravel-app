@extends('layouts.app')

@section('content')

        <!--- Summary -->
{!! Html::beginSection("",'bg-none') !!}
{!! Form::label('Summary') !!}<p>{!! $event->summary !!}</p>
{!! Form::label('Event Url') !!}<p>{!! Html::link($event->event_url,$event->event_url) !!}</p>
{!! Form::label('Short Description') !!} <p>{!! $event->short_description !!}</p>
{!! Form::label('Description') !!} {!! $event->description !!}
{!! Form::label('Venue') !!} <p>{!! $event->venue()->first()->description!!}</p>
{!! Form::label('Event Types') !!} <p> {!! implode(",",$event->types()->lists('description')->toArray()) !!}</p>

@if($event->student_pick=='1')
    <h6>Student Pick</h6>
@endif

@if($event->faculty_only=='1')
    <h6>Faculty Only</h6>
@endif

@if($event->faculty_enrichment=='1')
    <h6>Faculty Enrichment</h6>
@endif

{!! Form::label('Recommendation') !!} <p>{!! $event->recommendation!!}</p>

{!! Form::label('Thumbnail') !!}

@if($event->website_image_url_small!='')
    <figure class="media">
        <img src="{{URL::to("events/images/".basename($event->website_image_url_small))}}" class="th"/>
    </figure>
@else
    <figure class="media">
        <img class="th" alt="Event Photo" itemprop="image" src="{{$event->image_url_small}}">
    </figure>
@endif


{!! Form::label('Featured Image') !!}
@if(($event->website_featured!=""))

    <figure class="media">
        <img src="{{URL::to("events/images/".basename($event->website_featured))}}" class="th"/>
    </figure>
    @else
    &mdash;
@endif

{!! Html::endSection(true) !!}
@endsection

