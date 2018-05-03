$(document).ready(function(){  
     var item_number,
         temp; 
    /**
     *   find sub category responding to selected category
     */
     $(document).on('change', '#category_name', function() {

        var data = {
         category_name: $(this).val()
        }   
        findSubCategory(data);
        console.log('ok');

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
       var element = $("<select class='form-control' id='sub_category' />");
       $("<option selected/>", {value:'', text:'please select sub-category'}).appendTo(element);
       for(var i = 0; i< data.length; i++) {
         $("<option/>", {value: data[i], text: data[i]}).appendTo(element);
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
       var element = $("<select class='form-control' id='sub2_category' />");
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
       var element = $("<select class='form-control' id='sub3_category' />");
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
       var element = $("<select class='form-control' id='sub4_category' />");
       $("<option selected/>", {value:'', text:'please select sub-sub-Sub-sub-category'}).appendTo(element);
       for(var i = 0; i< data.length; i++) {
         $("<option/>", {value: data[i], text: data[i]}).appendTo(element);
       }
       label.appendTo('#sub4-category');
       element.appendTo('#sub4-category');
     }

     var category_name,       
         parts_price,
         labor_price,
         query_index,
         both_price;
     $(document).on('click', '#year_selection', function() {
      
          var  description = [],
               item_type = [],
               price = [];
          for(var i = 0; i< item_number; i++) {
           description.push($('#description'+i).val());
           price.push($('#price'+i).val());
           item_type.push($('#item_type'+i+' :selected').text());
          }

          var labor_flag = false,
              part_flag = false;

          for ( var i = 0; i< item_type.length; i++){
             if(item_type[i] == 'labor price') labor_flag = true;
             if(item_type[i] == 'part price') part_flag = true;
          }
         

          //  //  get category name
           if($("#sub4_category option:selected").val() != undefined ){
              category_name = $("#sub4_category option:selected").val();
              console.log('1111');
           }
           else{
               if($("#sub3_category option:selected").val() != undefined  ){
                  category_name = $("#sub3_category option:selected").val();
                  console.log('2222----category_name', category_name);
               }
               else{
                  if($("#sub2_category option:selected").val() != undefined ){
                    category_name = $("#sub2_category option:selected").val();
                    console.log('3333');
                  }
                  else{
                     if($("#sub_category option:selected").val() != undefined ){
                        category_name = $("#sub_category option:selected").val();
                        console.log('4444');
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
      
           query_index = $('#price_option option:selected').val();

           if(query_index == 'Seperate Price for parts and labor') {
              if(part_flag == false && labor_flag == false) {
                  window.location.href = '#modal2';
                  return;
              }
           }
           var data = {
             category_name: category_name,
             description:description,
             price:price,
             item_type :item_type,
             query_index:query_index,
             item_number:item_number
           };

            $.ajax({
              url: '/shop/service/multicreate',
              method: "POST",
              data: data,
              datatype: 'json',
              cache: false,
              success: function(response) {           
               console.log(response); 
               window.location.href = '/year/edit';              
              },
              error: function(xhr) {
                  console.log('error', xhr);
              }

            });
        


     });


     /**
      *  find pricing items occording to selected pricing option 
      */
      $(document).on('change', '#price_option', function(){
          if($(this).val() == 'Call for Price') {
              $('table tbody tr').remove();
              $('.priceitem-edit button').remove();
              $('.priceitem-edit').css('display', 'none'); 
              item_number = 1;
              price = '999999';
              item_type = "Call for price";
              description = "Call for price";
              var data = {
                price:price,
                item_type:item_type,
                description:description
              };

              temp = data ;

          }

          if($(this).val() == 'Combined Price for parts and labor') {  
             $('.priceitem-edit').css('display', 'block'); 
             $('table tbody tr').remove();
             $('.priceitem-edit button').remove();   
             var text = [
                'parts and labor price combined', 'regulation fees'
             ];        
            for(var i = 0; i< 2; i++) {
                var newCell = $("<tr><td><input class='form-control' id='description"+i+"'/></td><td><select class='form-control' id='item_type"+i+"'><option selected hidden></option></select></td><td><input class='form-control' id='price"+i+"'/></td></tr>");       
                $('tbody').append(newCell);
                for(var j = 0; j < text.length; j++){
                   $('#item_type'+i).append($('<option>', { 
                      value: text[j],
                      text : text[j] 
                   }));
                }            
             } 
             item_number = 2;        
             // $('.priceitem-edit').append($("<div class='text-center'><button class='btn btn-primary' id='review'>review</button></div>")) ;
             // $('#review').prop('enabled', true);
          }

          if($(this).val() == 'Seperate Price for parts and labor') {
            $('table tbody tr').remove();
            $('.priceitem-edit button').remove();
            modalShow();

          }
        

      });
     /* 
      *   show modal dialog for inputing item number
      */
     function modalShow() {
        $('#item_number').val(null);
        $('#myModal').modal('show');
       
     }
     /*
      *  validation for inputed item number
      */
     $(document).on('input', '#item_number', function(){
        if(parseInt($('#item_number').val()) > 10) window.location.href = '#modal1';
     });
     /*
      *    Create line item dynamically
      */
     $(document).on('click', '.number_save', function(){       
         item_number = parseInt($('#item_number').val());         
         $('.priceitem-edit').css('display', 'block');
         var text = [
            'labor price', 'new part(OEM)', 'new part(non-OEM)', 'part price',
            'used part(OEM)', 'used part(non-OEM)', 'reconditioned part(OEM)', 'reconditioned part(non-OEM)', 'NEW', 
            'rebuilt', 'regulation fees', 'crash part(OEM)'
         ];
         for(var i = 0; i< item_number; i++) {
            var newCell = $("<tr><td><input class='form-control' id='description"+i+"'/></td><td><select class='form-control' id='item_type"+i+"'><option selected hidden></option></select></td><td><input class='form-control' id='price"+i+"'/></td></tr>");       
            $('tbody').append(newCell);
            for(var j = 0; j < text.length; j++){
               $('#item_type'+i).append($('<option>', { 
                  value: text[j],
                  text : text[j] 
               }));
            }            
         }         
         // $('.priceitem-edit').append($("<div class='text-center'><button class='btn btn-primary' id='review'>review</button></div>")) ;
         // $('#review').prop('enabled', true);
         
     });
     /*
      *   Remember line item state for input
      */
      // $(document).on('click', '#review', function(){
      //     var  description = [],
      //          item_type = [],
      //          price = [];
      //     for(var i = 0; i< item_number; i++) {
      //      description.push($('#description'+i).val());
      //      price.push($('#price'+i).val());
      //      item_type.push($('#item_type'+i+' :selected').text());
      //     }
      //     $('tbody tr').remove();
      //     for( var i = 0; i < item_number; i++){
      //       var newCell = $("<tr><td>"+description[i]+"</td><td>"+item_type[i]+"</td><td>"+price[i]+"</td></tr>");
      //       $('tbody').append(newCell);
      //     }
      //     $(this).prop('disabled', true);

      //     var data = {
      //        description:description,
      //        item_type:item_type,
      //        price:price
      //     };

      //     temp = data;
      // });



});
