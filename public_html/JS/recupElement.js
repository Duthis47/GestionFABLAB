

function recupSalle(type, idSalle, capaSalle) {
    fetch('./../api/recupSalles.php?id=' + idSalle+'&type='+type)
        .then(response => {
            // Au lieu de response.json(), on prend le texte brut
            return response.text();
        })
        .then(text => {

            // On essaie de convertir manuellement pour voir si ça tient
            try {
                const data = JSON.parse(text);
                // Si ça marche, on continue
                let listeResa = data;
                if (type === 'etudiant'){
                    document.getElementById("nbOccupant").setAttribute("max", capaSalle);
                }
                
                afficherCalendrierSalle(type, listeResa, capaSalle);                
                return listeResa;
            } catch (e) {
                console.error(e.message);
            }
        });
}
function recupMateriels(type, idMateriel, nbExemplaireTotal) {
    fetch('./../api/recupMateriels.php?id=' + idMateriel +'&type='+type)
        .then(response => {
            // Au lieu de response.json(), on prend le texte brut
            return response.text();
        })
        .then(text => {

            // On essaie de convertir manuellement pour voir si ça tient
            try {
                const data = JSON.parse(text);
                // Si ça marche, on continue
                let listeResa = data;
                afficherCalendrierMateriel(type, listeResa, nbExemplaireTotal);
            } catch (e) {
                console.error("Ce n'est pas du JSON valide !");
            }
        });
}
