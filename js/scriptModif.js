var btnModif = document.getElementById('btnModif');
var overlayModif;
var btnCloseX;

btnModif.addEventListener('click',openModif);


function openModif(ID) {
	overlayModif = document.getElementById('overlayModif_'+ID);
	overlayModif.style.display = 'block';
	btnCloseX = document.getElementById('btnCloseX_'+ID);
	btnCloseX.addEventListener('click', closePopupModif);
	btnCloseX.ID = ID;
}


function closePopupModif() {
	overlayModif = document.getElementById('overlayModif_'+this.ID);
	overlayModif.style.display = 'none';
}



