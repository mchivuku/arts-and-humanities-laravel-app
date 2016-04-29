@foreach($posts as $post)

<article itemtype="http://schema.org/Event" itemscope="itemscope" class="event item">
    <div class="content">
        <h1><a href="{{$post['guid']}}" itemprop="url" class="external">
            <span itemprop="name">{{$post['post_title']}}</span></a></h1>

        <p class="meta date">{{$post['post_date']}}</p>
        <div itemprop="description">
            {!! $post['post_content'] !!}...<a href="{{$post['guid']}}" itemprop="url" class="external">Read More &#187;</a>
            <p></p>
        </div>

    </div>
</article>

@endforeach
<a href="http://viewpoints.iu.edu/art-at-iu/" class="more button external">Read more Art at IU</a>