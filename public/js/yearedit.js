$(document).ready(function(){  
   /**
    *   multiple selection car year
    */
    var m_year = [];
    var limit = parseInt($('#year_limit').val());  

    $('input[type=checkbox]').on('click', function() {      
      
      if(m_year.length >= limit) {

        if( jQuery.inArray($(this).val(), m_year) !== -1){
          var index =  m_year.indexOf($(this).val());        
          m_year.splice(index, 1);              
        }
        else{
          window.location.replace('#modal1'); 
          $(this).prop('checked', false);        
        } 
      }
      else{

        if($(this).is(':checked')) {
          m_year.push($(this).val());        
        }
        else{
          var index =  m_year.indexOf($(this).val());        
          m_year.splice(index, 1);           
        }     
      }
      console.log(m_year);      
    });

    $(document).on('click', '#make_selection', function(){
     
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
