<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portail Administrateur - FabLab</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="./CSS/style.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Anonymous+Pro:wght@400&family=Roboto+Condensed:wght@400;500;600&family=Inter:wght@500&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <header class="header">
      <div class="logo-container">
        <img 
          class="logo-image" 
          alt="Logo fablab" 
          src="./image/logo-fablab.png"
        />
        <div class="logo-subtitle">Milieux Aquatiques</div>
      </div>

        <nav class="nav-link"><a href ="/GestionFABLAB/public_html/index.php" >Accueil</a></nav>

      <div class="btn-reservation">
        <span>Réservation</span>
      </div>

      <a href="/GestionFABLAB/public_html/formConnexAdmin.php" class="admin-link">Administrateur</a>
    </header>

    <main class="main-content">
      <h1 class="title">Portail Administrateur</h1>

      <form class="login-form" action="./scriptsConnexions/connexionAdmin.php" method="POST">
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

        <button type="submit" class="btn-submit">
          <span>Connexion</span>
        </button>
      </form>
    </main>
  </div>
</body>
</html>
