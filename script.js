var x = 1;
function hide() {
	if(x == 1)
    { 
	document.getElementById("secondhide").style.display = "none";
	document.getElementById("firsthide").style.display = "block";
	x = x * -1;
	}
	else
	{ 
	document.getElementById("firsthide").style.display = "none";
	document.getElementById("secondhide").style.display = "block";
    x = x * -1;
	}
	
}


