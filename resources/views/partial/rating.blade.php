 <style>
 	.rating-star:before{
	  color: #4caf50;		
	  font-size: 1.05em;
	  font-family: FontAwesome;
	  display: inline-block;
	  content:"\f005";
	 
 	}
 	.rating-star-empty:before{
	  color: #ddd;		
	  font-size: 1.05em;
	  font-family: FontAwesome;
	  display: inline-block;
	  content:"\f005";
	
 	}
 </style>
 @if($item['rating'] == 5) 
	 <span class="rating-star"></span><span class="rating-star"></span><span class="rating-star"></span><span class="rating-star"></span><span class="rating-star"></span>
 @elseif($item['rating'] == 4)
     <span class="rating-star"></span><span class="rating-star"></span><span class="rating-star"></span><span class="rating-star"></span><span class="rating-star-empty"></span>
 @elseif($item['rating'] == 3)
     <span class="rating-star"></span><span class="rating-star"></span><span class="rating-star"></span><span class="rating-star-empty"></span><span class="rating-star-empty"></span>
 @elseif($item['rating'] == 2)
     <span class="rating-star"></span><span class="rating-star"></span><span class="rating-star-empty"></span><span class="rating-star-empty"></span><span class="rating-star-empty"></span>
 @else
    <span class="rating-star"></span><span class="rating-star-empty"></span><span class="rating-star-empty"></span><span class="rating-star-empty"></span><span class="rating-star-empty"></span>
 @endif
 <script>
 	$(document).ready(function(){ 
 		$('.rating-star').css('pointer-events', 'none');
 		$('.rating-star-empty').css('pointer-events', 'none');
 	});

 </script>