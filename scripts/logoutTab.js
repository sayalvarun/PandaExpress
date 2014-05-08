var openedTab = false;
var pages = ["Search Flights", "View Profile", "Customize Profile"];
var currPage = "index";
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
function changePage(page, index)
{
	document.getElementById(currPage).style.display="none";
	document.getElementById(page).style.display="inline-block";
	currPage = page;
	document.getElementById("companyName").innerHTML=pages[index];
	/*clickedUsername();*/
}
function resetPage(user)
{
	document.getElementById('loginButton').style.display='none';
	document.getElementById('userDropdown').style.display='inline';
	document.getElementById('cUser').value=user;
	document.getElementById('user').innerHTML=user;
}