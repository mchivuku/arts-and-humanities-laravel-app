

    <aside class="section-nav hide-for-medium-down show-for-large-up"
           id="section-nav">
        <div class="row">
            <nav itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement"
                 data-parent-url="{{URL::to('/')}}">
                <ul>

                    <li class="{{Request::url()=='events'?'current-trail current-parent':""}}"><a href="{{URL::to('events')}}" itemprop="url" class="{{strpos(Request::url(),'events')!==false?'current-trail current':""}}">
                            <span itemprop="name">Manage Events</span></a></li>
                    <li class="{{strpos(Request::url(),'eventTypes')!==false?'current-trail current-parent':""}}"><a href="{{URL::to('eventTypes')}}" itemprop="url" class="{{(Request::path()=='eventTypes')?'current-trail current':""}}">
                            <span itemprop="name">Manage Event Types</span></a>
                        <ul class="children">
                            <li class="{{strpos(Request::url(),'eventTypes')!==false?'current-trail current-parent':""}}"><a href="{{URL::to('eventTypes/create')}}" itemprop="url" class="{{(Request::path()=='eventTypes/create')?'current-trail current':""}}">
                                    <span itemprop="name">Create New Event Type</span></a></li>
                        </ul>

                    </li>

                    <li class="{{strpos(Request::url(),'eventVenues')!==false?'current-trail current-parent':""}}"><a href="{{URL::to('eventVenues')}}" itemprop="url" class="{{Request::path()=='eventVenues'?'current-trail current':""}}">
                            <span itemprop="name">Manage Event Venues</span></a>
                        <ul class="children">
                            <li class="{{strpos(Request::url(),'eventVenues')!==false?'current-trail current-parent':""}}"><a href="{{URL::to('eventVenues/create')}}" itemprop="url" class="{{Request::path()=='eventVenues/create'?'current-trail current':""}}">
                                    <span itemprop="name">Create New Event Venue</span></a></li>
                        </ul>

                    </li>
                </ul>
            </nav>
        </div>
    </aside>
