$(document).ready(function(){
 
    var  count_select = false,
         count_car = false,
         category_name,
         current_mileage,
         zip_code,
         distance,
         temp_service = {};
    var profile_id;
    
    $('.loader').css('display', 'none');
    $(".category-select").click(function(){

        if( count_select  == false) 
        {
          $("#category_select").show();
          count_select = true;

        } else {

          $("#category_select").hide();
          count_select = false;
        }

    });
     $(".car-select").click(function(){

        if( count_car  == false) 
        {
          $("#car_select").show();
          count_car = true;

        } else {

          $("#car_select").hide();
          count_car = false;
        }

    });
    /**
     *   find make responding  to selected year
     */
     $(document).on('change', '#year', function(){

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
              $('#make label').remove();
              $('#make select').remove();

              $('#model label').remove();
              $('#model select').remove();

              $('#term label').remove();
              $('#term select').remove();
              
              $('#current_mileage').val('');
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
       var element = $("<select class='form-control' id='get_make' />");
       $("<option selected/>", {value:'', text:'please select make'}).appendTo(element);
       for(var i = 0; i< data.length; i++) {
         $("<option/>", {value: data[i], text: data[i]}).appendTo(element);
       }
       label.appendTo('#make');
       element.appendTo('#make');

     }
     /**
     *   find model responding  to selected year and make
     */
     $(document).on('change', '#get_make', function(){

       var data = {
          make:$(this).val(),
          year:$('#year').val()
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
              $('#model label').remove();
              $('#model select').remove();

              $('#term label').remove();
              $('#term select').remove();

               $('#current_mileage').val('');
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
       var element = $("<select class='form-control' id='get_model' />");
       $("<option selected/>", {value:'', text:'please select model'}).appendTo(element);
       for(var i = 0; i< data.length; i++) {
         $("<option/>", {value: data[i], text: data[i]}).appendTo(element);
       }
       label.appendTo('#model');
       element.appendTo('#model');

     }
      /**
     *   find model responding  to selected year and make
     */
     $(document).on('change', '#get_model', function(){

       var data = {
          make:$('#get_make option:selected').val(),
          year:$('#year').val(),
          model:$('#get_model option:selected').val()
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
      
     }
     function displayTerm(data){
       var  label = $("<label for='sel1'>Term:</label>");
       var element = $("<select class='form-control' id='get_term' />");
       $("<option selected/>", {value:'', text:'please select term'}).appendTo(element);
       for(var i = 0; i< data.length; i++) {
         $("<option/>", {value: data[i], text: data[i]}).appendTo(element);
       }
       label.appendTo('#term');
       element.appendTo('#term');

     }

    /**
     *   find sub category responding to selected category
     */
    $(document).on('change', '#category_name', function() {

        var data = {
         category_name: $(this).val()
        }   
        findSubCategory(data);

     });
     function findSubCategory(data) {
        $.ajax({
            url: '/find/service',
            method: "POST",
            data: data,
            datatype: 'json',
            cache: false,
            success: function(response) {
              $('#sub-category label').remove();
              $('#sub-category select').remove();

              $('#sub2-category label').remove();
              $('#sub2-category select').remove();

              $('#sub3-category label').remove();
              $('#sub3-category select').remove();

              $('#sub4-category label').remove();
              $('#sub4-category select').remove();
              if(response){
                displayCategory(response);
              }
              
            },
            error: function(xhr) {
                console.log('error', xhr);
            }
        });

     };
     function displayCategory(data){
       var  label = $("<label for='sel1'>Sub-Category:</label>");
       var element = $("<select class='form-control' required='required' name='sub_category' id='sub_category' />");
       $("<option value=''></option>").appendTo(element);
       for(var i = 0; i< data.length; i++) {
        // $("<option/>", {value: data[i], text: data[i]}).appendTo(element);
           $("<option value='"+data[i]+"'>"+data[i]+"</option>").appendTo(element);
       }
       label.appendTo('#sub-category');
       element.appendTo('#sub-category');

     }

     /**
      *
      *    Display sub2-category if there exists
      *
      */
      /**
     *   find sub category responding to selected category
     */
    $(document).on('change', '#sub_category', function() {

        var data = {
         category_name: $(this).val()
        }   
        findSub2Category(data);

     });
     function findSub2Category(data) {
        $.ajax({
            url: '/find/service',
            method: "POST",
            data: data,
            datatype: 'json',
            cache: false,
            success: function(response) {
              $('#sub2-category label').remove();
              $('#sub2-category select').remove();

              $('#sub3-category label').remove();
              $('#sub3-category select').remove();

              $('#sub4-category label').remove();
              $('#sub4-category select').remove();
              if(response){
                display2Category(response);
              }
              
            },
            error: function(xhr) {
                console.log('error', xhr);
            }
        });

     };
     function display2Category(data){
       var  label = $("<label for='sel1'>Sub-Sub-Category:</label>");
       var element = $("<select class='form-control' required='required' name='sub2_category' id='sub2_category' />");
       $("<option selected/>", {value:'', text:'please select sub-sub-category'}).appendTo(element);
       for(var i = 0; i< data.length; i++) {
         $("<option/>", {value: data[i], text: data[i]}).appendTo(element);
       }
       label.appendTo('#sub2-category');
       element.appendTo('#sub2-category');

     }
     /**
      *    Find sub-sub-sub category
      */
       $(document).on('change', '#sub2_category', function() {

        var data = {
         category_name: $(this).val()
        }   
        findSub3Category(data);

     });
     function findSub3Category(data) {
        $.ajax({
            url: '/find/service',
            method: "POST",
            data: data,
            datatype: 'json',
            cache: false,
            success: function(response) {
              $('#sub3-category label').remove();
              $('#sub3-category select').remove();

              $('#sub4-category label').remove();
              $('#sub4-category select').remove();
              if(response){
                display3Category(response);
              }
              
            },
            error: function(xhr) {
                console.log('error', xhr);
            }
        });

     };
     function display3Category(data){
       var  label = $("<label for='sel1'>Sub-Sub-Sub-Category:</label>");
       var element = $("<select class='form-control' required='required' name='sub3_category' id='sub3_category' />");
       $("<option selected/>", {value:'', text:'please select sub-sub-Sub-category'}).appendTo(element);
       for(var i = 0; i< data.length; i++) {
         $("<option/>", {value: data[i], text: data[i]}).appendTo(element);
       }
       label.appendTo('#sub3-category');
       element.appendTo('#sub3-category');

     }
  

     /**
      *    Find sub-sub-sub category
      */
      $(document).on('change', '#sub3_category', function() {

        var data = {
         category_name: $(this).val()
        }   
        findSub4Category(data);

     });
     function findSub4Category(data) {
        $.ajax({
            url: '/find/service',
            method: "POST",
            data: data,
            datatype: 'json',
            cache: false,
            success: function(response) {
              $('#sub4-category label').remove();
              $('#sub4-category select').remove();
              if(response){
                display4Category(response);
              }
              
            },
            error: function(xhr) {
                console.log('error', xhr);
            }
        });

     };
     function display4Category(data){
       var  label = $("<label for='sel1'>Sub-Sub-Sub-Sub-Category:</label>");
       var element = $("<select class='form-control' required='required' name='sub4_category' id='sub4_category' />");
       $("<option selected/>", {value:'', text:'please select sub-sub-Sub-sub-category'}).appendTo(element);
       for(var i = 0; i< data.length; i++) {
         $("<option/>", {value: data[i], text: data[i]}).appendTo(element);
       }
       label.appendTo('#sub4-category');
       element.appendTo('#sub4-category');

     }
  

   /*
    *    Search service
    */
    $(document).on('click', '.service-search', function() {

       var category_name;

        //  get category name
       if($("#sub4_category option:selected").val() != undefined ){
          category_name = $("#sub4_category option:selected").val();
       }
       else{
           if($("#sub3_category option:selected").val() != undefined  ){
              category_name = $("sub3_category option:selected").val();
           }
           else{
              if($("#sub2_category option:selected").val() != undefined ){
                category_name = $("#sub2_category option:selected").val();
              }
              else{
                 if($("#sub_category option:selected").val() != undefined ){
                    category_name = $("#sub_category option:selected").val();
                 }
                 else
                 {
                  if($("#category_name option:selected").val() != undefined) {
                    category_name = $("#category_name option:selected").val();
                  }
                 }
              }
           }
       }

       // get car information
       car_id = $('#car_selection :selected').val(),
       current_mileage = $('#current_mileage').val(),
       zip_code = $('#zipcode').val(),
       distance = $('#mile_select :selected').val();
       var data = {
         category_name: category_name,
         car_id:car_id,
         current_mileage:current_mileage,
         zip_code:zip_code,
         distance:distance       
       }      
       $.ajax({
            url: '/service/search',
            method: "POST",
            data: data,
            datatype: 'json',
            cache: false,
            success: function(response) {
              console.log(response);
              if(response == 'service'){
                window.location.href = '#modal';
              }
              else if(response == 'shopservice'){
                window.location.href = '#modal1';
              }
              else if(response == 'exist'){
                window.location.href = '#modal2';
              }
              else{
                window.location.href = '/search/service';
              }
            },
            error: function(xhr) {
                console.log('error', xhr);
            }
       }).always(function(){
         $('.container').css('opacity', '0.5');
         $('.loader').css({'display' :'block', 'opacity' : '1'});
         
       }).done(function() {
         $('.container').css('opacity', '1');
         $('.loader').css({'display' :'none', 'opacity' : '0'});
       });
       console.log(data);

    });
   
    $(document).on('change', '#car_selection', function(){
        var data = $('#car_selection :selected').val();
        if(data == 'addcar'){
           window.location.href = '/userprofile/addcar';
          
        }
         $('#current_mileage').val($('#'+data).val());
    });

    /*
     *  Form validation addition in search form
     */

     $('#service_search_form').bootstrapValidator({

         feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },

        fields: {
          currentmileage: {
            enabled: true,
            validators: {
              notEmpty: {
                  message: 'The current mileage is required and cannot be empty'
              },
              integer: {
                 message : 'Please enter valid input for current mileage'
              },
              stringLength: {
                max: 10,
                message: 'please enter valid input maxmimun 10 numbers'
              },
              car : 'carselection'
            }
          },
          zipcode: {
            validators: {
              notEmpty: {
                  message: 'The zipcode is required and cannot be empty'
              },
              integer: {
                 message : 'Please enter valid input for zip code'
              },
              stringLength: {
                max: 5,
                min: 5,
                message: 'Please enter valid input for zip code'
              }
            }
          }

        }


     });

   


    
});