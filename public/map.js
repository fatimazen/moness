let ville;
let distance;
let carte;

// $(window).on('load', function () {

carte = L.map('Carte', {
  zoomControl: false

});
var carteTiples = L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
  maxZoom: 6,
  minZoom: 5,
  attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
}
);
carteTiples.addTo(carte);
carte.setView([46.603354, 1.888334], 6);
new L.Control.Zoom({
  position: "topright"
}).addTo(carte);
// ajout slidmenu
/* contents */
const left = '<div class="header">Slide Menu (Left)</div>';
const right = '<div class="header">Slide Menu (Right)</div>';
let contents = `
<div class="content">
    <div class="title">Read Me</div>
    <p>A simple slide menu for Leaflet.<br>
    When you click the menu button and the menu is displayed to slide.<br>
    Please set the innerHTML to slide menu.</p>
    <div class="title">Usage</div>
    <p>L.control.slideMenu("&lt;p&gt;test&lt;/p&gt;").addTo(map);</p>
    <div class="title">Arguments</div>
    <p>L.control.slideMenu(&lt;String&gt;innerHTML, &lt;SlideMenu options&gt;options?)</p>
    <div class="title">Options</div>
    <p>position<br>
    menuposition<br>
    width<br>
    height<br>
    direction<br>
    changeperc<br>
    delay<br>
    icon<br>
    hidden</p>
    <div class="title">Methods</div>
    <p>setContents(&lt;String&gt;innerHTML)</p>
    <div class="bottom">
        <span>License <span style="font-weight: bold">MIT</span></span>
    </div>
</div>`;
/* left */
L.control.slideMenu(left + contents).addTo(carte);
console.log(L.control);



  // let champVille = $('#champ-ville');
  // let champDistance = $('#champ-distance');
  // let valeurDistance = $('#valeur-distance');

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
  //     });
  //   }
  // });
// });


