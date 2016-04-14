<?php
$first = reset($collection);
$columns = array_keys($first);

?>

<table class="mobile-labels">
    <thead>
    <tr>
        @foreach($columns as $col)
            <td>{{$col}}</td>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($collection as  $value)
        <tr>
            @foreach($columns as $col)
               <td data-label="{{$col}}">{!!$value[$col]!!}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
