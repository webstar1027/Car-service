$(document).ready(function() {

   $('.operator-table').DataTable({
   		"responsive" :true,
      "paging":true,
      "searching": true,
      "ordering":true,
      "info":true

   });
   $('.datatable-pagination').DataTable({
        pagingType: "simple",
        language: {
            paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
        }
    });


   $(document).on('click','.edit', function(event) {
   	 var id = event.target.id.replace('edit', '');
   	 var license = $('.operator-table tbody tr#'+ id + ' td:nth-child(5)').text(),
   	     insurance = $('.operator-table tbody tr#'+ id + ' td:nth-child(6)').text(),
   	     plan = $('.operator-table tbody tr#'+ id + ' td:nth-child(7)').text(),
         status = $('.operator-table tbody tr#'+ id + ' td:nth-child(8)').text(),
         barstatus = $('.operator-table tbody tr#'+ id + ' td:nth-child(3)').text(),
         epastatus = $('.operator-table tbody tr#'+ id + ' td:nth-child(4)').text();
   	   
     if(status == 'No Active'){
        var status_val = 'notactive';
     }
     else if(status == 'Active'){
       var status_val = 'active';
     }
     else{
       var status_val = 'expire';
     }
   	 var data = {
     	 	license:license,
     	 	insurance:insurance,
     	 	plan:plan,
     	 	status:status
     
   	 };
   	 var newLicense = $('.operator-table tbody tr#'+ id + ' td:nth-child(5)').html("<select class='form-control' id='license'>"+
																   	 	                "<option selected hidden>"+license+"</option>"+
																   	 	                "<option value='valid'>Valid</option>" +
																   	 	                "<option value='notupload'>Not Uploaded</option>" +
																   	 	                "<option value='recertification'>Recertification</option>" +
																   	 	                "<option value='processing'>Processing</option></select>");
   	 $('.operator-table tbody tr#'+ id + ' td:nth-child(5)').append(newLicense);
   	 var newInsurance = $('.operator-table tbody tr#'+ id + ' td:nth-child(6)').html("<select class='form-control' id='insurance'>"+
																   	 	                "<option selected hidden>"+insurance+"</option>"+
																   	 	                "<option value='valid'>Valid</option>" +
																   	 	                "<option value='notupload'>Not Uploaded</option>" +
																   	 	                "<option value='recertification'>Recertification</option>" +
																   	 	                "<option value='processing'>Processing</option></select>");
   	 $('.operator-table tbody tr#'+ id + ' td:nth-child(6)').append(newInsurance);
   	 
   	 var newStatus = $('.operator-table tbody tr#'+ id + ' td:nth-child(8)').html("<select class='form-control' id='status'>"+
																   	 	                "<option selected hidden>"+status+"</option>"+
                                                      "<option value='notactive'>No Active</option>" +
																   	 	                "<option value='active'>Active</option>" +
																   	 	                "<option value='expire'>Expire</option></select>");																   	 	           
   	 $('.operator-table tbody tr#'+ id + ' td:nth-child(8)').append(newStatus); 

     var barnumber_status = $('.operator-table tbody tr#'+ id + ' td:nth-child(3)').html("<select class='form-control' id='barstatus'>"+
                                                      "<option selected hidden>"+barstatus+"</option>"+
                                                      "<option value='valid'>Valid</option>" +                                                     
                                                      "<option value='notvalid'>Not Valid</option></select>");                                                
     $('.operator-table tbody tr#'+ id + ' td:nth-child(3)').append(barnumber_status);  

     var epanumber_status = $('.operator-table tbody tr#'+ id + ' td:nth-child(4)').html("<select class='form-control' id='epastatus'>"+
                                                      "<option selected hidden>"+epastatus+"</option>"+
                                                      "<option value='valid'>Valid</option>" +                                                     
                                                      "<option value='notvalid'>Not Valid</option></select>");                                                
     $('.operator-table tbody tr#'+ id + ' td:nth-child(4)').append(epanumber_status);  	    
   	
   });

   $(document).on('click', '.save', function(event){

   	 var id = event.target.id.replace('save', ''),
   	     license = $('#license option:selected').val(),
   	     insurance = $('#insurance option:selected').val(),
   	     status = $('#status option:selected').val(),
         barstatus = $('#barstatus option:selected').val(),
         epastatus = $('#epastatus option:selected').val();
   	 

   	 var data = {
   	 	id:id,
   	 	license:license,
   	 	insurance:insurance,
   	 	status:status,
      barstatus: barstatus,
      epastatus:epastatus
 
   	 };

   	 console.log(data);

   	 $.ajax({
        url: '/operator/update',
        method: "POST",
        data: data,
        datatype: 'json',
        cache: false,
        success: function(response) { 
          if(response == 'not register'){
             alert('You did not register shop hour. pleas check your shop hour');
          }
          else if( response == 'not upload'){
             alert('You did not upload file. pleas upload file');
          }
          else{
            window.location.href = '/admin/operator';

         } 
        },
        error: function(xhr) {
            console.log(xhr)
        }
     });

   });

});