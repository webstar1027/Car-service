$(document).ready(function(){  
   $(document).on('change', '#appoint', function () {
      var week_number = $(this).val();
      var option = $('#appoint :selected').text();
      if (week_number == 0) {
      	window.location.href = '/schedule';

      }
      else{
	      var data = {
	      	weeknumber:week_number,
	      	option : option
	      };
	      console.log(data);
	      $.ajax({
	          url: '/week/booking',
	          method: "POST",
	          data: data,
	          datatype: 'json',
	          cache: false,
	          success: function(response) {
	            window.location.href = '/week/booking';
	           console.log(response);
	          },
	          error: function(xhr) {
	              console.log('error', xhr);
	          }
	      });
      }

   });

});
