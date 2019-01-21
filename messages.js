$(document).ready(function() {
var phpError = " ";
var activeUser ="";
var userId = 0;
var date = "0000-00-00";
var askServer = function() {
	//console.log("S-------------------------------------------------------------------------------------------------");
	//console.log("Data: " + date);
	//console.log("E-------------------------------------------------------------------------------------------------");
	
 
	$.get('messagesQuery.php', function(result) {
		//alert(result.convWithA);

	var i = 0;
    if(result)
    {
		$.each(result.convWithA, function(num, value) { // idx to obiekt po ktorym sie poruszam w funkcji czyli elementy tabliy ['']
		  var add = true;
		  var nickList;
		  //alert(value);
		   
			$( ".profileNick" ).each(function() // po stronie phpa trzeba to ogarnac
			{
				 if($(this).children().text()== value)
				{add = false;}
				 
			});
		   if(add == true)
		   {
			   nickList = $('<div id = "' + userId +'"class = "profileNick"><a >' + 
					 value + 
					 '</a> </div>');
		   
			  userId++;
			  i++;
			  $('#messUsers').append(nickList);
		   }
		});
		if(result.errorMessage.length > 0){console.log(result.errorMessage);}
	}
	else
	{
		//alert(ERROR);
		console.log("Users load error ");
	}
	});
	
	
	
	//console.log(activeUser);
    if(activeUser.length != "")
	{
			//console.log("User choosen " + activeUser);
			
	$.ajax({
		type: 'POST',
		url: 'messagesQuery.php',
		data: {friendLogin : activeUser, lastMessage : date},
	    dataType: 'json',
		success: function(data) {
			 
		if(data)
		{			
			$.each(data.content_messageA, function(num, value) 
			{
			//console.log(num + " - " +value);
		 
		  var messageContent;
		  
		  if(data.ownerA[num] == "i"){  //this.wyslana_przez == 'ja') {
			messageContent = ('<div class = "messageCloudIncom"><a>' + 
					 value + 
					 '</a></div>');
		  } else {
			messageContent = ('<div class = "messageCloudSend"><a>' + 
					 value + 
					 '</a></div>');
		  }
		 
		  $('#messContent').append(messageContent);
			
				 
			});
		}
		 
		if(data.errorMessage.length > 0 ){console.log(data.errorMessage);}
		date = data.lastMessage;
		},
		error: function(xhr, status, error) {
			//console.log(error);
		}
	});
		
 
	
	}
	else
	{
		//alert(ERROR);
		console.log("Messages load error ");
	}
    
	 
	
		setTimeout(askServer, 1000);
   
}


$('#send').on('click', function(buttonevent) {
  buttonevent.preventDefault();
   
  var c = $('#content').val();
  $('#content').val('');
   
  //console.log(c);
   	$.ajax({
		type: 'POST',
		url: 'messagesQuery.php',
		data: {content : c, friendLogin : activeUser},
	    dataType: 'json',
		success:  console.log('gut'),
		error: function(xhr, status, error) {
			console.log(error);
		}
	}); 
  
});

//data_string = 'friendLogin=' + activeUser + '&lastMessage=' + date;

var userid= 0
 
 
	
$(document).on("click","div.profileNick", function(eventUser) {
    eventUser.preventDefault();
	 $('#messContent').empty();
	
	 
	 date = "0000-00-00";
	var arr;
	
     activeUser = $(this).children().text();
	   $('#activeU').text(activeUser);
     //alert(activeUser);
	console.log("OnClick");
   
 
});	  
 
	
 

 
$(document).ready(function() {
	
  askServer();
  //alert("Witaj, użytkowniku ");
  
});

});