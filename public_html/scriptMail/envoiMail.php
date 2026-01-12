<?php 

if(!isset($_SESSION)){
    session_start();
}
ini_set('session.cookie_httponly', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once './../../vendor/autoload.php';

$mail = new PHPMailer(true);
$erreur ="";

function envoyerMail($mail, $destinataire, $sujet, $message){
        try {
            $mail->isSMTP();
            $mail->Host = 'partage.univ-pau.fr';
            $mail->SMTPAuth = true;
            $mail->Username =  getenv('SMTP_USER');
            $mail->Password =  getenv('SMTP_PASS');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('mducrot001@univ-pau.fr', 'AdminFablab');
            $mail->addAddress($destinataire, "etudiant");

            $mail->isHTML(true);
            $mail->Subject = $sujet;
            $mail->Body = $message;
            $mail->AltBody = $message;
            
            $mail->send();
        } catch (Exception $e) {
            echo "Le message n'a pas pu être envoye. Erreur : {$mail->ErrorInfo}";
        }
}

$destinataire = $mailUtilisateur;
//Les valeurs seront a change en discussion avec manon
if (isset($_SESSION["isAdmin"])){
    if ($raisonMail == "Accepter"){
        $subject = "Validation de votre reservation";
        $message = "Votre reservation a ete valide";
        envoyerMail($mail, $destinataire, $subject, $message);
    }else if ($raisonMail == "Refuser"){
        //cas refuser
        $subject = "Refus de votre reservation";
        $message = "Votre reservation a ete refuse";
        envoyerMail($mail, $destinataire, $subject, $message);
    }else {
        $erreur = "false";
    }
}

if ($raisonMail == "Reserver"){
    //Mail vers utilisateur
    $subject = "Demande de reservation";
    $message = "Votre reservation a bien ete prise en compte";
    envoyerMail($mail, $destinataire, $subject, $message);

    //Mail vers admin

    $destinataire = getenv('SMTP_USER');
    $subject = "Demande de reservation";
    $message = "Vous avez une nouvelle reservation";
    envoyerMail($mail, $destinataire, $subject, $message);
    $erreur = "";
}

if ($erreur != ""){
    header("Location: ./../index.php");
}

