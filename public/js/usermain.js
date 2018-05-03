$(document).ready(function(){  
   /**
    *   multiple selection car year
    */
    $(document).on('click', '#make_selection', function(){
      var m_year = [];
      $('#car_year :checked').each(function(i) {
          m_year[i] = $(this).val();
      }); 
      // alert when no any year is selected.      
      if(m_year.length == 0)  window.location.replace('#modal');  
      console.log(m_year);
      var data = {
      	year : m_year
      }

      // find all make of selected year for ajax request.
      $.ajax({
        url: '/find/make',
        method: "POST",
        data: data,
        datatype: 'json',
        cache: false,
        success: function(response) {           
          window.location.href = '/find/make';
        },
        error: function(xhr) {
            console.log('error', xhr);
        }
      });
   });


});
