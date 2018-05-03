$(document).ready(function(){     
 
  var date_data = [];
  var checkbox_id;
  
  $('input[type=checkbox]').on('click', function(event){

    checkbox_id = event.target.id;
   
    if(date_data.length >= 1){
      $('#myModal1').modal('show');    
      date_data = []; 
    }
    else{
     if($('input[type=checkbox]').is(':checked')) date_data.push(checkbox_id);
    }

  });
   /*
  *  data dismiss modal event trigger
  */
  $(document).on('click', '#close', function () {    
    $('#' + checkbox_id).prop('checked', false);
     date_data = []; 
  });

  $(document).on('click', '#shop_register', function() {
    var firstname = $('input[name=firstname').val(),
        lastname = $('input[name=lastname').val(),
        username = $('input[name=username').val(),
        email = $('input[name=email').val(),
        password = $('input[name=password').val(),
        shopname = $('input[name=shopname').val(),
        zipcode = $('input[name=zipcode').val(),
        barnumber = $('input[name=barnumber').val(),
        epanumber = $('input[name=epanumber').val(),
        phonenumber = $('input[name=phonenumber').val(),
        plan = checkbox_id;
        

    var data = {

      firstname:firstname,
      lastname:lastname,
      username:username,
      email:email,
      password:password,
      shopname:shopname,
      zipcode:zipcode,
      barnumber:barnumber,
      epanumber:epanumber,
      phonenumber:phonenumber,    
      plan:plan

    };
    
    $.ajax({
        url: '/shop/register',
        method: "POST",
        data: data,
        datatype: 'json',
        cache: false,
        success: function(response) {           
          window.location.href = '/shop_owner';
        },
        error: function(xhr) {
            console.log('error', xhr);
        }
      });
  });


  /*
   *   Insurance upload
   */
   $(document).on('click', '#insurance', function() {
     console.log('click');
   });
});
