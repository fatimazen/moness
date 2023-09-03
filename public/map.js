
let distance;
let carte;
let recherche;
var markerClusters = L.markerClusterGroup();
// var iconBase = "image/marker.png";
var markers = [];
var essData = { latitude: 0, longitude: 0, nameStructure: "" };


carte = L.map("Carte", {
  zoomControl: false,
});

for (let index = 0; index < companies.length; index++) {
  //  on utilise la propriété display_name du premier résultat de la recherche (bldgData[0]) pour afficher le nom complet de la ville dans le popup.
  //  on affiche l icones de la variable essData
  var marker = L.marker([companies[index].latitude, companies[index].longitude]).addTo(carte);
  marker.bindPopup(`
    <h3>${companies[index].name}</h3>
    <p>${companies[index].adress}</p>
    <p>${companies[index].description}</p>
  `);
}

var carteTiles = L.tileLayer(
  "https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png",
  {
    attribution:
      'données © <a href="//openstreetmap.org">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
    minZoom: 1,
    maxZoom: 20,
    name: "tiles",

  }
);

carteTiles.addTo(carte);
carte.setView([46.603354, 1.888334], 6);
new L.Control.Zoom({
  position: "topright",
}).addTo(carte);
var marker = L.marker([46.603354, 1.888334]).addTo(carte);



const slideMenu = L.control.slideMenu(
  '<div id="searchBar"><input type="text" id="search-input" placeholder="Recherche..."><button id="search-button">Rechercher</button><p><label for="champ-distance">Distance : </label><input type="range" min="1" max="200" id="champ-distance"></p><p id="valeur-distance"></p></div><p id="ess"></p>'
);
slideMenu.addTo(carte);

const searchButton = document.getElementById("search-button");
const searchInput = document.getElementById("search-input");
const champDistance = document.getElementById("champ-distance");
const valeurDistance = document.getElementById("valeur-distance");
// let regionFiltre = document.getElementById('region-filter').value;
// let sectorActivity = document.getElementById('activity-filter').value;

searchButton.addEventListener("click", function () {
  var ess = searchInput.value;
  valeurDistance.textContent = 1 + "Km";
  champDistance.value = 1;

  // On envoie la requête ajax vers nominatim et on traite la réponse
  fetch(
    `https://nominatim.openstreetmap.org/search?q=${searchInput.value}&format=json&addressdetails=[0|1]&countrycodes=fr&limit=1&polygon_svg=1`)
    .then((reponse) => reponse.json())
    .then((bldgData) => {
      console.log("bldgdata", bldgData);
      // on efface les markers 
      eraseMarkers();
      // On stocke la latitude et la longitude dans les variables  
      let latitude = bldgData[0].lat;
      let longitude = bldgData[0].lon;
      essData.latitude = latitude;
      essData.longitude = longitude;
      essData.nameStructure = ess;
      // On centre la carte sur la ville
      carte.panTo([essData.latitude, essData.longitude]);

      //  on affiche l icones de la variable essData
      var marker = L.marker([essData.latitude, essData.longitude]).addTo(carte);
      //  on utilise la propriété display_name du premier résultat de la recherche (bldgData[0]) pour afficher le nom complet de la ville dans le popup.
      marker.bindPopup(bldgData[0].display_name);

    })
    .catch((error) => {
      console.error(error);
    });
});
// Définition de la fonction handleMarkerClick en dehors de la boucle forEach
function handleMarkerClick(event) {
  const marker = event.target;


  // Récupérez les informations de l'entreprise à partir du marqueur
  const ess = marker.ess;

  // Affichez les informations dans un conteneur d'informations spécifié dans votre page HTML
  const container = document.getElementById("ess-info");
  container.innerHTML = `
    <h3>${ess.nom}</h3>
    <p>${ess.adresse}</p>
    <p>${ess.telephone}</p>
  `;
  console.log(container);
}
function eraseMarkers() {
  carte.eachLayer(function (layer) {
    if (layer.options.name != "tiles") carte.removeLayer(layer);
  });

}

champDistance.addEventListener("click", function () {
  // On récupère la distance choisie
  distance = champDistance.value;
  valeurDistance.textContent = distance + "Km";

  // On vérifie si une ville a été saisie
  if (essData.latitude !== 0 && essData.longitude !== 0) {

    fetch(
      `http://127.0.0.1:8000/getEssData?latitude=${essData.latitude}&longitude=${essData.longitude}&distance=${distance}`)

      .then((response) => response.json())
      .then((bldgData) => {
        console.log("response", bldgData);
        // console.log("ess", essData);

        eraseMarkers();

        // On trace le cercle de rayon "distance"
        let circle = L.circle([essData.latitude, essData.longitude], {
          color: '#4471C4',
          fillColor: '#4471C4',
          fillOpacity: 0.3,
          radius: distance * 1000,
        }).addTo(carte);

        // On boucle sur les données 
        (bldgData).forEach(Element => {
          // console.log("maker", Element[1]);
          var marker = L.marker([Element.latitude, Element.longitude])

          // Associez les informations de l'entreprise au marqueur
          marker.ess = {
            nom: Element.nameStructure,
            adresse: Element.adress,
            description: Element.description,
            // email: Element.email,
            // telephone: Element.telephone,
          };
          // Ajoutez l'événement de clic au marqueur
          marker.on("click", handleMarkerClick);
          // Afficher les informations de l'entreprise dans une carte ou une boîte de dialogue
          marker.bindPopup(`
              <h3>${Element.nameStructure}</h3>
              <p>${Element.adresse}</p>
              <p>${Element.description}</p>
          
              `);

          // Nous ajoutons le marqueur aux groupes
          markerClusters.addLayer(marker);
          // Nous ajoutons le marqueur à la liste des marqueurs
          markers.push(marker);
          // console.log(marker);
        })
        var group = new L.featureGroup(markers); // Nous créons le groupe des marqueurs pour adapter le zoom
        carte.fitBounds(group.getBounds().pad(0.5)); // Nous demandons à ce que tous les marqueurs soient visibles, et ajoutons un padding (pad(0.5)) pour que les marqueurs ne soient pas coupés
        carte.addLayer(markerClusters);
        // On centre et on zoome sur le cercle
        bounds = circle.getBounds();
        carte.fitBounds(bounds);

      })
      .catch((error) => {
        console.error(error);
      });
  }
});

function ajaxGet(url) {
  return new Promise(function (resolve, reject) {
    let xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
      if (xmlhttp.readyState == 4) {
        if (xmlhttp.status == 200) {
          try {
            const response = JSON.parse(xmlhttp.responseText);
            resolve(response);
          } catch (error) {
            reject(error);
          }
        } else {
          reject(xmlhttp);
        }
      }
    };

    xmlhttp.onerror = function (error) {
      reject(error);
    };

    xmlhttp.open("GET", url, true);
    xmlhttp.send();
  });
}
