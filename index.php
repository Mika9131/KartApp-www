	<?php

// HEADER einbinden
include("headernav.php");

require 'libs/PHPMailer/PHPMailerAutoload.php';

if(isset($_POST['resetmail'])){
	$pass = $dbhandler->randomPassword();
	$resetuser = $dbhandler->getUserByEmail($_POST['resetmail']);
}

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp-mail.outlook.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'kartaapp@outlook.de';                 // SMTP username
$mail->Password = 'Totodimiol';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;
$mail->SMTPAuth = true;
//$mail->SMTPDebug = 2;                                  // TCP port to connect to

$mail->From = 'kartaapp@outlook.de';
$mail->FromName = 'KartA - Mailer';
$mail->addAddress($_POST['resetmail'], $resetuser['username']);     // Add a recipient
$mail->addReplyTo('kartaapp@outlook.de', 'KartA - Mailer');
$mail->addBCC('kartaapp@outlook.de');

$mail->isHTML(true);                                  // Set email format to HTML




?>
<div class="container">
		<?php
		if(!empty($resetuser)){
			$reset = $dbhandler->resetPassword($resetuser['userid'], $pass);

			$empfaenger = $_POST['resetmail'];
			$text = "Hallo ".$resetuser['username']."!<br />Ihr neues Passwort: ".$pass."</p><p><a href=\"http://fensalir.lin.hs-osnabrueck.de/~karta\">KartA Webseite</a></p><p>Freundliche gr&uuml;&szlig;t Sie<br />Ihr Karta-Team</p>";

			$mail->Subject = "KartA - neues Passwort";
			$mail->Body    = "Hallo ".$resetuser['username']."!<br />Ihr neues Passwort: ".$pass."</p><p><a href=\"http://fensalir.lin.hs-osnabrueck.de/~karta\">KartA Webseite</a></p><p>Freundlich gr&uuml;&szlig;t Sie<br />Ihr Karta-Team</p>";
			$mail->AltBody = "Hallo ".$resetuser['username']."! Ihr neues Passwort: ".$pass."Freundlich gr&uuml;&szlig;t Sie Ihr Karta-Team";
			if(!$mail->send()) {
				echo "<br><br><br><div class=\"alert alert-danger\" role=\"alert\">Die E-Mail konnte nicht versendet werden!</div>";
			} else {
				echo "<br><br><br><div class=\"alert alert-success\" role=\"alert\">Das neue Passwort wurde an Ihre E-Mail Adresse geschickt! Bitte prüfen Sie auch Ihren Spam-Ordner! Passwort: ".$pass."</div>";
			}
			// mail($empfaenger, $betreff, $text, "From: $absendername <$absendermail>");

		}elseif(isset($resetuser)){
			echo "<br><br><br><div class=\"alert alert-danger\" role=\"alert\">Die E-Mail Adresse ist nicht vorhanden!</div>";
		}
		?>
      <!-- Mainn component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>KartA <span class="glyphicon glyphicon-arrow-right"></span> Karteikarten App</h1>
        <h2>Einfach und geschmeidig mobile Lernen</h2>

 		<img src="images/logo.png" hspace="10" vspace="5" align="left">

        <p>Unser Karteikarten App bietet Ihnen die M&ouml;glichkeit online und mobile, &uuml;berall und wo auch immer zu lernen.</p>
        <p>Erleichtern Sie sich das Lernen und sein Sie immer zu und jeder Zeit bereit f&uuml;r Pr&uuml;fungen, Klausuren oder Test.</p>
          <a class="btn btn-lg btn-primary" href="register.php" role="button">Registrieren &raquo;</a>
        </p>
      </div>

    </div> <!-- /container -->

	<?php

include('footer.php');
?>
