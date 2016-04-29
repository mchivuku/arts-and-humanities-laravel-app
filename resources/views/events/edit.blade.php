@extends('layouts.app')

@section('content')
{!! Html::beginSection("",'bg-none',false,true) !!}

<!-- display errors -->

{{Form::open(array('url'=>'events/update','files' => true, 'method' => 'post',
'class'=>'artsbl-form'))}}

@include('partials._formerrors')

{!! Form::formGroup(Form::label('Summary') ,Form::text('summary',$event->summary,
array('readonly'=>'readonly')))!!}

{!! Form::formGroup(Form::label('Event Url') ,"<h6>".Html::link($event->event_url,$event->event_url)."</h6>")!!}

<dl class="accordion" role="tablist">
    <dt role="tab" tabindex="0">{!! Form::label('Description') !!}</dt>
    <dd role="tabpanel" class="content">
        {!! $event->description !!}
    </dd>
</dl>


{!! Form::formGroup(Form::label('Short description') ,Form::textarea('short_description',$event->short_description,
array('class'=>'ckeditor')))!!}



{!! Form::formGroup(Form::label('Location') ,Form::text('location',$event->location,
array('readonly'=>'readonly')))!!}
{!! Form::formGroup(Form::label('Event venue') ,Form::select('venue',$venues,$event->venue_id))!!}

{!! Form::formGroup(Form::label('Event type') ,
Form::select('event_types',$types,$event->types()->lists('id')->toArray()
                ,array('multiple'=>'multiple','name'=>'event_types[]')))!!}

<hr/>

<h5>Choose Thumbnail</h5>

@if(isset($event->image_url_small) && $event->image_url_small!="")
    {!! Form::label('Thumbnail') !!}
    <figure class="media">
        <img class="th modal" alt="Event Photo" itemprop="image" src="{{$event->image_url_small}}"
             data-reveal-id="thumbnailModal">
    </figure>

    <!-- Thumbnail Modal -->
    <div id="thumbnailModal" class="reveal-modal" data-reveal>
        <figure class="media">
            <img class="th" alt="Event Photo" itemprop="image" src="{{$event->image_url_small}}">
        </figure>
        <a class="close-reveal-modal" aria-label="Close">&#215;</a>

    </div>
    @endif

            <!-- Website Thumbnail -->
    @if(isset($event->website_image_url_small)  && $event->website_image_url_small!="")
        {!! Form::label('Website Thumbnail') !!}
        <figure class="media">
            <img height="200" width="200"
                 src="{{URL::to("events/images/".basename($event->website_image_url_small))}}"
                 class="th modal" data-reveal-id="websiteThumbnail"/>
        </figure>

        <!-- Thumbnail Modal -->
        <div id="websiteThumbnail" class="reveal-modal" data-reveal>
            <figure class="media">
                <img
                        src="{{URL::to("events/images/".basename($event->website_image_url_small))}}"
                />
            </figure>
            <a class="close-reveal-modal" aria-label="Close">&#215;</a>

        </div>
        @endif

                <!-- Website Thumbnail -->
        <div class="form-item">
            <div class="form-item-label">
                <label for="file-upload">Choose a thumbnail (for website - 200x200):</label>
            </div>
            <div class="form-item-input">
                <input type="file" name="website_thumbnail" id="website_thumbnail"/>
            </div>
        </div>

        <hr/>

          <div class="form-item">

            <div class="form-item-label">
                <label for="choose attributes">Choose Attributes</label>
            </div>

            <div class="form-item-input">
                {!! Form::checkbox('student_pick',1,
                                    (isset($event->student_pick)?$event->student_pick:"")) !!}
                <label for="student_pick">Student Pick</label>
                {!! Form::checkbox('faculty_only',1,
                                (isset($event->faculty_only)?$event->faculty_only:"")) !!}
                <label for="student_pick">Faculty Only</label>
                {!!  Form::checkbox('faculty_enrichment',1,
                                (isset($event->faculty_enrichment)?$event->faculty_enrichment:"")) !!}
                <label for="faculty_enrichment">Faculty Enrichment</label>
            </div>

            </div>

            <hr/>
            {!! Form::formgroup(Form::label('Recommendation'),  Form::textarea('recommendation',
                                   isset($event->recommendation)?$event->recommendation:"",
                                   array('class'=>'ckeditor')) ) !!}


            {!! Form::hidden('id',$event->unique_id) !!}

            <!-- Approve -->
            {!! Form::label('Review status') !!}
            {!! Form::select('reviewId',$reviews,$event->review_id)  !!}



            <ul class="button-group right">
                <li> {!! Html::link("/events","Cancel",array('class'=>'button invert')) !!}</li>
                <li><input type="submit" id="save" name="save" value="Save" class="button"></li>

            </ul>

            {{Form::close()}}

            {!! Html::endSection(true) !!}
            @endsection

            @section('page-js')
                <script src="//cdn.ckeditor.com/4.5.8/standard/ckeditor.js"></script>
        @endsection
