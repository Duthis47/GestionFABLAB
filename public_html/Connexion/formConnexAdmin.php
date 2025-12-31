<?php if (!isset($_SESSION)) { session_start(); } ?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="auto">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portail Administrateur - FabLab</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Poppins:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="./stylesConnex.css">
    <link href="./../CSS/style.css" rel="stylesheet"/>
    <script src="./../bootstrap/js/color-modes.js"></script>
    <link href="./../bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <meta name="theme-color" content="#712cf9" />
    <link href="./../bootstrap/navbar/navbar-static.css" rel="stylesheet" />
</head>

<body>
    <?php
        require_once './../commun/header.php';
    ?>
    <?php 
        if (isset($_SESSION["isAdmin"])){
            header("Location: ./../admin/adminInfos.php");
        }
        if (isset($_GET["connex"]) && $_GET["connex"] == "echec"){
            $echec = 'true';
        }else {
            $echec = 'false';
        };
    ?>
        

    <div class="container" style="max-width:800px">
        <div class="form-box">
            <h2>Connexion</h2>

            <form action="./../scriptsConnexions/connexionAdmin.php" method="POST">
                <div class="input-group">
                    <input type="text" name = "username" id="username" required class="input-field">
                    <label for="username">Identifiant</label>
                    <div class="glow-line"></div>
                </div>

                <div class="input-group">
                    <input type="password" name="password" id="password" required class="input-field">
                    <label for="password">Mot de passe</label>
                    <div class="glow-line"></div>
                </div>

                <div class="remember-forgot">
                </div>

                <button type="submit" class="login-btn">
                    <span>Se connecter</span>
                    <div class="btn-glow"></div>
                </button>

                <?php if($echec == 'true'){ ?>
                  <div class="signup-link" style="color: red;">
                      Nom d'utilisateur ou Mot de Passe incorrect
                  </div>
               <?php 
               }
               ?>
            </form>
        </div>
    </div>
</body>
</html>