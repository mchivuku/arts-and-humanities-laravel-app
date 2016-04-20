<!-- display errors -->

{!! Form::formGroup(Form::label('description', 'Description') ,
Form::text('description',isset($model->description)?$model->description:"")) !!}

@if (isset($model->id))
{{Form::hidden('id',$model->id)}}
@endif

<div class="grid right">
    <input type="submit" id="save" name="save" value="Save" class="button">
    <input type="button"  class="button invert clear" value="Clear">
</div>


{{ Form::close() }}