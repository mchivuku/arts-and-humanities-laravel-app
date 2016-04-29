@if(count($schedules)>1)
           @foreach($schedules as $s)
                <p class="meta date">{{$s}}</p>
            @endforeach
@else
    <p class="meta date">{{$schedules[0]}}</p>
@endif