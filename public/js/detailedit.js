$(document).ready(function(){  
       
    var item_description = [],
        item_price = [],
        item_type = [],
        masterservice_name,            
        complete_time,
        service_schedule,
        service_description,
        flag = false,
        total_price,
        item_number = parseInt($('input[name=item_number]').val()),
        editid;


    $(document).on('click', '#multiservice_create',function(){
          
      // Get default price applied
      console.log();
      if ($('#service_schedule option:selected').val() == ''){
        $('#myModal').modal('show');
      }
      else{

        var year =[],
        make =[],
        model=[],
        term =[],
        car = [],
        car_data = {},
        category_name;           
        item_price = [];
        edit_total_price = [];
        edit_description = [];
        $('#service_body tbody tr td:nth-child(2)').each(function(){
             year.push($(this).text());
        });
        $('#service_body tbody tr td:nth-child(3)').each(function(){
             make.push($(this).text());
        });
        $('#service_body tbody tr td:nth-child(4)').each(function(){
             model.push($(this).text());
        });
        $('#service_body tbody tr td:nth-child(5)').each(function(){
             term.push($(this).text());
        });
        for (var i = 1; i <= year.length; i++) {
            var price = [];
            for (var j = 0; j < item_number; j++) {
              price[j]= parseInt($("#service_body tr#"+i+" td:nth-child("+(7+j+1)+")").text());
            }
            edit_total_price.push(parseInt($("#service_body tr#"+i+" td:nth-child("+(8+item_number)+")").text()))
            edit_description.push($("#service_body tr#"+i+" td:nth-child("+(10+item_number)+")").text());
            item_price.push(price);

        }
      
        for (var i = 0; i< year.length ; i++) {
          car_data = {
            year:year[i],
            make:make[i],
            model:model[i],
            term:term[i]
          }
          car.push(car_data);
        }
        category_name = $("#service_body tbody tr:first td:nth-child(6)").text();         
        var data = {
          car: car,
          category_name:category_name,  
          item_type:item_type,
          item_price:item_price,
          item_description:item_description,
          total_cost: edit_total_price,
          description: edit_description,       
          complete_time:complete_time,                    
          masterservice_name:masterservice_name,
          service_schedule:service_schedule
        };
        $.ajax({
            url: '/multiserivce/create',
            method: "POST",
            data: data,
            datatype: 'json',
            cache: false,
            success: function(response) {           
             console.log(response);
             window.location.href = '/multiserivce/create/confirm';               
            },
            error: function(xhr) {
                console.log('error', xhr);
            }
        });          
        console.log(data);

      }
    
         
     });
   /**
    *    Apply default values
    */
    $(document).on('click', '.apply', function(event) {
      
      var id = event.target.id.replace('apply','');
      console.log(id);
      /**
       *    identify table cell information from pricing default table.
       */
       total_price = 0;
       item_description.push($('#item_description'+id).val()),
       
       item_price.push(parseInt($('#item_price'+id).val()));
       var display_price = $('#item_price'+id).val(),
           display_description = $('#item_description'+id).val();
       if($('#default_part tbody tr:first td:nth-child(3)').text() == 'Call for Price'){
          var display_type = 'Call for Price';
          item_type.push('call for price');
       }
       else{
           var display_type = $('#item_type'+id+' option:selected').val();
           item_type.push($('#item_type'+id+' option:selected').val());
       }
       var newCell = $('#default_part tbody tr#'+id).html($("<td>"+id+"</td><td>"+display_description+"</td><td>"+display_type+"</td><td>"+display_price+"</td><td><span class='glyphicon glyphicon-ok' style='cursor: pointer;'> Applied</span></td>"));
       $('#default_part tbody tr#'+id).append(newCell);
       /**
        *   insert default values to dynamical table
        */
        $('#service_body').find('.'+id).html(display_price); 
        for(var i = 0; i< item_price.length; i++){
            total_price = total_price + item_price[i];
        } 
        $('#service_body').find('.total').html(total_price); 
    });
    /**
     *    apply service edit description
     */
    $(document).on('click', '#service_edit', function(){
        masterservice_name = $('#masterservice_name').val(),
       
     
        complete_time = $('#complete_time option:selected').val();
        service_description = $('#service_description').val(); 

        $('#service_body').find('.complete_time').html(complete_time); 
        $('#service_body').find('.description').html(service_description); 
    });
    /**
     *   apply schedualing option
     */
     $(document).on('click', '#schedul_apply', function(){     

       var schedule_option = $('#service_schedule option:selected').val(); 
       $('#service_body').find('.scheduale').html(schedule_option); 
       service_schedule = schedule_option; 
       console.log('ok');

     });

     var plan = $('input[name=plan]').val();
 
     if(plan == '480'){
       var newcell = $('#service_schedule').html("<option selected hidden></option><option value='call for service'>Call for Service</option><option value ='schedule service'>Schedule Sevice</option><option value='call or schedule for service'>Call or Schedule Service</option>");
       $('#service_schedule').append(newcell);
     }
     else{
       var newcell = $('#service_schedule').html("<option value='call for service'>Call for Service</option>");
       $('#service_schedule').append(newcell); 
     }

    /*
     *  edit child service 
     */
     $(document).on('click', '.edit', function(event){
       
       editid = event.target.id.replace('edit', '');
      
       for(var i=1; i<=item_number; i++){

         var price = $("#service_body tr#"+editid+" td:nth-child("+(7+i)+")").text();
         var newcell = $("#service_body tr#"+editid+" td:nth-child("+(7+i)+")").html("<input class='form-control' style='text-align:center;' id='item"+i+"' value='"+price+"'/>");
         $("#service_body tr#"+editid+" td:nth-child("+(7+i)+")").append(newcell);
       
       }
       var description = $("#service_body tr#"+editid+" td:nth-child("+(10+item_number)+")").text();
       var newcell1 = $("#service_body tr#"+editid+" td:nth-child("+(10+item_number)+")").html("<input class='form-control' style='text-align:center;' id='description_edit' value='"+description+"'/>");
       $("#service_body tr#"+editid+" td:nth-child("+(10+item_number)+")").append(newcell1);
     });

     $(document).on('click', '.save', function(event) {

       var id = event.target.id.replace('save', '');
      
       var description = $('#description_edit').val();
       $("#service_body tr#"+id+" td:nth-child("+(10+item_number)+")").html(description);
       var sum = 0;
       for(var i=1; i<=item_number; i++){
        var price = $("#item"+i).val();       
        $("#service_body tr#"+id+" td:nth-child("+(7+i)+")").html(price);  
        sum = sum + parseInt(price);     
       }
       $("#service_body tr#"+id+" td:nth-child("+(8+item_number)+")").html(sum);

     });
      /*
      *    input parts_price
      */
     for(var i = 1 ; i <= item_number; i++) {
       console.log(i);
       var selector = 'item' + i;
       $(document).on('input', '#'+ selector, function(){
          var total_price = getTotal();
          $("#service_body tbody tr#"+editid+" td:nth-child("+(8+item_number)+")").text(total_price);
       });
     }
     function getTotal() {
      var total = 0;
       for(var i = 1; i<=item_number; i++) {
          var selector = 'item' + i;          
          total = total + parseInt($("#service_body tbody tr#"+editid).find('#'+selector).val());
       }
       return total;
     }

});
