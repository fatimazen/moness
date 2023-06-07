
// variables globales
let ville = distance = ""
let carte ;
window.onload=() =>{
  
     carte = L.map('Carte').setView([48.852969, 2.349903], 13);  
    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
        attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
        minZoom: 6,
        maxZoom: 16,
        // permettra de ne pas supprimer cette couche
        name:'titles'
        
    }).addTo(carte)
    // on récupère les champs de la page 
    
    let champVille = document.getElementById('champ-ville');
    let champDistance = document.getElementById('champ-distance');
    let valeurDistance = document.getElementById('valeur-distance');
    
    champVille.addEventListener("change", function(){
    // On envoie la requête ajax vers nominatim et on traite la réponse
    ajaxGet(`https://nominatim.openstreetmap.org/search?q=${this.value}&format=json&addressdetails=1&limit=1&polygon_svg=1`)
    .then(reponse => {
        // On convertit la réponse en objet Javascript
        let data = JSON.parse(reponse)

        // On stocke la latitude et la longitude dans la variable ville
        ville = [data[0].lat, data[0].lon]

        // On centre la carte sur la ville
        carte.panTo(ville)
    })
})
    // on ecoute évenemen sur le champ-ville
    champDistance.addEventListener('change', function(){
        // on recupère la distance choisie 
        distance = this.value 
        
        // on écrit la valeur sur la page 
        valeurDistance.innerText = distance + " km"
    })   
}

/**
 * Cette fonction effectue un appel Ajax vers une url et retourne une promesse
 * @param {string} url 
 */
function ajaxGet(url){
    return new Promise(function(resolve, reject){
        // Nous allons gérer la promesse
        let xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function(){
            // Si le traitement est terminé
            if(xmlhttp.readyState == 4){
                // Si le traitement est un succès
                if(xmlhttp.status == 200){
                    // On résoud la promesse et on renvoie la réponse
                    resolve(xmlhttp.responseText);
                }else{
                    // On résoud la promesse et on envoie l'erreur
                    reject(xmlhttp);
                }
            }
        }

        // Si une erreur est survenue
        xmlhttp.onerror = function(error){
            // On résoud la promesse et on envoie l'erreur
            reject(error);
        }

        // On ouvre la requête
        xmlhttp.open('GET', url, true);

        // On envoie la requête
        xmlhttp.send(null);
    })
}