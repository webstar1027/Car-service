
$(document).ready(function(){     
   
   $(document).on('click', '#service_cancel', function () {
      $('#myModal').modal('show');
   });

  /*
   *  Service Cancel confirm.
   */
   $(document).on('click', '.cancel_confirm', function () {
   	  var id = $('#event_id').val();
   	  console.log(id);
   		window.location.href = '/calendar/event/remove/'+id;
   });
  /*
   *  Service Cancel cancel.
   */
   $(document).on('click', '.cancel', function () {
   		console.log('cancel');
   });
});
