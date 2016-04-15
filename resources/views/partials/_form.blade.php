<!-- display errors -->

<div class="form-item">

    <div class="form-item-label">
        {{ Form::label('description', 'Description') }}
    </div>

    <div class="form-item-input">
        {{Form::text('description',isset($model->description)?$model->description:"")}}
    </div>

</div>

@if (isset($model->id))
{{Form::hidden('id',$model->id)}}
@endif

<div class="grid right">
    <input type="submit" id="save" name="save" value="Save" class="button">
    <input type="button"  class="button invert clear" value="Clear">
</div>


{{ Form::close() }}