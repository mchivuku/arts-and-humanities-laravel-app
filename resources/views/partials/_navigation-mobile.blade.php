
<nav class="mobile off-canvas-list" role="navigation" aria-label="Mobile navigation" itemscope="itemscope"
     itemtype="http://schema.org/SiteNavigationElement">
    <ul class=" has-children current-trail">
        <li><a href="{{URL::to('events')}}" itemprop="url" tabindex="1"><span
                        itemprop="name">Manage All Events</span></a>

            <ul class="children">
                <li>
                    <a href="{{URL::to('events/pending')}}"
                       itemprop="url" tabindex="1">
                        <span itemprop="name">Pending Events</span></a>
                </li>
                <li>
                    <a href="{{URL::to('events/approved')}}"
                       itemprop="url" tabindex="1">
                        <span itemprop="name">Approved Events</span></a>
                </li>
            </ul>

        </li>
        <li class="has-children current-trail ">
            <a href="{{URL::to('eventTypes')}}" itemprop="url" tabindex="1"><span
                        itemprop="name">Manage Event Types</span><a href="#" class="more" tabindex="1">More about
                    event types</a></a>
            <ul class="children">
                <li>
                    <a href="{{URL::to('eventTypes/create')}}" itemprop="url" tabindex="1"><span itemprop="name">Create new event type</span></a>
                </li>
            </ul>
        </li>

        <li class="has-children current-trail">
            <a href="{{URL::to('eventVenues')}}" itemprop="url" tabindex="1"><span itemprop="name">Manage Event Venues</span><a
                        href="#" class="more" tabindex="1">More about event venues</a></a>
            <ul class="children">
                <li>
                    <a href="{{URL::to('eventVenues/create')}}" itemprop="url" tabindex="1"><span itemprop="name">Create new event venue</span></a>
                </li>
            </ul>
        </li>

    </ul>
</nav>