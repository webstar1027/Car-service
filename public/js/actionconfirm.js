$(document).ready(function(){  
 console.log('ok');
 $(document).on('click', '#confirm', function(){
     $.ajax({
      url: '/acion/confirm/finish',
      method: "GET",   
      cache: false,
      success: function(response) {           
       console.log(response);
      
      },
      error: function(xhr) {
          console.log('error', xhr);
      }
    });
 });

});
