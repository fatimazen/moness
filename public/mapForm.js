let map, marqueur;

// On attend que le DOM soit chargé
window.onload = () => {
    // Nous initialisons la carte et nous la centrons sur Paris
    map = L.map('detailsMap').setView([48.852969, 2.349903], 11);
    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
        attribution: 'données © <a href="//openstreetmap.org">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
        minZoom: 1,
        maxZoom: 20
    }).addTo(map);

    map.on("click", mapClickListen);
    // evenement blur est le champs a etait quitté  apres avoir était modifier
    document.querySelector("#ville").addEventListener("blur", getCity)
};
/**
 * Cette fonction se éclenche au clic, crée un marqueur et remplit les champs latitude 
 * @param {event} e 
 */

function mapClickListen(e) {
    // console.log(e);
    // On récupère les coordonnées du clic
    let pos = e.latlng;
    // On crée un marqueur
    addMarker(pos);

    // On affiche les coordonnées dans le formulaire
    document.querySelector("#lat").value = pos.lat;
    document.querySelector("#lon").value = pos.lng;
}
/**
 * 
 * @param {*} pos 
 */
function addMarker(pos) {
    // On vérifie si un marqueur existe
    if (marqueur !== undefined) {
        map.removeLayer(marqueur);
    }
    marqueur = L.marker(pos, {
        // On rend le marqueur déplaçable
        draggable: true
    });
    // On écoute le glisser-déposer sur le marqueur
    marqueur.on("dragend", function (e) {
        pos = e.target.getLatLng();
        document.querySelector("#lat").value = pos.lat;
        document.querySelector("#lon").value = pos.lng;
    });

    marqueur.addTo(map);
}

function getCity() {
    // On "fabrique" l'adresse complète
    let adresse = document.querySelector('#adresse').value + ", " + document.querySelector('#cp').value + " " + document.querySelector("#ville").value;
    console.log(adresse);
    // On initialise la requête Ajax
    const xmlhttp = new XMLHttpRequest

    // On détecte les changements d'état de la requête
    xmlhttp.onreadystatechange = () => {
        // Si la requête est terminée
        if (xmlhttp.readyState == 4) {
            // Si nous avons une réponse
            if (xmlhttp.status == 200) {
                // On récupère la réponse
                let response = JSON.parse(xmlhttp.response)
                console.log(response);
                // On récupère la latitude et la longitude
                    let lat = response[0]['lat']
                    let lon = response[0]['lon']

                    // On écrit les valeurs dans le formulaire
                    document.querySelector("#lat").value = lat;
                    document.querySelector("#lon").value = lon;

                    // On crée le marqueur
                    pos = [lat, lon];
                    addMarker(pos);

                    // On centre la carte sur l'adresse
                    map.setView(pos, 11);
            }
        }
    }

    // On ouvre la requête
    xmlhttp.open('get', `https://nominatim.openstreetmap.org/search?q=${adresse}&countrycodes=fr&format=json&addressdetails=1&limit=1&polygon_svg=1`)

    // On envoie la requête
    xmlhttp.send();


}
