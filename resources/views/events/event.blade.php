<article class="event item">
      <figure class="media">
            <img class="th" alt="Event Photo" itemprop="image" src="{{$event->image_url_small}}">
        </figure>

    <div class="content">
        <h1 class="title">{{$event->summary}}</h1>

        <dl class="accordion" role="tablist">
            <dt role="tab" tabindex="0">Schedule</dt>
            <dd role="tabpanel" class="content">
                @foreach($event->schedules as $s)
                    <p class="meta date">{{$s}}</p>
                @endforeach
            </dd>
        </dl>

        @if($event->types!="")
            <p class=" event-type">Event type: {{$event->types}}</p>
        @endif
        @if($event->venue!="")
            <p class=" event-venue">Event venue: {{$event->venue}}</p>
        @endif

        <p class="inline" style="margin-top: 20px;">
            <a class="button " href="#">More Details </a>&nbsp;
            <a class="button " href="{{Url::to("/events/edit",array('id'=>$event->id))}}">Edit</a></p>
    </div>


</article>