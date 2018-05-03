$(document).ready(function(){
    console.log('ok');
    /**
     *    Google Map integration
     */
   var number = parseInt( $('#number').val() );
   var coord = [];
   for (var i =1; i <= number; i++) {
     var data = [];
     data.push(parseFloat($('#lat'+i).val()));
     data.push(parseFloat($('#long'+i).val()));
     coord.push(data);
   }
 
   
    $(function() {    
          
          $("#map").googleMap({
            zoom: 6, // Initial zoom level (optional)
            coords: coord[3], // Map center (optional)
            type: "ROADMAP" // Map type (optional)
          });
          for (var i = 0; i < number; i++) {
            $("#map").addMarker({
               coords: coord[i],
               icon:'/images/car.png'
            });
          }
        
      });
    
  
});