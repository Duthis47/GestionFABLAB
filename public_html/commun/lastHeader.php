
/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

<header class="header">
    <div class="logo-container">
        <img  
            class="logo-image"  
            alt="Logo fablab"  
            src="/GestionFABLAB/public_html/image/logo-fablab.png"
        />
        <div class="logo-subtitle">Milieux Aquatiques</div>
    </div>

    <nav class="nav-link"><a href ="/GestionFABLAB/public_html/index.php" >Accueil</a></nav>

    <a href="/GestionFABLAB/public_html/reservation/reservationUser.php">
        <div class="btn-reservation">
            <span>Réservation</span>
        </div>
    </a>
    <?php 
        session_start();
        if (!isset($_SESSION["isAdmin"])){

    ?>
            <a href="/GestionFABLAB/public_html/formConnexAdmin.php" class="admin-link">Administrateur</a>
    <?php 
        }else {
            if ($_SESSION["isAdmin"]){
    ?>
                <a href="#" class="admin-link">Infos</a>
                <a href="#" class="admin-link">Validation</a>
                <a href="./../admin/adminGestion.php" class="admin-link">Gestion</a>
    <?php 
            }
        }
    ?>

</header>