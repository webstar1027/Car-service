
$(document).ready(function(){     
   /**
    *   multiple selection car year
    */
    localStorage.clear();
    var limit = parseInt($('#term_limit').val());  
    var car_data = []; var state_data = []; var car_dataID = [];
    console.log(limit);

    if(limit == 0) limit = 100000000;
    if(localStorage.getItem('state') != null ) {
        var data = JSON.parse(localStorage.getItem('state'));
        for(var i=0; i< data.length; i++){
          $('#model' + data[i]).prop('checked', true);
        }

        console.log('ok');
    }
    $('input[type=checkbox]').on('click', function(event){
       /**
        *   Get selected term array from localStorage
        */
      
       var id = event.target.id.replace('model', '');
    
       if(car_data.length >= limit) {

        if( jQuery.inArray($(this).val(), car_data) !== -1 && jQuery.inArray($(this).attr('id'), car_dataID) !== -1){
          car_data =JSON.parse(localStorage.getItem('term'));
          var index1 =  car_data.indexOf($(this).val());        
          car_data.splice(index1, 1);    

          car_dataID = JSON.parse(localStorage.getItem('ID'));
          var index2 =  car_dataID.indexOf($(this).attr('id'));        
          car_dataID.splice(index2, 1);

          state_data =JSON.parse(localStorage.getItem('state'));
          var index3 =  state_data.indexOf(id);        
          state_data.splice(index3, 1);  

          localStorage.setItem('term', JSON.stringify(car_data));   
          localStorage.setItem('state', JSON.stringify(state_data)); 
          localStorage.setItem('ID', JSON.stringify(car_dataID));        
        }
        else{
          window.location.replace('#modal1'); 
          $(this).prop('checked', false);                  
        }        
         
      }
      else{

        if($(this).is(':checked')) {

           if(localStorage.getItem('term') == null){
             car_data.push($(this).val()); 
             car_dataID.push($(this).attr('id'));
           }
           else{
             car_data =JSON.parse(localStorage.getItem('term'));
             car_data.push($(this).val());

             car_dataID = JSON.parse(localStorage.getItem('ID'));
             car_dataID.push($(this).attr('id'));
           }      
           if(localStorage.getItem('state') == null){
             state_data.push(id);
           }
           else{
             state_data =JSON.parse(localStorage.getItem('state'));
             state_data.push(id);
           }     
                  
                
        }
        else{

          car_data =JSON.parse(localStorage.getItem('term'));
          var index1 =  car_data.indexOf($(this).val());        
          car_data.splice(index1, 1); 

          car_dataID = JSON.parse(localStorage.getItem('ID'));
          var index2 =  car_dataID.indexOf($(this).attr('id'));        
          car_dataID.splice(index2, 1);

          state_data =JSON.parse(localStorage.getItem('state'));
          var index3 =  state_data.indexOf(id);        
          state_data.splice(index3, 1);      
                
        }   
        localStorage.setItem('term', JSON.stringify(car_data));  
        localStorage.setItem('state', JSON.stringify(state_data));  
        localStorage.setItem('ID', JSON.stringify(car_dataID));        
       
      }   
     console.log(JSON.parse(localStorage.getItem('term')));
     console.log(JSON.parse(localStorage.getItem('state')));     

    });

    $(document).on('click', '#term_selection', function(){       
      var data = [];
          data =JSON.parse(localStorage.getItem('term'));
      
      var id = [];
           id = localStorage.getItem('state');
      
      localStorage.setItem('term', '');
      localStorage.setItem('state', '');
      var data = {
       term : data
      }
      localStorage.clear();
      $.ajax({
        url: '/find/category',
        method: "POST",
        data: data,
        datatype: 'json',
        cache: false,
        success: function(response) {           
         console.log(response);
         window.location.href = '/detail/price/edit';
        },
        error: function(xhr) {
            console.log('error', xhr);
        }
      });
      console.log(data);
  
   });
  
    

});
