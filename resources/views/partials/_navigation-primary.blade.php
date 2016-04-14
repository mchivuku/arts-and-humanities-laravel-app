<nav role="navigation" aria-label="Main navigation" id="nav-main" itemscope="itemscope"
     itemtype="http://schema.org/SiteNavigationElement" class="main hide-for-medium-down show-for-large-up dropdown">

    <ul class="row pad">
        <li class="show-on-sticky home"><a href="{{ URL::to('/') }}">Home</a></li>
        @yield('section_links')
    </ul>
</nav>