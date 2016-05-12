{!! Form::formGroup(Form::label('username', 'Username') ,
        "<p>".$model->username."</p>") !!}

{!! Form::formGroup(Form::label('firstname', 'First Name') ,
   "<p>".$model->first_name."</p>") !!}

{!! Form::formGroup(Form::label('lastname', 'Last Name') ,
 "<p>".$model->last_name."</p>") !!}