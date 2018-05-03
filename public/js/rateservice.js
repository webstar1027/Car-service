$(document).ready(function(){  
  var mark;  
  var number;
  var service_date;
  var rate = $('#rate_status').val();
  $(document).on('click', 'td.rate', function(event) {
    if(rate == '') {
      var id = event.target.id.replace('mark', '');
      number = $('.'+ id).val();
      service_date = $('table tbody tr#'+id+' td:nth-child(3)').text();
      $('#myModal').modal('show');
    }
    else{
      alert('You gave rating already');
    }
  });

  $('input[type=radio]').on('click', function(event) {
    var id = parseInt(event.target.id.replace('star', ''));
    mark = id;
    console.log(id);
  });

  $(document).on('click', '.number_save', function(){    
    var data = {
     	id:number,
     	rate:mark,
      service_date:service_date
    };
  	$.ajax({
      url: '/shop/service/rate',
      method: "POST",
      data: data,
      datatype: 'json',
      cache: false,
      success: function(response) {           
        window.location.href = '/rate';                
      },
      error: function(xhr) {
          console.log('error', xhr);
      }

  	 });
  	 console.log(data);
  });


});
