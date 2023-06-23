let distance;
let carte;
let recherche;
var markerClusters = L.markerClusterGroup();
var iconBase = "image/marker.png";
var markers = [];
essData = distance = "";


carte = L.map("Carte", {
  zoomControl: false,
});

var carteTiles = L.tileLayer(
  "https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png",
  {
    attribution:
      'données © <a href="//openstreetmap.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
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
var icone = L.icon({
  iconUrl: iconBase,
  iconSize: [50, 50],
  iconAnchor: [25, 50],
  popupAnchor: [0, 50],
});

const slideMenu = L.control.slideMenu(
  '<div id="searchBar"><input type="text" id="search-input" placeholder="Recherche..."><button id="search-button">Rechercher</button><p><label for="champ-distance">Distance : </label><input type="range" min="1" max="200" id="champ-distance"></p><p id="valeur-distance"></p></div><p id="ess"></p>'
);
slideMenu.addTo(carte);

const searchButton = document.getElementById("search-button");
const searchInput = document.getElementById("search-input");
const champDistance = document.getElementById("champ-distance");
const valeurDistance = document.getElementById("valeur-distance");

searchButton.addEventListener("click", function () {
  const ess = searchInput.value;

  fetch(
    `https://nominatim.openstreetmap.org/search?q=${searchInput.value}&format=json&addressdetails=[0|1]&number=1polygon_svg=1`
  )
    .then((reponse) => reponse.json())
    .then((bldgData) => {
      console.log("bldgdata", bldgData);
      console.log("essdata", essData);
      console.log("bldgdata1", bldgData[0].lat);
      let latitude = bldgData[0].lat;
      let longitude = bldgData[0].lon;
      essData = [latitude, longitude];
      carte.panTo(essData);
    })
    .catch((error) => {
      console.error(error);
    });
});

champDistance.addEventListener("input", function () {
  distance = champDistance.value;
  valeurDistance.textContent = distance;
});
console.log("rare", distance);
champDistance.addEventListener("change", function () {
  fetch(
    `http://127.0.0.1:8000/getEssData?latitude=${essData[0]}&longitude=${essData[1]}&distance=${distance}`
  )
    .then((response) => response.json())
    .then((bldgData) => {
      console.log(bldgData);
      carte.eachLayer(function (layer) {
        if (layer.options.name != "tiles") carte.removeLayer(layer);
      });
      // console.log("tiles",layer.options.name);
      // On trace le cercle de rayon "distance"
      let circle = L.circle(essData, {
        color: '#4471C4',
        fillColor: '#4471C4',
        fillOpacity: 0.3,
        radius: distance * 1000,
      }).addTo(carte);
      // On centre et on zoome sur le cercle
      bounds = circle.getBounds();
      carte.fitBounds(bounds);


      // On convertit la réponse en objet Javascript
      let donnees = JSON.parse(bldgData)
      console.log("donner", donnees);

      Object.entries(donnees.essData).forEach(([essKey, essData]) => {
        let marker = L.marker([essData.lat, essData.lon], {
          icon: icone,
        }).addTo(carte);
        markerClusters.addLayer(marker);
      });


    })
    .catch((error) => {
      console.error(error);
    });
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