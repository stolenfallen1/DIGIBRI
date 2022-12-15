window.addEventListener('DOMContentLoaded', event => {

	var datatablesSimple = document.getElementById('datatablesSimple');

	if(datatablesSimple)
	{
		new simpleDatatables.DataTable(datatablesSimple);
	}

});