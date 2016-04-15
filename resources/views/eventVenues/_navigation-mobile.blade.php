@extends('partials._navigation-mobile')


@section('section_links')
    <li><a href="{{ URL::to('eventVenues') }}" itemprop="url"><span itemprop="name">All Event Venues</span></a></li>
    <li><a href="{{ URL::to('eventVenues/create') }}" itemprop="url"><span
                    itemprop="name">Create New Event Venue</span></a></li>

@endsection