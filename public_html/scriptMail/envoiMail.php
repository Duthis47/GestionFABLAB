<?php 

if(!isset($_SESSION)){
    session_start();
}

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
            $mail->addAddress($destinataire, "étudiant");

            $mail->isHTML(true);
            $mail->Subject = $sujet;
            $mail->Body = $message;
            $mail->AltBody = $message;
            
            $mail->send();
        } catch (Exception $e) {
            echo "Le message n'a pas pu être envoyé. Erreur : {$mail->ErrorInfo}";
        }
}

$destinataire = $mailUtilisateur;
//Les valeurs seront a changé en discussion avec manon
if (isset($_SESSION["isAdmin"])){
    if ($raisonMail == "Accepter"){
        $subject = "Validation de votre réservation";
        $message = "Votre réservation a été validé";
        envoyerMail($mail, $destinataire, $subject, $message);
    }else if ($raisonMail == "Refuser"){
        //cas refuser
        $subject = "Refus de votre réservation";
        $message = "Votre réservation a été refusé";
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

    //$destinataire = "mail admin";
    $subject = "Demande de reservation";
    $message = "Vous avez une nouvelle reservation";
    envoyerMail($mail, $destinataire, $subject, $message);
    $erreur = "";
}

if ($erreur != ""){
    header("Location: ./../index.php");
}

