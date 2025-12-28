async function recupSalle(id){
    try {
        const reponse = await fetch('./../api/recupSalles.php?id=' + id)
         if (!reponse.ok) {
            throw new Error('Erreur réseau : ' + reponse.statusText);
        }
        const reponseJson = await reponse.json();
        return reponseJson;
    }catch (error){
        console.error('Erreur lors de la récupération des données :', error);
    }
}

async function recupMateriel(id){
    try {
        const reponse = await fetch('./../api/recupMateriel.php?id='+id)
         if (!reponse.ok) {
            throw new Error('Erreur réseau : ' + reponse.statusText);
        }
        const reponseJson = await reponse.json();
        return reponseJson;
    }catch (error){
        console.error('Erreur lors de la récupération des données :', error);
    }
}