@if(isset($events['data']) && count($events['data'])>0)
<div id="filter-results">
    @if(isset($events['data']))
        <h4>Search Results:</h4>
    @endif
    @foreach($events['data'] as $event)
        @include('events.event',array('event'=>$event))
    @endforeach
</div>
@endif
@if(isset($events['links']))
<div class="pagination-centered">
    <?php echo $events['links'];?>
</div>
@endif