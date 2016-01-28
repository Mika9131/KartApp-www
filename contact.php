<?php
session_start();
// HEADER einbinden

if(isset($_SESSION['userid']) && isset($_SESSION['username']))
{
	include("header.php");
 }
else{
	include("headernav.php");
}
$current_file_name = basename($_SERVER['REQUEST_URI'], ".php");
$dbhandler->userlog($clientip." ".$host." ".$_SESSION['userid']." ".$current_file_name);

echo "<div class=\"container\">";

if((isset($_POST['betreff'])) && (isset($_POST['email'])) && (isset($_POST['feedback']))) {

	echo "TEEEEST";
	require 'libs/PHPMailer/PHPMailerAutoload.php';

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
	$mail->addAddress('kartaapp@outlook.de', 'KartA - Kontaktformular');     // Add a recipient
	$mail->addReplyTo($_POST['email']);
	$mail->addCC($_POST['email']);
	$mail->isHTML(true);

	$mail->Subject = $_POST['betreff'];
	$mail->Body    = $_POST['feedback'];
	if(!$mail->send()) {
		echo "<br><br><br><div class=\"alert alert-danger\" role=\"alert\">Die E-Mail konnte nicht versendet werden!</div>";
	} else {
		echo "<br><br><br><div class=\"alert alert-success\" role=\"alert\">Vielen Dank f&uuml;r ihre E-Mail.</div>";
	}


}
?>

      <!-- Mainn component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Kontakt</h1>
        <p>
					Haben Sie eine Frage, die sich durch unsere Infoseiten nicht beanworten lässt?
					Möchten Sie eine Anregung, Kritik oder einen Verbesserungsvorschlag anbringen?
					Dann zögern Sie nicht, Kontakt mit uns aufzunehmen.
        </p>
				<br>

				<form method="POST" class="form-inline" action="contact.php">
  			<div class="form-group">
				<input type="text" name="email" class="form-control" id="exampleInputName2" placeholder="E-Mail Adresse" <?php if(isset($_SESSION['userid'])){echo "value=\"".$user['email']."\"";} ?>>
			</div>
		<input type="text" name="betreff" class="form-control" id="exampleInputName2" placeholder="Betreff">
				<script src="libs/ckeditor/ckeditor.js"></script>
					<br><br>
					 	<p>Feedback</p>
						 <textarea class="ckeditor" name="feedback" cols="50" rows="10"></textarea>
						 <br>
					 		<input class="btn btn-primary" type="submit" value="Senden" name="submit">
					  </form>

    </div> <!-- /container -->

	<?php

include('footer.php');
?>
