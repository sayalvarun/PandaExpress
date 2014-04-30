var openedTab = false;
function clickedUsername()
{
	if(!openedTab)
	{
		document.getElementById("tabOps").style.visibility="visible";
		document.getElementById("triangle").innerHTML="&#9650";
	}
	else
	{
		document.getElementById("tabOps").style.visibility="hidden";
		document.getElementById("triangle").innerHTML="&#9660";
	}
	openedTab = !openedTab;
}