var btnSupp = document.getElementById('btnSupp');
var overlaySupp;
var btnAnnuler;

btnSupp.addEventListener('click',openSupp);


function openSupp(ID) {
	overlaySupp = document.getElementById('overlaySupp_'+ID);
	overlaySupp.style.display = 'block';
	btnAnnuler = document.getElementById('btnAnnuler_'+ID);
	btnAnnuler.addEventListener('click', closePopupSupp);
	btnAnnuler.ID = ID;
}


function closePopupSupp() {
	overlaySupp = document.getElementById('overlaySupp_'+this.ID);
	overlaySupp.style.display = 'none';
}



