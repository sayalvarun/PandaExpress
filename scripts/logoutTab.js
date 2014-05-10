function resetPage(user)
{
	document.getElementById('loginButton').style.display='none';
	document.getElementById('userDropdown').style.display='inline';
	document.getElementById('user').innerHTML=user;
}