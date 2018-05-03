$(document).ready(function(){  
    var model = []; var modelID = [];
    var limit = parseInt($('#model_limit').val());  
    console.log(limit);
    if(limit == 0) limit = 100000000;
    $('input[type=checkbox]').on('click', function() {      
      
      if(model.length >= limit) {

        if( jQuery.inArray($(this).val(), model) !== -1  && jQuery.inArray($(this).attr('id'), modelID) !== -1){
          var index =  model.indexOf($(this).val());        
          model.splice(index, 1);    
          var index2 =  modelID.indexOf($(this).attr('id'));        
          modelID.splice(index2, 1);              
         
        }
        else{
          window.location.replace('#modal1'); 
          $(this).prop('checked', false);   
          console.log('222');     
       } 
      }
      else{

        if($(this).is(':checked')) {
          model.push($(this).val());
          modelID.push($(this).attr('id'));        
          console.log('333');
        }
        else{
          var index =  model.indexOf($(this).val());        
          model.splice(index, 1);     
          var index2 =  modelID.indexOf($(this).attr('id'));        
          modelID.splice(index2, 1);      
          console.log('444');   
        }     
      }
      console.log(model);      
   });

   $(document).on('click', '#term_selection', function() {
      console.log('ok');
     
      $('.model-selection :checked').each(function(i) {
          model[i] = $(this).val();
      }); 

      if(model.length == 0) window.location.href = '#modal';  
      var data = {
        model : model
      }
      // find all term of selected year, make, model for ajax request.
      console.log(data);
      $.ajax({
        url: '/find/term',
        method: "POST",
        data: data,
        datatype: 'json',
        cache: false,
        success: function(response) {           
         console.log(response);
         window.location.href = '/find/term';
        },
        error: function(xhr) {
            console.log('error', xhr);
        }
      });
      console.log(data);
   });
   
});
