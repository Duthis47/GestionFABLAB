<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portail Administrateur - FabLab</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Poppins:wght@300;400;500;600&display=swap">
        <link rel="stylesheet" href="./stylesConnex.css">

</head>

<body>
    <?php 
        if (isset($_SESSION["isAdmin"])){
            header("Location: /GestionFABLAB/public_html/admin/adminInfos.php");
        }
        if (isset($_GET["connex"]) && $_GET["connex"] == "echec"){
          echo $_GET["connex"];
            $echec = 'true';
        }else {
            $echec = 'false';
        };
    ?>
        <?php
        require_once './../commun/header.php';
    ?>

    <div class="container" style="max-width:800px">
        <div class="form-box">
            <h2>LOGIN</h2>
            <p>Welcome back</p>

            <form action="/GestionFABLAB/public_html/scriptsConnexions/connexionAdmin.php" method="POST">
                <div class="input-group">
                    <input type="text" name = "username" id="username" required class="input-field">
                    <label for="username">Username</label>
                    <div class="glow-line"></div>
                </div>

                <div class="input-group">
                    <input type="password" name="password" id="password" required class="input-field">
                    <label for="password">Password</label>
                    <div class="glow-line"></div>
                </div>

                <div class="remember-forgot">
                </div>

                <button type="submit" class="login-btn">
                    <span>SIGN IN</span>
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
    <!-- On affiche la div seulement si c'est un échec -->

</body>

</html>