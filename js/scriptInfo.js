var btnInfo = document.getElementById('element');
var overlayInfo;
var btnCloseInfo;

btnInfo.addEventListener('click',openInfo);


function openInfo(ID) {
	overlayInfo = document.getElementById('overlayInfo_'+ID);
	overlayInfo.style.display = 'block';
	btnCloseInfo = document.getElementById('btnCloseInfo_'+ID);
	btnCloseInfo.addEventListener('click', closePopupInfo);
	btnCloseInfo.ID = ID;
}


function closePopupInfo() {
	overlayInfo = document.getElementById('overlayInfo_'+this.ID);
	overlayInfo.style.display = 'none';
}