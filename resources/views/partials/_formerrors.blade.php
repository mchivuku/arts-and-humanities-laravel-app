<!-- display errors -->

@if(count($errors->all())>0)

    <div class="text" id="alert">
        <div data-alert class="alert-box alert radius">
            {{ Html::ul($errors->all(),array('class'=>'no-bullet')) }}
            <a href="#" class="close">&times;</a>
        </div>
    </div>


 @endif