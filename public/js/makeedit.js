$(document).ready(function(){  

    var m_make = [];
    var limit = parseInt($('#make_limit').val());  
    if(limit == 0) limit = 100000000;
    $('input[type=checkbox]').on('click', function() {      
      
      if(m_make.length >= limit) {

        if( jQuery.inArray($(this).val(), m_make) !== -1){
          var index =  m_make.indexOf($(this).val());        
          m_make.splice(index, 1);              
        }
        else{
          window.location.replace('#modal1'); 
          $(this).prop('checked', false);        
        } 
      }
      else{

        if($(this).is(':checked')) {
          m_make.push($(this).val());        
        }
        else{
          var index =  m_make.indexOf($(this).val());        
          m_make.splice(index, 1);           
        }     
      }
      console.log(m_make);      
    });
   /**
    *   multiple selection car year
    */
    $(document).on('click', '#make_selection', function(){
     
      $('#make_year :checked').each(function(i) {
          m_make[i] = $(this).val();
      }); 
      // alert when no any year is selected.      
      if(m_make.length == 0)  window.location.replace('#modal');  
      console.log(m_make);
      var data = {
      	make : m_make
      }

      // find all make of selected year for ajax request.
      console.log(data);
      $.ajax({
        url: '/find/model',
        method: "POST",
        data: data,
        datatype: 'json',
        cache: false,
        success: function(response) {           
         console.log(response);
         window.location.href = '/find/model';
        },
        error: function(xhr) {
            console.log('error', xhr);
        }
      });
   });


});
