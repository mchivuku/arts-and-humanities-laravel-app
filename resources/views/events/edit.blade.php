@extends('layouts.app')

@section('content')
{!! Html::beginSection("",'bg-none',false,true) !!}
        <!-- display errors -->

{{Form::open(array('url'=>'events/update','files' => true, 'method' => 'post'))}}

@include('partials._formerrors')
 <!--- Summary -->
<div class="row">
    <div class="small-8 large-10 columns">
        <div class="row">
            <div class="small-3 large-2  columns">
                {!! Form::label('Summary') !!}
            </div>
            <div class="small-9 large-10  columns">
                {!! Form::text('summary',$event->summary,array('readonly'=>'readonly')) !!}
            </div>
        </div>
    </div>
</div>

<!-- Event Url -->
<div class="row">
    <div class="small-8 large-10 columns">
        <div class="row">
            <div class="small-3 large-2 columns">
                {!! Form::label('Event Url') !!}
            </div>
            <div class="small-9 large-10 columns">
                <span> {!! Html::link($event->event_url,$event->event_url) !!}</span>
            </div>
        </div>
    </div>
</div>

<!-- Description-->
<div class="row">
    <div class="small-8 large-10 columns">
        <div class="row">
            <div class="small-3 large-2  columns">
                {!! Form::label('Description') !!}
            </div>
            <div class="small-9 large-10 columns">
                <span> {!! $event->description !!}</span>
            </div>
        </div>
    </div>
</div>


<!-- Short Description-->
<div class="row">
    <div class="small-8 large-10 columns">
        <div class="row">
            <div class="small-3 large-2 columns">
                {!! Form::label('Short description') !!}
            </div>
            <div class="small-9 large-10 columns">
                {!! Form::textarea('short_description',$event->short_description,
                array('class'=>'ckeditor'))  !!}
            </div>
        </div>
    </div>
</div>

<div class="row">&nbsp;</div>
<!-- Location -->
<div class="row">
    <div class="small-8 large-10 columns">
        <div class="row">
            <div class="small-3 large-2 columns">
                {!! Form::label('Location') !!}
            </div>
            <div class="small-9 large-10 columns">
                {!! Form::text('location',$event->location,array('class'=>'readonly'))  !!}
            </div>
        </div>
    </div>
</div>


<!-- Venues -->
<div class="row">
    <div class="small-8 large-10 columns">
        <div class="row">
            <div class="small-3 large-2 columns">
                {!! Form::label('Event venue') !!}
            </div>
            <div class="small-9 large-10 columns">
                {!! Form::select('venue',$venues,$event->venue_id) !!}
            </div>
        </div>
    </div>
</div>

<!-- Types -->
<div class="row">
    <div class="small-8 large-10 columns">
        <div class="row">
            <div class="small-3 large-2 columns">
                {!! Form::label('Event type') !!}
            </div>
            <div class="small-9 large-10 columns">

                {{Form::select('event_types',$types,$event->types()->lists('id')->toArray(),array('multiple'=>'multiple','name'=>'event_types[]'))}}

            </div>
        </div>
    </div>
</div>

<!-- Thumbnail -->
<div class="row">
    <div class="small-8 large-10 columns">
        <div class="row">
            <div class="small-3 large-2 columns">
                {!! Form::label('Thumbnail') !!}
            </div>
            <div class="small-9 large-10 columns">
                <figure class="media">
                    <img class="th" alt="Event Photo" itemprop="image" src="{{$event->image_url_small}}">
                </figure>
            </div>
        </div>
    </div>
</div>


<!-- Website Thumbnail -->
@if(isset($event->website_image_url_small))
    <div class="row">
        <div class="small-8 large-10 columns">
            <div class="row">
                <div class="small-3 large-2 columns">
                    {!! Form::label('Website Thumbnail') !!}
                </div>
                <div class="small-9 large-10 columns">
                    <figure class="media">
                        <img src="{{URL::to("events/images/".basename($event->website_image_url_small))}}" class="th"/>
                    </figure>
                </div>
            </div>
        </div>
    </div>
    @endif


            <!-- Choose a different thumbnail -->
    <div class="row">
        <div class="small-8 large-10 columns">
            <div class="row">
                <div class="small-3 large-2 columns">
                    {!! Form::label('Choose a different thumbnail (for website)') !!}
                </div>
                <div class="small-9 large-10 columns">
                    {!! Form::file('website_thumbnail') !!}
                </div>
            </div>
        </div>
    </div>


    <!-- Website Thumbnail -->
    @if(isset($event->website_featured))
        <div class="row">
            <div class="small-8 large-10 columns">
                <div class="row">
                    <div class="small-3 large-2 columns">
                        {!! Form::label('Website Featured') !!}
                    </div>
                    <div class="small-9 large-10 columns">
                        <figure class="media">
                            <img src="{{URL::to("events/images/".basename($event->website_featured))}}" class="th"/>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
        @endif

                <!-- Choose a featured image -->
        <div class="row">
            <div class="small-8 large-10 columns">
                <div class="row">
                    <div class="small-3 large-2 columns">
                        {!! Form::label('Website Featured Image') !!}
                    </div>
                    <div class="small-9 large-10 columns">
                        {!! Form::file('website_featured') !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Pick -->
        <div class="row">
            <div class="small-2 large-2 columns">
                <div class="row">
                    <div class="small-3 large-3 columns">
                        {!! Form::label('Student Pick') !!}

                    </div>
                    <div class="small-2 large-1 columns">
                        {!! Form::checkbox('student_pick',1,
                        (isset($event->student_pick)?$event->student_pick:"")) !!}
                    </div>

                </div>
            </div>
        </div>


        <!-- Faculty Only -->
        <div class="row">
            <div class="small-2 large-2 columns">
                <div class="row">
                    <div class="small-3 large-3 columns">
                        {!! Form::label('Faculty Only') !!}

                    </div>
                    <div class="small-2 large-1 columns">
                        {!! Form::checkbox('faculty_only',1,
                        (isset($event->faculty_only)?$event->faculty_only:"")) !!}
                    </div>

                </div>
            </div>
        </div>



        <!-- Faculty enrichment -->
        <div class="row">
            <div class="small-2 large-2 columns">
                <div class="row">
                    <div class="small-3 large-3 columns">
                        {!! Form::label('Faculty Enrichment') !!}

                    </div>
                    <div class="small-2 large-1 columns">
                        {!! Form::checkbox('faculty_enrichment',1,
                        (isset($event->faculty_enrichment)?$event->faculty_enrichment:"")) !!}
                    </div>

                </div>
            </div>
        </div>

        <!-- Recommendation Text -->

        <div class="row">
            <div class="small-8 large-10 columns">
                <div class="row">
                    <div class="small-2 large-2 columns">
                        {!! Form::label('Recommendation') !!}
                    </div>
                    <div class="small-9 large-9 columns">
                        {!! Form::textarea('recommendation',
                        isset($event->recommendation)?$event->recommendation:"",
                        array('class'=>'ckeditor'))  !!}
                    </div>
                </div>
            </div>
        </div>

        {!! Form::hidden('id',$event->unique_id) !!}
        <div class="row">&nbsp;</div>
        <div class="grid right">
            <input type="submit" id="save" name="save" value="Save" class="button">
            <input type="button" class="button invert clear" value="Clear">
        </div>

        {{Form::close()}}

        {!! Html::endSection(true) !!}
        @endsection

@section('page-js')
    <script src="//cdn.ckeditor.com/4.5.8/standard/ckeditor.js"></script>
@endsection
