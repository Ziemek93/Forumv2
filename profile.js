 $(document).ready(function() {
 
 
	
 
	 	 
 $('#delete').on('click', function(buttonevent) {
  buttonevent.preventDefault();
  
  	 var url = new URL(window.location.href );
	var get = url.searchParams.get("lo");
	//console.log(c);
	
		$.ajax({
				type: 'POST',
				url: 'checkThings.php',
				data: {deleteHim : get},
				success:  console.log('gut'),
				error: function(xhr, status, error) 
				{
					console.log(error);
				}
		});
		//location.reload();
	  
  
	});
	
	

	
 
	
 //location.reload();
 
//var c = $('#content').val();
//$('#content').val('');
//activeUser = $(this).children().text();
//$('#activeU').text(activeUser);
    
  




});