$(document).ready(function(){  

  var always_update_id,
      always_delete_id,
      onetime_update_id,
      onetime_delete_id;
   $(function () {     
     $('#alwaysdatepicker').datetimepicker({
          format: 'YYYY-MM-DD'
     });
     $('#alwaystimepicker1').datetimepicker({
          format: 'LT'
     });     
     $('#alwaystimepicker2').datetimepicker({
          format: 'LT'
     });      
     $('#onetimedatepicker').datetimepicker({
          format: 'YYYY-MM-DD'
     });
     $('#onetimetimepicker1').datetimepicker({
          format: 'LT'
     });     
     $('#onetimetimepicker2').datetimepicker({
          format: 'LT'
     });      
     
     var total_number = parseInt($('#total_number').val());
     for (var i =  1; i <= total_number; i++) {

       $('#alwayspicker'+i).datetimepicker({
          format: 'YYYY-MM-DD'
       });
       $('#alwaysopentime'+i).datetimepicker({
            format: 'LT'
       });     
       $('#alwaysclosetime' + i).datetimepicker({
            format: 'LT'
       });   
       $('#onetimepicker'+i).datetimepicker({
          format: 'YYYY-MM-DD'
       });
       $('#onetimeopentime'+i).datetimepicker({
            format: 'LT'
       });     
       $('#onetimeclosetime' + i).datetimepicker({
            format: 'LT'
       });   


     }
     
   });

   $(document).on('click', '#always_save', function () {

      var block_description = $('input[name="block_description"]').val(),
          alwaysdate = $('#alwaysblock option:selected').val(),
          always_start_time = $('input[name="always_start_time"]').val(),
          always_end_time = $('input[name="always_end_time"]').val(),
          id = $('#shop_id').val();

      
      var data = {
          block_description : block_description,
          alwaysdate : alwaysdate,
          always_start_time : always_start_time,
          always_end_time : always_end_time,
          id : id
      };

      $.ajax({
          url: '/shop/block/always',
          method: "POST",
          data: data,
          datatype: 'json',
          cache: false,
          success: function(response) {           
           console.log(response);
           window.location.href = '/shop/block_schedule/edit/' + id;
          
          },
          error: function(xhr) {
              console.log('error', xhr);
          }
      });
      // console.log(data);

      console.log(data);

   });

   /*
    *  one time block schedule
    */
     $(document).on('click', '#one_time_save', function () {

        var block_description = $('input[name="one_time_description"]').val(),
            onetimedate = $('input[name="onetime_open_date"]').val(),
            onetime_start_time = $('input[name="onetime_open_time1"]').val(),
            onetime_end_time = $('input[name="onetime_open_time2"]').val(),
            id = $('#shop_id').val();

        var data = {
            block_description : block_description,
            onetimedate : onetimedate,
            onetime_start_time : onetime_start_time,
            onetime_end_time : onetime_end_time,
            id : id
        };

        $.ajax({
            url: '/shop/block/onetime',
            method: "POST",
            data: data,
            datatype: 'json',
            cache: false,
            success: function(response) {           
             console.log(response);
             window.location.href = '/shop/block_schedule/edit/' + id;
            
            },
            error: function(xhr) {
                console.log('error', xhr);
            }
        });
        console.log(data);

   });

 /*
  *   Always block time schedule update
  */

  $(document).on('click', '.always-update', function(event) {
    always_update_id = parseInt(event.target.id.replace('alwaysupdate', ''));     
    $('#myModal').modal('show');
  });

  $(document).on('click', '.always_confirm', function(){
    var block_description = $("input[name='alwaysdescription"+always_update_id+"']").val(),
        date = $("select#alwaysdate"+always_update_id+" option:selected").val(),
        start_time = $("input[name='alwaysstarttime"+always_update_id+"']").val(),
        end_time = $("input[name='alwaysendtime"+always_update_id+"']").val();
    var shop_id = $('#shop_id').val();
    var data = {
      description : block_description,
      date : date,
      start_time : start_time,
      end_time : end_time,
      id:always_update_id
    };  

    $.ajax({
        url: '/shop/block/always/update',
        method: "POST",
        data: data,
        datatype: 'json',
        cache: false,
        success: function(response) {           
         console.log(response);
         window.location.href = '/shop/block_schedule/edit/' + shop_id;
        
        },
        error: function(xhr) {
            console.log('error', xhr);
        }
    });

    console.log(data);
  })
  /*
  *   One time block time schedule update
  */

  $(document).on('click', '.onetime-update', function(event) {
    onetime_update_id = parseInt(event.target.id.replace('onetimeupdate', ''));
    $('#myModal2').modal('show');

  });

  $(document).on('click', '.onetime_confirm', function(){
    var block_description = $("input[name='onetimedescription"+onetime_update_id+"']").val(),
        date = $("input[name='onetimedate"+onetime_update_id+"']").val(),
        start_time = $("input[name='onetimestarttime"+onetime_update_id+"']").val(),
        end_time = $("input[name='onetimeendtime"+onetime_update_id+"']").val();
    var shop_id = $('#shop_id').val();
    var data = {
      description : block_description,
      date : date,
      start_time : start_time,
      end_time : end_time,
      id:onetime_update_id
    };  

    $.ajax({
        url: '/shop/block/onetime/update',
        method: "POST",
        data: data,
        datatype: 'json',
        cache: false,
        success: function(response) {           
         console.log(response);
         window.location.href = '/shop/block_schedule/edit/' + shop_id;
        
        },
        error: function(xhr) {
            console.log('error', xhr);
        }
    });
    console.log(data);
  });

  $(document).on('click', '.always-delete', function(event) {
    always_delete_id = parseInt(event.target.id.replace('alwaysdelete', ''));
    $('#myModal1').modal('show');

  });

  $(document).on('click', '.always_delete', function(){
    var shop_id = $('#shop_id').val();
    var data = {
      id:always_delete_id
    };
    $.ajax({
        url: '/shop/block/always/delete',
        method: "POST",
        data: data,
        datatype: 'json',
        cache: false,
        success: function(response) {           
         console.log(response);
         window.location.href = '/shop/block_schedule/edit/' + shop_id;
        
        },
        error: function(xhr) {
            console.log('error', xhr);
        }
    });
  });


  $(document).on('click', '.onetime-delete', function(event) {
    onetime_delete_id = parseInt(event.target.id.replace('onetimedelete', ''));
    $('#myModal3').modal('show');

  });

  $(document).on('click', '.onetime_delete', function(){
    var shop_id = $('#shop_id').val();
    var data = {
      id:onetime_delete_id
    };
    $.ajax({
        url: '/shop/block/onetime/delete',
        method: "POST",
        data: data,
        datatype: 'json',
        cache: false,
        success: function(response) {           
         console.log(response);
         window.location.href = '/shop/block_schedule/edit/' + shop_id;
        
        },
        error: function(xhr) {
            console.log('error', xhr);
        }
    });
  });




});
