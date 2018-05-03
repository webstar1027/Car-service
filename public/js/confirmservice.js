$(document).ready(function(){  
       
     
     var temp = {} ;
     var number = null;  
     number = $('table#service_body tr:first td').length;    
     $(document).on('click', '.edit', function(event){        
          var id = event.target.id.replace('edit', '');

         /**
          *   Get current displayed data 
          */
         
          var complete_time = $('#complete_time' + id).text();
             
          var schedule = $("#service_body tbody tr:first td:nth-child("+ (number-3) +")").text();
          var item_price = [];
          var data = {
            id:id,
            item_number:number-12
          };
          temp = data;
          for( var i = 0; i< number-12; i++){
            var child = 7 + i +1;
            item_price[i] = $("#service_body tbody tr#"+id+" td:nth-child("+child+")").text();
          }     
          var newcell = $("#service_body tbody tr#"+id+" td:nth-child(7)").html("<input class='form-control' id='complete_time' value='"+complete_time+"'/>");
          $("#service_body tbody tr#"+id+" td:nth-child(7)").append(newcell);
          $('#complete_time').css('text-align','center'); 
          for( var i = 0; i< number-12; i++){
            var child = 7 + i +1;
            var newCell =  $("#service_body tbody tr#"+id+" td:nth-child("+child+")").html("<input class='form-control' id='item_price"+(i+1)+"' value='"+item_price[i]+"'/>");
             $("#service_body tbody tr#"+id+" td:nth-child("+child+")").append(newCell);
             $("#item_price"+(i+1)).css('text-align','center'); 
          }  

           var text = ['Call for Service  Option', 'Scheduale Service Option', 'Call or Schedual for Service Option'];
           newcell = $("#service_body tbody tr#"+id+" td:nth-child("+ (number-3) +")").html("<select class='form-control' id='service_schedule"+id+"'><option selected hidden>"+schedule+"</option></select>");
           $("#service_body tbody tr#"+id+" td:nth-child("+ (number-3) +")").append(newcell);
           for( var i = 0; i< text.length; i++){
             $('#service_schedule'+id).append($('<option>', { 
                  value: text[i],
                  text : text[i] 
               }));
           }
           newcell = $("#service_body tbody td#edit"+id).html("<td id='save' ><i class='fa fa-save'></i>save</td>");
           $("#service_body tbody td#edit"+id).append(newcell);
           newcell = $("#service_body tbody td#delete"+id).html("<td id='cancel' style='cursor:pointer;'><i class='fa fa-close'></i>cancel</td>");
           $("#service_body tbody td#delete"+id).append(newcell);  
           $("#service_body tbody td#delete"+id).removeClass("delete");   
          
      });

     $(document).on('click', '#cancel', function(){
        window.location.href = '/multiserivce/create/confirm';
     });
     /*
      *    Save updated service data
      */
     $(document).on('click', '#save', function(){
         
         item_price =[];
         console.log(temp['item_number']);
         if(temp['item_number'] == 1) {
           item_price.push($("#item_price1").val());
           var data = {
             id : temp['id'],
             total_price: $("#service_body").find('#total'+temp['id']).text(),
             complete_time: $('#complete_time').val(),
             service_schedule: $('#service_schedule'+temp['id']+' option:selected').val(),
             item_price:item_price          
           };
         }
         else{
           for( var i = 1; i<=temp['item_number']; i++){
             var key = 'item' + i;
             var child = 7 + i;
             item_price.push( $("#item_price" + i).val());
           }
           var data = {
             id : temp['id'],
             total_price: $("#service_body").find('#total'+temp['id']).text(),
             complete_time: $('#complete_time').val(),
             service_schedule: $('#service_schedule'+temp['id']+' option:selected').val(),
             item_price:item_price          
           };
         }
         console.log(data);
        
         $.ajax({
            url: '/shop/service/update',
            method: "POST",
            data: data,
            datatype: 'json',
            cache: false,
            success: function(response) {
              console.log(response);
              window.location.href='/multiserivce/update/confirm';
            },
            error: function(xhr) {
                console.log('error', xhr);
            }
         });
         // console.log(temp['item_number']);

        

     });
     /*
      *    input parts_price
      */
     for(var i = 1 ; i <= number-12; i++) {
       console.log(i);
       var selector = 'item_price' + i;
       $(document).on('input', '#'+ selector, function(){
          var total_price = getTotal();
          $("#service_body tbody tr#"+temp['id']+" td:nth-child("+(number-4)+")").text(total_price);
       });
     }
     function getTotal() {
      var total = 0;
       for(var i = 1; i<=number-12; i++) {
          var selector = 'item_price' + i;          
          total = total + parseInt($("#service_body tbody tr#"+temp['id']).find('#'+selector).val());
       }
       return total;
     }
     /** 
      *   Delete selected service
      */
    $(document).on('click', '.delete', function(event){

         var id = event.target.id.replace('delete', '');
         console.log(id);
         var data = {
           id : id
         };
         console.log('/shop/service/delete/' + id)
         $.ajax({
            url: '/shop/service/delete/' + id,
            method: "DELETE",         
            cache: false,
            success: function(response) {
              console.log(response);
              window.location.href='/multiserivce/delete/confirm';
            },
            error: function(xhr) {
                console.log('error', xhr);
            }
         });


    });  

});
