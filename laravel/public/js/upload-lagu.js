const btnUploadLagu = document.getElementById("btn-upload-lagu");
const popupUploadLagu = document.getElementById("popup-upload-lagu");
const btnClosePopup = document.getElementById("btn-close-popup");

btnUploadLagu.addEventListener("click", function () {
    popupUploadLagu.style.display = "block";
});

btnClosePopup.addEventListener("click", function () {
    popupUploadLagu.style.display = "none";
});

window.addEventListener("click", function (event) {
    if (event.target == popupUploadLagu) {
        popupUploadLagu.style.display = "none";
    }
});
