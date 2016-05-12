<?php
$first = reset($collection);
$columns =array_filter(array_keys($first),function($item){
  return $item!='id';
});


?>

<table class="mobile-labels">
    <thead>
    <tr>
        @foreach($columns as $col)
            <td><?php echo ucwords($col);?></td>
        @endforeach
        <td><a href="#" id="edit-order" style="text-decoration:underline;">Edit Order</a>
            <a href="#" id="save-order" class="inline-button">Save Order</a> </td>
    </tr>
    </thead>
    <tbody>

    @foreach($collection as  $value)
        <tr>
            @foreach($columns as $col)

               <td data-label="{{$col}}">{!!$value[$col]!!}</td>
            @endforeach
            <td class="disabled">
                <span class="table-up up-arrow">&#8593;</span>
                <span class="table-down down-arrow">&#8595;	</span>
                <input type="hidden" name="id[]" value="{!!$value['id']!!}"/>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
