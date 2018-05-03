$(document).ready(function(){  


   $(function () {     
     for(var i=1; i<15; i++){
       $('#datetimepicker'+i).datetimepicker({
                  format: 'LT'
       });
     }
   });

   $('input[type=checkbox]').on('click', function(){


    var id = parseInt($(this).attr('id'));
    console.log(id);
     if($(this).is(':checked') ) {
       
       $('#datetimepicker' + id).datetimepicker('disable');
       $('#datetimepicker' + (id+7)).datetimepicker('disable');
     }
     else{     

       $('#datetimepicker' + id).datetimepicker('enable');
       $('#datetimepicker' + (id+7)).datetimepicker('enable');
     }
   });

});
