



     {{ Form::open(array('action' => 'AdministratorsController@save','class'=>'addadmin')) }}
     <div id="errors"></div>

     {!! Form::formGroup(Form::label('username', 'Username') ,
         Form::text('username')) !!}

     {!! Form::formGroup(Form::label('firstname', 'First Name') ,
        Form::text('first_name')) !!}

     {!! Form::formGroup(Form::label('lastname', 'Last Name') ,
        Form::text('last_name')) !!}

     <div class="grid right">
         <input type="button" class="button invert clear" value="Clear">
         <input type="submit" id="save" name="save" value="Save" class="button">

     </div>

     {{ Form::close() }}

     <script type="text/javascript" >

          $(document).ready(function(){
               // Add Admin
               $('form.addadmin').submit(function(event){
                    event.preventDefault();
                    $.post($(this).attr('action'),$(this).serialize(),
                            function(response){
                                 if(response==="true"){
                                      window.location.reload();
                                 }

                                 $('#errors').empty().html(response);
                                // close alert box -
                                $('.alert-box  > a.close').click(function()
                                { $(this).closest('#alert').fadeOut(); });

                            });
               });
          });

     </script>

