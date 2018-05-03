$(window).on('hashchange', function() {
    if (window.location.hash) {
        var page = window.location.hash.replace('#', '');
        if (page == Number.NaN || page <= 0) {
            return false;
        }else{
            getData(page);
        }
    }
});
function getData(page){
    $.ajax(
    {
        url: '?page=' + page,
        type: "get",
        datatype: "html",
    })
    .done(function(data)
    {
        $(".serviceofcar").empty().html(data);
        location.hash = page;
    })
    .fail(function(jqXHR, ajaxOptions, thrownError)
    {
          alert('No response from server');
    });
}
$(document).ready(function(){
	  var  count_select = false,
         count_car = false,
         category_name,
         temp_service = {};

    /*
     *  This function is for pagination.
     */
     $(document).on('click', '.pagination a',function(event)
    {
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');
        event.preventDefault();

        var myurl = $(this).attr('href');
        var page=$(this).attr('href').split('page=')[1];

        getData(page);
    });
    /*
     *  This function is used for editable service
     */
     $(document).on('click', '.service-edit', function(event){ 

       var id = event.target.id,
           number = $('#number'+id).text(),
           category_name = $('#name'+id).text(),
           make = $('#make'+id).text(),
           year = $('#year'+id).text(),
           model = $('#model'+id).text(),
           term = $('#term'+id).text(),
           cylinder = $('#cylinder'+id).text(),
           price = $('#price'+id).text(),
           descriptions = $('#description'+id).text();
      var data = {
          id : id,
          number:number,
          category_name:category_name,
          make:make,
          year:year,
          model:model,
          term:term,
          cylinder:cylinder,
          price:price,
          descriptions:descriptions
      }
      console.log(data);
      temp = data;
      var newRow = $('#service_body tbody tr#' + id).html("<td><input class='form-control' type='text' id='number' value=''/></td><td><input class='form-control' type='text' id='name' value=''/></td><td><input class='form-control' type='text' id='car_year' value=''/></td><td><input class='form-control' type='text' id='car_make' value=''/></td><td><input class='form-control' type='text' id='car_model' value=''/></td><td><input class='form-control' type='text' id='car_term' value=''/></td><td><input class='form-control' type='text' id='car_cylinder' value=''/></td><td><input class='form-control' type='text' id='service_price' value=''/></td><td><input class='form-control' type='text' id='service_description' value=''/></td><td class='service-update'>Save <i class='fa fa-save'></i></td><td class='service-close'>Cancel <i class='fa fa-close'></i></td>");
      $('#service_body tbody tr#' + id ).append(newRow);

      // get original information
      $('#number').val(number);$('#number').css('text-align','center');
      $('#name').val(category_name);$('#name').css('text-align','center');
      $('#car_year').val(year);$('#car_year').css('text-align','center');
      $('#car_make').val(make);$('#car_make').css('text-align','center');
      $('#car_model').val(model);$('#car_model').css('text-align','center');
      $('#car_term').val(term);$('#car_term').css('text-align','center');
      $('#car_cylinder').val(cylinder);$('#car_cylinder').css('text-align','center');
      $('#service_price').val(price);$('#service_price').css('text-align','center');
      $('#service_description').val(descriptions);$('#service_description').css('text-align','center');
      
      $('.service-update').css('cursor','pointer');
      $('.service-close').css('cursor','pointer');
     });


     $(document).on('click', '.service-update', function(){

       var category_name = $('#name').val(),
           year = $('#car_year').val(),
           make = $('#car_make').val(),
           model = $('#car_model').val(),
           term = $('#car_term').val(),
           cylinder = $('#car_cylinder').val(),
           price = $('#service_price').val(),
           descriptions = $('#service_description').val();
      var data = {        
          category_name:category_name,
          make:make,
          year:year,
          model:model,
          term:term,
          cylinder:cylinder,
          price:price,
          descriptions:descriptions
      };
      console.log(data);
      $.ajax({
          url: '/service/shop/update',
          method: "POST",
          data: data,
          datatype: 'json',
          cache: false,
          success: function(response) {
              if(response == 'car') {
                 window.location.href = '#modal';
              }
              else if(response == 'false'){
                 window.location.href = '#modal1';
              }
              else{
                window.location.href='/shopowner';
              }
              
          },
          error: function(xhr) {
              console.log('error', xhr);
          }
        });

     });
     $(document).on('click', '.service-close', function(){
        window.location.href ='/shopowner';
     });

     $(document).on('click', '.service-delete', function(event) {


        var id = event.target.id;      
        $.ajax({
            url: '/shop/service/delete/' + id,
            method: "DELETE",           
            cache: false,
            success: function(response) {
               $('#service_body tbody tr#' + id ).remove();              
            },
            error: function(xhr) {
                console.log('error', xhr);
            }
       });


     });


   $(document).on('click', '#parts', function(){
      if( $(this).is(':checked') ){
         $('#itemtype_part').show();
      }
      else{
         $('#itemtype_part').hide();
      }
   });
  $(document).on('click', '#labor', function(){
      if( $(this).is(':checked') ){
         $('#itemtype_labor').show();
      }
      else{
         $('#itemtype_labor').hide();
      }
   });

  /**
   *   master serivce detail page navigation
   */

   


    
});