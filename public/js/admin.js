$(document).ready(function(){
	var count_new = false,
	    count_select = false,
      temp = {},
      temp_category = {},
      temp_shop = {};
	
	$("#category_select").hide();
   
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

    $("input[name='main_category']").on('input', function(e) {
    	var data = {
    		category_name: $(this).val()
    	}    
      $("#subcategory_name option").remove();
    	$.ajax({
            url: '/find/service',
            method: "POST",
            data: data,
            datatype: 'json',
            cache: false,
            success: function(response) {
            	console.log(response);
                if (response) {
                   for( var i = 0; i< response.length; i++) {
                   	 $("#subcategory_name").append($("<option value='" +response[i] + "'>"));          					
                   }
                }               
            },
            error: function(xhr) {
                console.log('error', xhr);
            }
        });

      console.log(data);
    });

    $("input[name='sub_category']").on('input', function(e){
    	var data = {
    		category_name: $(this).val()
    	}
    	$("#sub2category_name option").remove();
    	$.ajax({
            url: '/find/service',
            method: "POST",
            data: data,
            datatype: 'json',
            cache: false,
            success: function(response) {
            	console.log(response);
                if (response) {
                   for( var i = 0; i< response.length; i++) {
                   	  $("#sub2category_name").append($("<option value='" +response[i] + "'>")); 
                   }
                }                
            },
            error: function(xhr) {
                console.log('error', xhr);
            }
        });
    });

    $("input[name='sub2_category']").on('input', function(e){
      var data = {
        category_name: $(this).val()
      }
      $("#sub3category_name option").remove();
      $.ajax({
            url: '/find/service',
            method: "POST",
            data: data,
            datatype: 'json',
            cache: false,
            success: function(response) {
              console.log(response);
                if (response) {
                   for( var i = 0; i< response.length; i++) {
                      $("#sub3category_name").append($("<option value='" +response[i] + "'>")); 
                   }
                }                
            },
            error: function(xhr) {
                console.log('error', xhr);
            }
        });
    });
    $("input[name='sub3_category']").on('input', function(e){
      var data = {
        category_name: $(this).val()
      }
      $("#sub4category_name option").remove();
      $.ajax({
            url: '/find/service',
            method: "POST",
            data: data,
            datatype: 'json',
            cache: false,
            success: function(response) {
              console.log(response);
                if (response) {
                   for( var i = 0; i< response.length; i++) {
                      $("#sub4category_name").append($("<option value='" +response[i] + "'>")); 
                   }
                }                
            },
            error: function(xhr) {
                console.log('error', xhr);
            }
        });
    });
    /*
     *   This is a part new car information
     */


     $('#car-new').on('click', function() {
             var newRow = $('#car-body tbody tr.car-insert').html("<td><input class='form-control' type='text' id='number' value=''/></td><td><input class='form-control' type='text' id='make' value=''/></td><td><input class='form-control' type='text' id='year' value=''/></td><td><input class='form-control' type='text' id='model' value=''/></td><td><input class='form-control' type='text' id='term' value=''/></td><td><input class='form-control' type='text' id='cylinder' value=''/></td><td class='save'>Save <i class='fa fa-save'></i></td><td class='cancel'>Cancel <i class='fa fa-close'></i></td>");
             $('#car-body tbody tr.car-insert').append(newRow);
             $('.save').css('cursor','pointer');
             $('.cancel').css('cursor','pointer');
     });

     $(document).on('click', '.save', function() {
            var make = $('#make').val(),
                year = $('#year').val(),
                model = $('#model').val(),
                term = $('#term').val(),
                cylinder = $('#cylinder').val();

            var data = {
                year : year,
                make : make,               
                model: model,
                term : term,
                cylinder: cylinder
            }

            $.ajax({
                url: '/car/insert',
                method: "POST",
                data: data,
                datatype: 'json',
                cache: false,
                success: function(response) {
                   window.location.href='/master';
                },
                error: function(xhr) {
                    console.log('error', xhr);
                }
            });
                        
     });

     $(document).on('click', '.edit', function(event){        
       var id = event.target.id,
           number = $('#number'+id).text(),
           make = $('#make'+id).text(),
           year = $('#year'+id).text(),
           model = $('#model'+id).text(),
           term = $('#term'+id).text(),
           cylinder = $('#cylinder'+id).text();

       var data = {
          id : id,
          number:number,
          make: make,
          year:year,
          model:model,
          term:term,
          cylinder:cylinder
       }
      
       temp = data;
       console.log("this is temp id ",temp.id);
       var newRow = $('#car-body tbody tr#' + id).html("<td><input class='form-control' type='text' id='number' value=''/></td><td><input class='form-control' type='text' id='make' value=''/></td><td><input class='form-control' type='text' id='year' value=''/></td><td><input class='form-control' type='text' id='model' value=''/></td><td><input class='form-control' type='text' id='term' value=''/></td><td><input class='form-control' type='text' id='cylinder' value=''/></td><td class='update'>Save <i class='fa fa-save'></i></td><td class='updateclose'>Cancel <i class='fa fa-close'></i></td>");
       $('#car-body tbody tr#' + id ).append(newRow);


       // set old content in text feild
       $('#number').val(number);$('#number').css('text-align','center');
       $('#make').val(make);$('#make').css('text-align','center');
       $('#year').val(year);$('#year').css('text-align','center');
       $('#model').val(model);$('#model').css('text-align','center');
       $('#term').val(term);$('#term').css('text-align','center');
       $('#cylinder').val(cylinder);$('#cylinder').css('text-align','center');

       $('.update').css('cursor','pointer');
       $('.updateclose').css('cursor','pointer');

     });
     $(document).on('click', '.delete', function(event){
       var id = event.target.id;
       $.ajax({
            url: '/car/delete/' + id,
            method: "DELETE",           
            cache: false,
            success: function(response) {
               $('#car-body tbody tr#' + id ).remove();
              
            },
            error: function(xhr) {
                console.log('error', xhr);
            }
       });

     });

     $(document).on('click', '.cancel', function(){
        
         $('.car-insert td').remove();
     });

     $(document).on('click', '.update', function() {
            var id = temp.id,
                make = $('#make').val(),
                year = $('#year').val(),
                model = $('#model').val(),
                term = $('#term').val(),
                cylinder = $('#cylinder').val();

            var data = {
                year : year,
                make : make,               
                model: model,
                term : term,
                cylinder: cylinder
            }

            $.ajax({
                url: '/car/update/' + id,
                method: "PUT",
                data: data,
                datatype: 'json',
                cache: false,
                success: function(response) {
                    window.location.href='/master';
                },
                error: function(xhr) {
                    console.log('error', xhr);
                }
            });
          
            
     });

     $(document).on('click', '.updateclose', function(){
        
          window.location.href = '/master';
     });

     /*
      **********************************************************************************
      * This function is used for getting inputed categorys name                       *
      *  We can calculate level and parent_id and then set QTY                         *                                                                               *
      **********************************************************************************      
      */
     function ajaxCategorySend (data) {
      $.ajax({
          url: '/service/insert',
          method: "POST",
          data: data,
          datatype: 'json',
          cache: false,
          success: function(response) {
            window.location.href='/master';
            //console.log(response);
          },
          error: function(xhr) {
              console.log('error', xhr);
          }
       });   
     }

     /*
      *  This function is used when new category is inputed.
      */
     $(document).on('click', '.category-save', function() {

       var  category      = $('#main_category').val(); if(category == 'undefined') category = null;
       var  sub_category  = $('#sub_category').val(); if(sub_category == 'undefined') sub_category = null;
       var  sub2_category = $('#sub2_category').val(); if(sub2_category == 'undefined') sub2_category = null;
       var  sub3_category = $('#sub3_category').val(); if(sub3_category == 'undefined') sub3_category = null;
       var  sub4_category = $('#sub4_category').val(); if(sub4_category == 'undefined') sub4_category = null;
       var  QTY  = $('#QTY').val(); if(QTY == 'undefined') QTY = null;
       var data = {

          category:category,
          sub_category:sub_category,
          sub2_category:sub2_category,
          sub3_category:sub3_category,
          sub4_category:sub4_category,
          QTY: QTY

       };   
       ajaxCategorySend(data);

     });

      /*
      **********************************************************************************
      * This function is used for getting inputed selected categorys name              *
      *  We can calculate level and parent_id and then set QTY                         *                                                                               *
      **********************************************************************************      
      */
      $(document).on('click', '.select-save', function() {
        var  category      = $("input[name='main_category']").val(); if(category == 'undefined') category = null;
        var  sub_category  = $("input[name='sub_category']").val(); if(sub_category == 'undefined') sub_category = null;
        var  sub2_category = $("input[name='sub2_category']").val(); if(sub2_category == 'undefined') sub2_category = null;
        var  sub3_category = $("input[name='sub3_category']").val(); if(sub3_category == 'undefined') sub3_category = null;
        var  sub4_category = $("input[name='sub4_category']").val(); if(sub4_category == 'undefined') sub4_category = null;
        var  QTY  = $('#QTY_select').val(); if(QTY == 'undefined') QTY = null;

        var data = {

          category:category,
          sub_category:sub_category,
          sub2_category:sub2_category,
          sub3_category:sub3_category,
          sub4_category:sub4_category,
          QTY: QTY

       };   
        console.log(data);
        ajaxCategorySend(data);

      });

      /*
       *  This function is used for editable category
       */
       $(document).on('click', '.category-edit', function(event){        
           var id = event.target.id,
               number = $('#number'+id).text(),
               category_name = $('#name'+id).text(),
               parent_id = $('#parent_id'+id).text(),
               level = $('#level'+id).text(),
               QTY = $('#QTY'+id).text();

           var data = {
              id: id,
              category_name : category_name,
              parent_id : parent_id,
              level : level,
              QTY : QTY
           };  
          
           temp_category = data;

        
           var newRow = $('#category-body tbody tr#' + id).html("<td><input class='form-control' type='text' id='number' value=''/></td><td><input class='form-control' type='text' id='categoryname' value=''/></td><td><input class='form-control' type='text' id='parent_id' value=''/></td><td><input class='form-control' type='text' id='level' value=''/></td><td><input class='form-control' type='text' id='insertQTY' value=''/></td><td class='category-update'>Save <i class='fa fa-save'></i></td><td class='category-close'>Cancel <i class='fa fa-close'></i></td>");
           $('#category-body tbody tr#' + id ).append(newRow);


           // set old content in text feild
           $('#number').val(number);$('#number').css('text-align','center');
           $('#categoryname').val(category_name);$('#categoryname').css('text-align','center');
           $('#parent_id').val(parent_id);$('#parent_id').css('text-align','center');
           $('#level').val(level);$('#level').css('text-align','center');
           $('#insertQTY').val(QTY);$('#insertQTY').css('text-align','center');         

           $('.category-update').css('cursor', 'pointer');
           $('.category-close').css('cursor', 'pointer');

           console.log(data);

        });

        $(document).on('click', '.category-update', function() {
            var id = temp_category.id,
                category_name = $('#categoryname').val(),
                parent_id = $('#parent_id').val(),
                level = $('#level').val(),
                QTY = $('#insertQTY').val();          

            var data = {
                category_name : category_name,
                level : level,               
                parent_id: parent_id,
                QTY : QTY
           
            };

            $.ajax({
                url: '/service/update/' + id,
                method: "PUT",
                data: data,
                datatype: 'json',
                cache: false,
                success: function(response) {
                   window.location.href='/master';
                },
                error: function(xhr) {
                    console.log('error', xhr);
                }
            });

        });

        $(document).on('click', '.category-close', function() {
            window.location.href = '/master';
        });

        $(document).on('click', '.category-delete', function(event){
           var id = event.target.id;
           $.ajax({
                url: '/service/delete/' + id,
                method: "DELETE",           
                cache: false,
                success: function(response) {
                   $('#category-body tbody tr#' + id ).remove();
                },
                error: function(xhr) {
                    console.log('error', xhr);
                }
           });

        });

        /*
         * This function is used for inputing new shop information in editable shop table. 
         */
        $(document).on('click', '.shop-new', function() {

           var newRow = $('#shop-body tbody tr.shop-insert').html("<td><input class='form-control' type='text' id='number' value=''/></td><td><input class='form-control' type='text' id='shop_name' value=''/></td><td><input class='form-control' type='text' id='zip_code' value=''/></td><td><input class='form-control' id='phonenumber' value=''/></td><td><input class='form-control' id='BARnumber' value=''/></td><td><input class='form-control' id='EPAnumber' value=''/></td><td class='shop-save'>Save <i class='fa fa-save'></i></td><td class='shop-cancel'>Cancel <i class='fa fa-close'></i></td>");
           $('#shop-body tbody tr.shop-insert').append(newRow);
           $('.shop-save').css('cursor','pointer');
           $('.shop-cancel').css('cursor','pointer');


        });

        /*
         *  This function is used for saving new shop information.
         */
        $(document).on('click', '.shop-save', function() {
            var shop_name = $('#shop_name').val(),
                zip_code = $('#zip_code').val(),
                phone_number = $('#phonenumber').val(),
                BAR_number = $('#BARnumber').val(),
                EPA_number = $('#EPAnumber').val();

            var data = {
               shop_name:shop_name,
               zip_code:zip_code,
               phone_number:phone_number,
               BAR_number:BAR_number,
               EPA_number:EPA_number
            };
             $.ajax({
                url: '/shop/insert',
                method: "POST",
                data: data,
                datatype: 'json',
                cache: false,
                success: function(response) {
                  //console.log(response);
                  window.location.href='/master';
                  
                },
                error: function(xhr) {
                    console.log('error', xhr);
                }
             });   

        });
        /*
         *  This function is used for canceling edit of new shop information.
         */
        $(document).on('click', '.shop-cancel', function() {
            $('.shop-insert td').remove();
        });
        /*
         *  This function is used for editing shop information.
         */
        $(document).on('click', '.shop-edit', function(){
           var id = event.target.id,
               number = $('#number'+id).text(),
               shop_name = $('#shop_name'+id).text(),
               zip_code = $('#zip_code'+id).text(),
               phone_number = $('#phonenumber' + id).text(),
               BARnumber = $('#BARnumber' + id).text(),
               EPAnumber = $('#EPAnumber' + id).text();     

           var data = {
              id: id,
              number:number,
              shop_name : shop_name,
              zip_code: zip_code,
              phone_number: phone_number,
              BARnumber:BARnumber,
              EPAnumber:EPAnumber             
           }  
          
           temp_shop = data;

        
           var newRow = $('#shop-body tbody tr#' + id).html("<td><input class='form-control' type='text' id='number' value=''/></td><td><input class='form-control' type='text' id='shop_name' value=''/></td><td><input class='form-control' type='text' id='zip_code' value=''/></td><td><input class='form-control' id='phonenumber' value=''/></td><td><input class='form-control' id='BARnumber' value=''/></td><td><input class='form-control' id='EPAnumber' value=''/></td><td class='shop-update'>Save <i class='fa fa-save'></i></td><td class='shop-close'>Cancel <i class='fa fa-close'></i></td>");
           $('#shop-body tbody tr#' + id ).append(newRow);


           // set old content in text feild
           $('#number').val(number);$('#number').css('text-align','center');
           $('#shop_name').val(shop_name);$('#shop_name').css('text-align','center');
           $('#zip_code').val(zip_code);$('#zip_code').css('text-align','center');
           $('#phonenumber').val(phone_number); $('#phonenumber').css('text-align','center');
           $('#BARnumber').val(BARnumber); $('#BARnumber').css('text-align','center');
           $('#EPAnumber').val(EPAnumber); $('#EPAnumber').css('text-align','center');
           $('.shop-update').css('cursor', 'pointer');
           $('.shop-close').css('cursor', 'pointer');

      });
        /*
         *  This function is used for deleting shop information.
         */
      $(document).on('click', '.shop-delete', function(){
         var id = event.target.id;
         $.ajax({
                url: '/shop/delete/' + id,
                method: "DELETE",           
                cache: false,
                success: function(response) {
                    $('#shop-body tbody tr#' + id ).remove();
                },
                error: function(xhr) {
                    console.log('error', xhr);
                }
         });
      });

      $(document).on('click', '.shop-update', function(){
            var id = temp_shop.id,
                shop_name = $('#shop_name').val(),
                zip_code = $('#zip_code').val(),
                phone_number = $('#phonenumber').val(),
                BARnumber =  $('#BARnumber').val(),
                EPAnumber =  $('#EPAnumber').val();               

            var data = {
               shop_name:shop_name,
               zip_code:zip_code,
               phone_number:phone_number,
               BAR_number:BARnumber,
               EPA_number:EPAnumber
            };
            console.log(data);
            $.ajax({
                url: '/shop/update/' + id,
                method: "PUT",
                data: data,
                datatype: 'json',
                cache: false,
                success: function(response) {
                   window.location.href='/master';
                },
                error: function(xhr) {
                    console.log('error', xhr);
                }
            });


     });

     $(document).on('click', '.shop-close', function(){
         // console.log('ok');
         // var id = temp_shop.id;
         // $('#shop-body tbody tr#' + id + ' td').remove();
         // var newRow = $('#shop-body tbody tr#' + id).html("<td id='"temp_shop.number"'>"temp_shop.number"</td><td id='"shop_name+id+"'>"temp_shop.shop_name"</td><td id='"zip_code+id+"'>"tem_shop.zip_code"</td><td class='shop-edit' id='"id"'><i class='fa fa-edit'></i>eidt</td><td class='shop-delete' id='"id"'><i class='fa fa-trash'></i>delete</td>");
         // $('#shop-body tbody tr#' + id ).append(newRow);

         window.location.href = '/master';
     });
     
    
});