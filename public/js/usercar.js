$(document).ready(function(){  
   var remove_flag = false;
   $('.remove-usercar').change(function(){
     if($(this).is(':checked')){
       $('#myModal').modal('show');
     }
    
   });
   $('.number_save').click(function(){
      remove_flag = true;
   });
   $('.cancel').click(function(){
     console.log('cancel');
     $('input[type=checkbox]').prop('checked', false);
   });
   $(document).on('click', '#change', function () {
      
      console.log(remove_flag);

   		if($('input[type=checkbox]').is(':checked') ){
   			var id = $('input[type=checkbox]').val();
   			window.location.href = '/delete/userprofile/'+id;
       
   		}
   		else{
   			var current_mileage = $('#current_mileage').val(),
   			    annual_miles = $('#annual_miles').val(),
            description_name = $('#description_name').val(),
   			    userofcar_id = $('#userofcar_id').val();

   			var notification_status = [],
            notification_type = [];

            var oil_change = $('#oil_change option:selected').val(),
              transmission = $('#transmission option:selected').val(),
              general_inspection = $('#general_inspection option:selected').val(),
              brake_check = $('#brake_check option:selected').val(),
              tire_check = $('#tire_check option:selected').val();
              
              if(oil_change != 0) {
                notification_status.push(oil_change);
                notification_type.push('oil change');
              } 
              if(transmission != 0) {
                notification_status.push(transmission);
                notification_type.push('transmission');
              } 
              if(general_inspection != 0) {
                notification_status.push(general_inspection);
                notification_type.push('general inspection');
              } 
              if(brake_check != 0) {
                notification_status.push(brake_check);
                notification_type.push('brake check');
              } 
              if(tire_check != 0) {
                notification_status.push(tire_check);
                notification_type.push('tire check');
              } 
          var data = {                
               status: 1,
               userofcar_id : userofcar_id,
               current_mileage:current_mileage,
               annual_miles:annual_miles,                
               notification_type: notification_type,
               notification_status:notification_status,
               description_name:description_name
          };

          $.ajax({
  	        url: '/update/userprofile',
  	        method: "POST",
  	        data: data,
  	        datatype: 'json',
  	        cache: false,
  	        success: function(response) {           
  	         window.location.href = '/mycar';
             console.log(response);
  	        },
  	        error: function(xhr) {
  	            console.log('error', xhr);
  	        }
	       });
	    console.log(data);

   	}
   });

  /*
   *  Form validation addition in user car form
   */

   $('#usercar_form').bootstrapValidator({

      feedbackIcons: {
          valid: 'glyphicon glyphicon-ok',
          invalid: 'glyphicon glyphicon-remove',
          validating: 'glyphicon glyphicon-refresh'
      },

      fields: {
        current_mileage: {
          enabled: true,
          validators: {
            notEmpty: {
                message: 'The current mileage is required and cannot be empty'
            },
            integer: {
               message : 'Please enter valid input for current mileage'
            },
            stringLength: {
              max: 10,
              message: 'please enter valid input maxmimun 10 numbers'
            },
            car : 'carselection'
          }
        },
        description_name: {
          validators: {
            notEmpty: {
                message: 'The description name is required and cannot be empty'
            }
          }
        },
        annual_miles : {
          validators: {
            notEmpty: {
                message: 'The annual miles is required and cannot be empty'
            }
          }

        }

      }


   });

});
