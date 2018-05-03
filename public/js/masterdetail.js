
$(document).ready(function(){      

   var item_number = $('#price_body tr:first td').length - 11;
   var item_price;
   var temp = {};
   $(document).on('click', '.edit', function(event){
	   var id = event.target.id.replace('edit', '');
	   temp['id'] = id;
	   item_price = [];
	   for (var i = 0; i < item_number; i++) {
	   	 item_price.push($("#price_body tbody tr#"+id+" td:nth-child("+(8+i)+")").text());
	   	
	   }
	   for (var i = 0; i < item_number; i++) {
	
         var newcell = $("#price_body tbody tr#"+id+" td:nth-child("+(8+i)+")").html($("<input class='form-control' id='item_price"+(i+1)+"' value='"+item_price[i]+"'/>"));
         $("#price_body tbody tr#"+id+" td:nth-child("+(8+i)+")").append(newcell);
         $('#item_price'+(i+1)).css('text-align','center');
	   }

	   var newcell = $("#price_body tbody td#edit"+id).html("<td id='save' ><i class='fa fa-save'></i>save</td>");
       $("#price_body tbody td#edit"+id).append(newcell);
       newcell = $("#price_body tbody td#delete"+id).html("<td id='cancel' style='cursor:pointer;'><i class='fa fa-close'></i>cancel</td>");
       $("#price_body tbody td#delete"+id).append(newcell);  
       $("#price_body tbody td#delete"+id).removeAttr("onclick"); 
	   
   });
   /**
    *    total price change whenever text field value is changed
    */
    for(var i = 1 ; i <= item_number; i++) {
       console.log(i);
       var selector = 'item_price' + i;
       $(document).on('input', '#'+ selector, function(){
          var total_price = getTotal();
          $("#price_body tbody tr#"+temp['id']+" td:nth-child("+(7+i)+")").text(total_price);
       });
     }
     function getTotal() {
      var total = 0;
       for(var i = 1; i<=item_number; i++) {
          var selector = 'item_price' + i;          
          total = total + parseInt($("#price_body tbody tr#"+temp['id']).find('#'+selector).val());
       }
       return total;
     }

     $(document).on('click', '#cancel', function(){
        // window.location.href = '/multiserivce/create/confirm';
        var id = $('#master_id').val();
        window.location.href = '/master/detail/' + id;
     });
  
     /**
      *   Line item price update
      */      
     $(document).on('click', '#save', function(){
         
         item_price =[];
         
         if(item_number == 1) {
           item_price.push($("#item_price1").val());
           var data = {
             id : temp['id'],
             total_price: $("#price_body").find('#total'+temp['id']).text(),            
             item_price:item_price,
             master_id: $('#master_id').val()          
           };
         }
         else{
           for( var i = 1; i<=item_number; i++){
             var key = 'item' + i;
             var child = 6 + i;
             item_price.push( $("#item_price" + i).val());
           }
           var data = {
             id : temp['id'],
             total_price: $("#price_body").find('#total'+temp['id']).text(),                         
             item_price:item_price,
             master_id: $('#master_id').val()           
           };
         }
         console.log(data);
         console.log(item_number);        
         $.ajax({
            url: '/master/service/update',
            method: "POST",
            data: data,
            datatype: 'json',
            cache: false,
            success: function(response) {
              console.log(response);
              window.location.href='/master/detail/'+data['master_id'];
            },
            error: function(xhr) {
                console.log('error', xhr);
            }
         });

       });


     /*
      *    check box selection part 
      */
      $(document).on('click', '#all', function(){
         if ($('#all').is(':checked')) {
           $('input[type=checkbox').prop('checked', true);
         }
         else{
           $('input[type=checkbox').prop('checked', false);
         }
      });
     
      /*
       *   Send service action to backend
       */
       $(document).on('click', '#submit', function(){
          var val = [];
          $(':checkbox:checked').each(function(i){
            val[i] = $(this).val();
          });
          var index = val.indexOf("all");
          if(index >=0 ){
            val.splice(index, 1);
          }
          console.log(val);
          var master_id = $('#master_id').val();
          var action = $('#service_action option:selected').val();
          var data = {
            id: val,
            action:action,
            master_id:master_id
          }

          if( val.length == 0) {
            window.location.href = '#modal';
          }else if(action == ''){
             window.location.href = '#modal1';
          }
          else{
            $.ajax({
              url: '/service/action',
              method: "POST",
              data: data,
              datatype: 'json',
              cache: false,
              success: function(response) {
                console.log(response);
                window.location.href='/service/action/confirm';
              },
              error: function(xhr) {
                  console.log('error', xhr);
              }
           });
          }

          console.log(data);


       });
   
});
