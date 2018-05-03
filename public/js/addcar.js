$(document).ready(function(){  
  console.log('ok');
   /**
     *   find make responding  to selected year
     */
     $(document).on('change', '#year1', function(){

       var data = {
          year:$(this).val()
       };
       findMake(data);

     });
     function findMake(data){
       $.ajax({
            url: '/get/make',
            method: "POST",
            data: data,
            datatype: 'json',
            cache: false,
            success: function(response) { 
              $('#make1 label').remove();
              $('#make1 select').remove();

              $('#model1 label').remove();
              $('#model1 select').remove();

              $('#term1 label').remove();
              $('#term1 select').remove();
              
              if(response.length != 0){
                console.log(response.length);
                displayMake(response);
              }
              
            },
            error: function(xhr) {
                console.log('error', xhr);
            }
        });
     }
     function displayMake(data){
       var  label = $("<label for='sel1'>Make:</label>");
       var element = $("<select class='form-control' id='get_make1' />");
       $("<option selected/>", {value:'', text:'please select make'}).appendTo(element);
       for(var i = 0; i< data.length; i++) {
         $("<option/>", {value: data[i], text: data[i]}).appendTo(element);
       }
       label.appendTo('#make1');
       element.appendTo('#make1');

     }
      /**
     *   find model responding  to selected year and make
     */
     $(document).on('change', '#get_make1', function(){

       var data = {
          make:$(this).val(),
          year:$('#year1').val()
       };
       console.log(data);
       findModel(data);

     });
     function findModel(data){
       $.ajax({
            url: '/get/model',
            method: "POST",
            data: data,
            datatype: 'json',
            cache: false,
            success: function(response) { 
              $('#model1 label').remove();
              $('#model1 select').remove();

              $('#term1 label').remove();
              $('#term1 select').remove();
              if(response.length != 0){
                console.log(response.length);
                displayModel(response);
               console.log(response);
              }
              
            },
            error: function(xhr) {
                console.log('error', xhr);
            }
        });
     }
     function displayModel(data){
       var  label = $("<label for='sel1'>Model:</label>");
       var element = $("<select class='form-control' id='get_model1' />");
       $("<option selected/>", {value:'', text:'please select model'}).appendTo(element);
       for(var i = 0; i< data.length; i++) {
         $("<option/>", {value: data[i], text: data[i]}).appendTo(element);
       }
       label.appendTo('#model1');
       element.appendTo('#model1');

     }
      /**
     *   find model responding  to selected year and make
     */
     $(document).on('change', '#get_model1', function(){

       var data = {
          make:$('#get_make1 option:selected').val(),
          year:$('#year1').val(),
          model:$('#get_model1 option:selected').val()
       };
       console.log(data);
       findTerm(data);

     });
     function findTerm(data){
       $.ajax({
            url: '/get/term',
            method: "POST",
            data: data,
            datatype: 'json',
            cache: false,
            success: function(response) {              
              if(response.length != 0){
                console.log(response.length);
                displayTerm(response);
                console.log(response);
              }
              
            },
            error: function(xhr) {
                console.log('error', xhr);
            }
        });
       console.log('okokokokoko');
     }
     function displayTerm(data){
       var  label = $("<label for='sel1'>Term:</label>");
       var element = $("<select class='form-control' id='get_term1' />");
       $("<option selected/>", {value:'', text:'please select term'}).appendTo(element);
       for(var i = 0; i< data.length; i++) {
         $("<option/>", {value: data[i], text: data[i]}).appendTo(element);
       }
       label.appendTo('#term1');
       element.appendTo('#term1');

     }
     
     /*
      *   Display Notification type.
      */

     $(document).on('change', '.notifications', function () {      
       
       var data = $('.notifications option:selected').val();
       if(data == 'enable'){
         $('.notification-type').css('display','block');
       }
       else{
         $('.notification-type').css('display','none');
       }
     });

     /*
      *   add car save
      */
      $(document).on('click', '#save', function () {
        var  year = $('#year1').val(),
             make = $('#get_make1 option:selected').val(),
             model = $('#get_model1 option:selected').val(),
             term = $('#get_term1 option:selected').val(),
             mileage = $('#mileage').val(),
             annual_miles = $('#annual_miles option:selected').val(),
             description_name = $('#description_name').val();
        var notification_status = [],
            notification_type = [];
        if($('.notifications option:selected').val() == 'enable' ){

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
                 year : year,
                 make : make,
                 model: model,
                 term : term,
                 status: 1,
                 current_mileage:mileage,
                 annual_miles:annual_miles,
                 description_name:description_name,
                 notification_type: notification_type,
                 notification_status:notification_status
            };
        }
        else{
           var data = {
                 year : year,
                 make : make,
                 model: model,
                 term : term,
                 current_mileage:mileage,
                 annual_miles:annual_miles,
                 description_name:description_name,
                 status: 0
           };
        }      
        $.ajax({
            url: '/update/profile',
            method: "POST",
            data: data,
            datatype: 'json',
            cache: false,
            success: function(response) {              
              window.location.href = '/user';
            },
            error: function(xhr) {
                console.log('error', xhr);
            }
        });
         console.log(data);
      })


});
