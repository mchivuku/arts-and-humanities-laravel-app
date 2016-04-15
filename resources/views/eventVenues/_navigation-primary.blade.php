@extends('partials._navigation-primary')

@section('section_links')
<li class="first"><a href="{{ URL::to('eventVenues') }}" itemprop="url"><span
                itemprop="name">All Event Venues</span></a></li>
<li><a href="{{ URL::to('eventVenues/create') }}" itemprop="url">
        <span itemprop="name">Create New Event Venue</span></a>
</li>
@endsection