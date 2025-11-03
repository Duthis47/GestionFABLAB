<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portail Administrateur - FabLab</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="/GestionFABLAB/public_html/CSS/style.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Anonymous+Pro:wght@400&family=Roboto+Condensed:wght@400;500;600&family=Inter:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <?php 
        if (isset($_SESSION["isAdmin"])){
            header("Location: /GestionFABLAB/public_html/admin/adminInfos.php");
        }
        $echec = isset($_GET["connex"]) && $_GET["connex"] == "echec";
    ?>
  <div class="container">
    <?php
        require_once './commun/header.php';
    ?>

    <main class="main-content">
      <h1 class="title">Portail Administrateur</h1>

      <form class="login-form" action="/GestionFABLAB/public_html/scriptsConnexions/connexionAdmin.php" method="POST">
        <div class="input-wrapper">
          <label for="username" class="sr-only">Utilisateur</label>
          <input
            type="text"
            id="username"
            name="username"
            placeholder="Utilisateur"
            class="input-field"
            required
          />
        </div>
          
        <div class="input-wrapper">
          <label for="password" class="sr-only">Mot de passe</label>
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Mot de passe"
            class="input-field"
            required
          />
        </div>
          <?php 
            if ($echec){
          ?>
        <div class="erreurAdmin"> 
              Nom d'utilisateur ou mot de passe incorrect
        </div>
               <?php } ?> 
        <button type="submit" class="btn-submit">
          <span>Connexion</span>
        </button>
      </form>
    </main>
  </div>
</body>
</html>
