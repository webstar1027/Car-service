$(document).ready(function(){  
  console.log('ok');
  var date_data = [];
  var checkbox_id;
  $(document).on('change','#appoint', function () {

    var week_number = $(this).val(),
        id = $('#serviceofshop_id').val(),
        option = $('#appoint :selected').text();
    var data = {
        weeknumber:week_number ,
        id : id,
        option:option
    };
    console.log(data);
    $.ajax({
      url: '/service/appoint',
      method: "POST",
      data: data,
      datatype: 'json',
      cache: false,
      success: function(response) {
        window.location.href = '/service/booking/' + id;
        console.log(response);
      },
      error: function(xhr) {
          console.log('error', xhr);
      }
    });

  });
  
  $('input[type=checkbox]').on('click', function(event){

    checkbox_id = event.target.id;
    var date = $('#' + checkbox_id).val();
    var current_date = new Date();
    var compare_date = new Date(date);
    if(current_date > compare_date) {
     alert('The date has already passed.');
     $(this).prop('checked', false);
    }
    else{

      if(date_data.length >= 1) {
        if( jQuery.inArray(checkbox_id, date_data) !== -1){
          var index =  date_data.indexOf(checkbox_id);        
          date_data.splice(index, 1);              
        }
        else{
          $('#myModal').modal('show'); 
          $(this).prop('checked', false);        
        } 
      }
      else{

        if($(this).is(':checked')) {
          date_data.push(checkbox_id);        
        }
        else{
          var index =  date_data.indexOf(checkbox_id);        
          date_data.splice(index, 1);           
        }     
      }
    }
    

  });
 /*
  *  data dismiss modal event trigger
  */
  $(document).on('click', '#close', function () {
    
    $('#' + checkbox_id).prop('checked', false);
  });
  $(document).on('click', '#booking', function () {
    
    var id = $('#serviceofshop_id').val();
    if (date_data.length != 1) {
       $('#myModal1').modal('show');
    }
    else{
      var date = $('#' + date_data[0]).val();
      var data = {
         id:id,
         date:date
      };     
      $.ajax({
        url: '/service/appointment',
        method: "POST",
        data: data,
        datatype: 'json',
        cache: false,
        success: function(response) {
          window.location.href = '/booking/confirm';
          console.log(response);
        },
        error: function(xhr) {
            console.log('error', xhr);
        }
      });
     

    
    }
     
    console.log(data);
  });

});
