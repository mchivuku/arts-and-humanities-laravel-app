<!DOCTYPE HTML>
<html class="no-js ie9" itemscope="itemscope" itemtype="http://schema.org/WebSite" lang="en">
<head prefix="og: http://ogp.me/ns# profile: http://ogp.me/ns/profile# article: http://ogp.me/ns/article#">
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Bloomington Arts and Humanities:&#160;Indiana University Bloomington</title>
    <meta content="arts, culture, humanities, what’s on, things to do, explore, experience" name="keywords"/>
    <meta content="IU Bloomington’s thriving arts scene and unrivaled breadth and depth of humanities experiences are worth experiencing."
          name="description"/>

    <meta content="IE=edge" http-equiv="X-UA-Compatible"/>
    <link href="https://assets.iu.edu/favicon.ico" rel="shortcut icon" type="image/x-icon"/>
    <link href="https://virtual.iu.edu/index.html" itemprop="url" rel="canonical"/>
    <meta content="https://virtual.iu.edu/images/hero-showalterfountain-cropped.jpg" property="og:image"/>
    <meta content="Bloomington Arts and Humanities" property="og:title"/>
    <meta content="IU Bloomington’s thriving arts scene and unrivaled breadth and depth of humanities experiences are worth experiencing."
          property="og:description"/>
    <meta content="website" property="og:type"/>
    <meta content="https://virtual.iu.edu/index.html" property="og:url"/>
    <meta content="Bloomington Arts and Humanities" property="og:site_name"/>
    <meta content="en_US" property="og:locale"/>

    <meta content="https://virtual.iu.edu/images/hero-showalterfountain-cropped.jpg" name="twitter:image:src"/>
    <meta content="Bloomington Arts and Humanities" name="twitter:title"/>
    <meta content="IU Bloomington’s thriving arts scene and unrivaled breadth and depth of humanities experiences are worth experiencing."
          name="twitter:description"/>
    <meta content="summary_large_image" name="twitter:card"/>
    <meta content="@IUBloomington" name="twitter:site"/>
    <meta content="@IUBloomington" name="twitter:creator"/>
    <meta content="https://virtual.iu.edu/images/hero-showalterfountain-cropped.jpg" itemprop="image"/>
    <meta content="Bloomington Arts and Humanities" itemprop="name"/>
    <meta content="IU Bloomington’s thriving arts scene and unrivaled breadth and depth of humanities experiences are worth experiencing."
          itemprop="description"/>


    <?php $_GET['path'] = 'css.html';include('includer.php')?>

    <?php $_GET['path'] = 'javascript-head.html';include('includer.php')?>


</head>
<body class="mahogany" id="home">


<div id="skipnav">
    <ul>
        <li><a href="#content">Skip to Content</a></li>
        <li><a href="#nav-main">Skip to Main Navigation</a></li>
        <li><a href="#search">Skip to Search</a></li>
    </ul>
    <hr>
</div>


<div></div>
<div class="off-canvas-wrap" data-offcanvas="">


    <?php include "gwassets/brand/2.x/header-iub.html"; ?>
    <?php include "gwassets/search/2.x/search.html"; ?>


    <div class="inner-wrap">

        <!-- Header -->
        <header itemscope="itemscope" itemtype="http://schema.org/CollegeOrUniversity">
            <div class="row pad">
                <h1 itemprop="department"><a href="https://artsbl.webtest.iu.edu/laravel/index.php">
                        <span>Bloomington Arts &amp; Humanities - Admin </span></a></h1>
            </div>
        </header>


        @yield('navigation-primary')

        <main class="no-section-nav" role="main">

            @yield('content')

        </main>


        <?php include "gwassets/brand/2.x/footer.html"; ?>
    </div><!-- /.inner-wrap -->
    <div class="right-off-canvas-menu show-for-medium-down hide-for-large-up">
        <div class="search-box off-canvas-padding" id="off-canvas-search"></div>
        @yield('navigation-mobile')
    </div>


</div><!-- /.off-canvas-wrap -->


<?php $_GET['path'] = 'javascript.html';include("includer.php");?>

</body>
</html>