/**
 * Created by Chris
 */
window.onload = function () {

    var tabImg = document.querySelectorAll("ul li img");

    for (var i = 0; i < tabImg.length; i++) {

        tabImg[i].setAttribute("onclick", "diapo(event)");
    }
}

function diapo(photo) {

    var img = photo.currentTarget;
    var src = img.getAttribute("src");
    var relativePath=src.substr(42,src.length-42);

    GpAnnuaire_Ajax.ajaxImage(relativePath);

    document.querySelector("#receptacle img").setAttribute("src", src);
}
