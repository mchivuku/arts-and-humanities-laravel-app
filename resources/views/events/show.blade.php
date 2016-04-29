@extends('layouts.app')

@section('content')

        <!--- Summary -->
{!! Html::beginSection("",'bg-none') !!}

<div class="artsbl-form">
    {!! Form::formgroup(Form::label('Summary') ,"<p>".$event->summary."</p>")!!}
    {!! Form::formGroup(Form::label('Event Url') ,"<h6>".Html::link($event->event_url,$event->event_url)."</h6>")!!}
    {!! Form::formGroup(Form::label('Short Description') ,
    (isset($event->short_description) && $event->short_description!="")
    ?"<p>".$event->short_description."</p>":"<p>"."&mdash;"."</p>")!!}
     <dl class="accordion" role="tablist">
        <dt role="tab" tabindex="0">{!! Form::label('Description') !!}</dt>
        <dd role="tabpanel" class="content">
            {!! $event->description !!}
        </dd>
    </dl>
    <div class="clear-both row">&nbsp;</div>
    {!! Form::formGroup(Form::label('Venue') ,"<p>". $event->venue()->first()->description."</p>")!!}

    {!! Form::formGroup(Form::label('Event Types'),count($event->types()->get())>0?
    "<p>". implode(",",$event->types()->lists('description')->toArray())."</p>":"<p>&mdash;</p>") !!}</p>

    {!! Form::formGroup(Form::label('Event attributes'),"") !!}

    <?php
        $attributes=[];
    ?>
    @if($event->student_pick=='1')
        <?php
        $attributes[] = "Student Pick";?>
    @endif

    @if($event->faculty_only=='1')
        <?php
        $attributes[] = "Faculty only";?>
    @endif

    @if($event->faculty_enrichment=='1')
        <?php
        $attributes[] = "Faculty Enrichment";?>

    @endif
    <div class="form-item-input"><p>{{implode(", ",$attributes)}}</p></div>
    {!! Form::formGroup( Form::label('Recommendation'), "<p>".$event->recommendation."</p>") !!}

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

        {!! Form::formGroup( Form::label('Review status'), "<p>".$event->review()->first()->description."</p>") !!}
        {!! Html::link("/events/edit/".$event->unique_id,"Edit",array('class'=>'button')) !!}

</div>


{!! Html::endSection(true) !!}
@endsection

