
let distance;
let carte;
let recherche;
/*---------------------------------
----------------------------------
        ON INTERGRE LA CARTE
------------------------------------
------------------------------/** */
carte = L.map('Carte', {
  zoomControl: false
});
/*---------------------------------
----------------------------------
      ON INITIALISE LA CARTE
------------------------------------
------------------------------/** */

var carteTiples = L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
  maxZoom: 6,
  minZoom: 5,
  attribution: 'données © <a href="//openstreetmap.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
});

carteTiples.addTo(carte);
carte.setView([46.603354, 1.888334], 8
  );
new L.Control.Zoom({
  position: "topright"
}).addTo(carte);
/*---------------------------------
----------------------------------
        ON INTERGRE LES MARKER
------------------------------------
------------------------------/** */

var singleMaker = L.marker([46.603354, 1.888334]);
var popup = singleMaker.bindPopup('this is ').openPopup()

popup.addTo(carte);

/*---------------------------------
----------------------------------
        ON INTERGRE LA SLIDMENU
------------------------------------
------------------------------/** */

const slideMenu = L.control.slideMenu('<div id="searchBar"><input type="text" id="search-input" placeholder="Recherche..."><button id="search-button">Rechercher</button></div>');
slideMenu.addTo(carte);

/*---------------------------------
----------------------------------
        ON INTERGRE LA CARTE
------------------------------------
------------------------------/** */
// Ajoutez une variable pour stocker la référence à la barre de recherche
const searchBar = document.getElementById('searchbar');

// Récupère les éléments de la barre de recherche
const searchButton =document.getElementById('search-button');
const searchInput = document.getElementById('search-input');
const ess = searchInput.value;

// Ajoute un gestionnaire d'événement lorsqu'on clique sur le bouton de recherche
searchButton.addEventListener('click', function() {
  // Effectue la requête AJAX en utilisant Symfony
  fetch(`https://nominatim.openstreetmap.org/search?q=${searchInput.value}&format=json&addressdetails=[0|1]&number=1polygon_svg=1`)
    .then(response => response.json())
    .then(ess => {
      console.log(ess);
    })
    // .catch(error => {
    //   // Gérez les erreurs éventuelles
    //   console.error(error);
    // });

});

/**
 * Cette fonction effectue un appel Ajax vers une url et retourne une promesse
 * @param {string} url 
 */

function ajaxGet(url) {
  return new Promise(function(resolve, reject) {
    // Nous allons gérer la promesse
    let xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
      // Si le traitement est terminé
      if (xmlhttp.readyState == 4) {
        // Si le traitement est un succès
        if (xmlhttp.status == 200) {nameSturcture
          try {
            // Parse la réponse JSON
            const response = JSON.parse(xmlhttp.responseText);
            // On résoud la promesse et on renvoie la réponse
            resolve(response);
          } catch (error) {
            // En cas d'erreur de parsing JSON, on rejette la promesse avec l'erreur
            reject(error);
          }
        } else {
          // On résoud la promesse et on envoie l'erreur
          reject(xmlhttp);
        }
      }
    };

    // Si une erreur est survenue
    xmlhttp.onerror = function(error) {
      // On résoud la promesse et on envoie l'erreur
      reject(error);
    };

    // On ouvre la requête
    xmlhttp.open('GET', url, true);

    // On ajoute un en-tête pour spécifier que nous attendons une réponse JSON
    xmlhttp.setRequestHeader('Accept', 'application/json');

    // On envoie la requête
    xmlhttp.send(null);
  });
}







  // let champDistance = $('#champ-distance');
  //  let valeurDistance = $('#valeur-distance');

  // champVille.on('change', function () {
  //   $.ajax({
  //     url: `https://nominatim.openstreetmap.org/search?q=${this.value}&format=geojson&addressdetails=1&limit=1&polygon_svg=1`,
  //     method: 'GET',
  //     success: function (response) {
  //       console.log();
  //       let data = response;
  //       ville = [data[1].latitude, data[1].longitude];
  //       carte.panTo(ville);
  //     }
  //   });
  // });

  // champDistance.on('change', function () {
  //   distance = this.value;
  //   valeurDistance.text(distance + ' km');

  //   if (ville != '') {
  //     $.ajax({
  //       url: `http://127.0.0.1:8000/controllerMap.php?latitude=${ville[0]}&longitude=${ville[1]}&distance=${distance}`,
  //       method: 'GET',
  //       success: function (response) {
  //         console.log(response);
  //         carte.eachLayer(function (layer) {
  //           if (layer.options.name != 'tiles') {
  //             carte.removeLayer(layer);
  //           }
  //         });

  //         let circle = L.circle(ville, {
  //           color: '#4471C4',
  //           fillColor: '#4471C4',
  //           fillOpacity: 0.3,
  //           radius: distance * 1000
  //         }).addTo(carte);

  //         let donnees = response;
  //         Object.entries(donnees).forEach(ess => {
  //           let marker = L.marker([ess[1].latitude, ess[1].longitude]).addTo(carte);
  //           marker.bindPopup(ess[1].nom);
  //         });

  //         bounds = circle.getBounds();
  //         carte.fitBounds(bounds);
  //       }



