@extends('partials._navigation-primary')

@section('section_links')
<li class="first"><a href="{{ URL::to('eventTypes') }}" itemprop="url"><span
                itemprop="name">All Event Types</span></a></li>
<li><a href="{{ URL::to('eventTypes/create') }}" itemprop="url">
        <span itemprop="name">Create New Event Type</span></a>
</li>
@endsection