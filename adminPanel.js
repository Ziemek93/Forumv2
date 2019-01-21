 $(document).ready(function() {
 
var activeUser = "";



$(".profileNick").hover(function(){
	 
	 
    $(this).css("background-color", "#99ccff");
    }, function(){
					$(this).css("background-color", "inherit");
				}


);



$('.profileNick').on('click', function(buttonevent) {
  buttonevent.preventDefault();
  
  activeUser = $(this).children().text();
  
  
  $('#delete').text("delete " + activeUser);
  $('#promote').text("promote " + activeUser);
  
  $( ".profileNick" ).each(function() // po stronie phpa trzeba to ogarnac
			{
				 $(this).css({"background-color":"inherit  "});
				 
				 
			});
  
	$( this ).css({"background-color":"#54FF76"});
				  
	});

	
$('#delete').on('click', function(buttonevent) {
  buttonevent.preventDefault();
  
  	if(activeUser != "")
	{
		$.ajax({
				type: 'POST',
				url: 'checkThings.php',
				data: {deleteHim : activeUser},
				success:  console.log('gut'),
				error: function(xhr, status, error) 
				{
					console.log(error);
				}
		});
		
		//location.reload();
	 }
  
	});
	
	 	 
 
	
$('#promote').on('click', function(buttonevent) {
  buttonevent.preventDefault();
   
   	if(activeUser != "")
	{
		$.ajax({
				type: 'POST',
				url: 'checkThings.php',
				data: {promoHim : activeUser},
				success:  console.log('gut'),
				error: function(xhr, status, error) 
				{
					console.log(error);
				}
		});
		
		location.reload();
	 }
	 
});
	
 //location.reload();
 
//var c = $('#content').val();
//$('#content').val('');
//activeUser = $(this).children().text();
//$('#activeU').text(activeUser);
    
  




});