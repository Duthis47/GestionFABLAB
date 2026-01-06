<?php 

if(!isset($_SESSION)){
    session_start();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once './../vendor/autoload.php';

$mail = new PHPMailer(true);
$erreur ="";

function envoyerMail($mail, $destinataire, $sujet, $message){
        try {
            echo "ouep";
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'educaps64@gmail.com';
            $mail->Password = 'pnwx artl rvsk mlof';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('educaps64@gmail.com', 'AdminFablab');
            $mail->addAddress($destinataire, "étudiant");

            $mail->isHTML(true);
            $mail->Subject = $sujet;
            $mail->Body = $message;
            $mail->AltBody = $message;
            
            $mail->send();
            echo "Le message est bien envoyé cliqué sur le lien ci-dessous pour revenir sur le site";
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

