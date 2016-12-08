
window.onload = function () {
    // Une variable pour contenir notre future marker
    var myMarker = null;

    // Des coordonnées de départ
    var myLatlng = new google.maps.LatLng(50.8504500, 4.3487800);//Coord. de Bruxelles

    // Les options de notre carte
    var myOptions = {
        zoom: 15,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    // On créé la carte
    var myMap = new google.maps.Map(
        document.getElementById('carte'),
        myOptions
    );
    //var nomPrestataire = document.getElementById('nomPrestataire').textContent;
    var numero = document.getElementById('numero').textContent;
    var rue = document.getElementById('rue').textContent;
    var cp = document.getElementById('cp').textContent;
    var commune = document.getElementById('commune').textContent;

    // L'adresse que nous allons rechercher
    var GeocoderOptions = {
        'address': numero + " , " + rue + " " + cp + " " + commune,
        'region': 'BE'
    }

    // Notre fonction qui traitera le resultat
    function GeocodingResult(results, status) {
        // Si la recher à fonctionné
        if (status == google.maps.GeocoderStatus.OK) {

            // S'il existait déjà un marker sur la map,
            // on l'enlève
            if (myMarker != null) {
                myMarker.setMap(null);
            }

            // On créé donc un nouveau marker sur l'adresse géocodée
            myMarker = new google.maps.Marker({
                position: results[0].geometry.location,
                map: myMap,
                title: nomPrestataire
            });

            // Et on centre la vue sur ce marker
            myMap.setCenter(results[0].geometry.location);

        } // Fin si status OK

    } // Fin de la fonction

    // Nous pouvons maintenant lancer la recherche de l'adresse
    var myGeocoder = new google.maps.Geocoder();
    myGeocoder.geocode(GeocoderOptions, GeocodingResult);
}


