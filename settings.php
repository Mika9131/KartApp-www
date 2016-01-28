	<?php

include("header.php");

$current_file_name = basename($_SERVER['REQUEST_URI'], ".php");
$dbhandler->userlog($clientip." ".$host." ".$_SESSION['userid']." ".$current_file_name);

//Werte resetten
$passwordstatus = 4;
$mailstatus = 5;
$resetallstats = 0;

//User aus der Session holen
$user = $dbhandler->getUserById($_SESSION[userid]);


	//Statistiken zurücksetzen
	if (isset($_POST['resetstats'])) {
		echo $user[userid];
		$resetallstats = $dbhandler->resetStats($user[userid]);
		echo $resetallstats;
	}


	//Passwort ändern
	if (isset($_POST['inputPassword'])){
			//Prüfung, ob Felder ausgefüllt
			if (empty($_POST['inputPassword']) == false && empty($_POST['inputNewPassword']) == false && empty($_POST['inputNewPassword2']) == false){
					//Prüfung, ob Passwort korrekt
					if ($dbhandler->checkLogin($user[username], $_POST['inputPassword']))	{
								//Prüfung, ob Passwörter Gleich
								if ($_POST['inputNewPassword'] == $_POST['inputNewPassword2']){
											//Wenn alles true: ändere die Attribute userid, email und passwort
											$new_password = $_POST['inputNewPassword'];
											$dbhandler->updateUser($user[userid], $user[email], $new_password);

											//Ergebnis für die Ausgabe
											$passwordstatus = 0;

								} else {$passwordstatus = 1;}
					} else {$passwordstatus = 2;}
			}else {$passwordstatus = 3;}
	}



//E-Mail Adresse ändern

//Prüfung, ob $_POST-Variable geschrieben
if (isset($_POST['inputNewMail'])){

	//Prüfung, ob Felder ausgefüllt
	if (empty($_POST['inputNewMail']) == false && empty($_POST['inputMailPassword']) == false && empty($_POST['inputNewMail2']) == false){

		//Prüfung, ob Passwort korrekt
		if ($dbhandler->checkLogin($user['username'],$_POST['inputMailPassword'])){

			//Bei Erfolg: $new_mail belegen
			$new_mail = $_POST['inputNewMail'];

			//Prüfung, ob E-Mail-String korrekte Syntax ist
			if (filter_var($new_mail, FILTER_VALIDATE_EMAIL)) {

				//Prüfung, ob Adressen übereinstimmen
				if ($_POST['inputNewMail'] == $_POST['inputNewMail2']){

					//Wenn alles true: ändere die Attribute userid, email und passwort
					$dbhandler->updateUser($_SESSION['userid'], $new_mail, $_POST['inputMailPassword']);
					//Ergebnis für die Ausgabe
					$mailstatus = 0;
				//
				} else {$mailstatus = 1;}
			} else {$mailstatus = 2;}
		} else {$mailstatus = 3;}
} else {$mailstatus = 4;}
}





?>

<div class="container">
<br><br><br>
<h1>
	 Accounteinstellungen
</h1>
<br>


<div class="panel panel-default">
	<div class="panel-heading">
    <h3 class="panel-title">Benutzer</h3>
  </div>
  <div class="panel-body">
	<br>
	<form class="form-horizontal" method='POST'>
  	<div class="form-group">
    	<label class="col-sm-2 control-label">Benutzername:</label>
    	<div class="col-sm-4">
      	<p class="form-control-static"> <?php echo $user ['username'] ?> </p>
    	</div>
  	</div>




<?php
				//Ausgabe für das Löschen der Benutzerstatistiken
				if ($resetallstats == 1) {
					echo '<div class="alert alert-success" role="alert">Benutzerstatistiken erfolgreich gelöscht</div>';

				}
?>

<div class="form-group">
	<label class="col-sm-2 control-label"></label>
	<div class="col-sm-10">
		<!-- hidden input für POST -->
	<input type="hidden" name="resetstats" value="true">
	<!-- Button, um alle Benutzerstqtistiken zu löschen-->
	<button type="resetstats" class="btn btn-warning" onclick="return confirm('Wirklich alle statistiken L&ouml;schen?');"><span class="glyphicon glyphicon-erase"></span>&nbsp;Komplette Benutzerstatistik l&ouml;schen</button>
	<!-- Button, um User zu löschen -->
	<button type="submit" class="btn btn-danger btn" onclick="return confirm('Account wirklich L&ouml;schen?');"><span class="glyphicon glyphicon-trash"></span>&nbsp;Account löschen</button>

	</div>
</div>
</form>
	</div>
    </div>


<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Passwort</h3>
  </div>
	<div class="panel-body">

		<form class="form-horizontal" method="POST">
  		<div class="form-group">
    		<label for="inputPassword" class="col-sm-2 control-label">altes Passwort:</label>
    		<div class="col-sm-4">
      	<input type="password" class="form-control" name="inputPassword" placeholder="altes Passwort">
    		</div>
  		</div>
	<br><br>

				<div class="form-group">
					<label for="inputPassword" class="col-sm-2 control-label">neues Passwort:</label>
						<div class="col-sm-4">
							<input type="password" class="form-control" name="inputNewPassword" placeholder="neues Passwort">
						</div>
				</div>


				<div class="form-group">
					<label for="inputPassword" class="col-sm-2 control-label">neues Passwort wiederholen:</label>
					<div class="col-sm-4">
						<input type="password" class="form-control" name="inputNewPassword2" placeholder="neues Passwort wiederholen">
					</div>
				</div>




	<?php
	//Ausgabe Passwort-Änderung
	switch ($passwordstatus) {
    case 0:

			echo '<div class="alert alert-success" role="alert">Das Passwort wurde erfolgreich geändert</div>';

			  break;
    case 1:
        echo '<div class="alert alert-danger" role="alert">Die Passwörter stimmen nicht überein</div>';
        break;
    case 2:
        echo '<div class="alert alert-danger" role="alert">Das eingegebene aktuelle Passwort ist nicht korrekt</div>';
        break;
		case 3:
				echo '<div class="alert alert-danger" role="alert">Bitte alle Felder ausfüllen</div>';
				break;
		}

	?>





	<div class="form-group">
		<label class="col-sm-2 control-label"></label>
		<div class="col-sm-10">
			<input type="submit" class="btn btn-primary btn" value="Passwort ändern" name="submitnewpassword">
		</div>
	</div>
</form>

</div>
</div>



    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">E-Mail-Adresse</h3>
      </div>
      <div class="panel-body">

				<form class="form-horizontal" method='POST'>


  <div class="form-group">
    <label class="col-sm-2 control-label">E-Mail Adresse:</label>
    <div class="col-sm-4">
      <p class="form-control-static">
				<?php
				 		echo $user ['email']
				?>
		 </p>
    </div>
  </div>



<div class="form-group">
	<label for="inputPassword" class="col-sm-2 control-label">neue E-Mail Adresse:</label>
	<div class="col-sm-4">
			<input type="email" class="form-control" name="inputNewMail" placeholder="neue E-Mail Adresse">
	</div>
</div>

<div class="form-group">
	<label for="inputPassword" class="col-sm-2 control-label">neue E-Mail Adresse wiederholen:</label>
	<div class="col-sm-4">
		<input type="email" class="form-control" name="inputNewMail2" placeholder="neue E-Mail Adresse wiederholen">
	</div>
</div>

<br>
<div class="form-group">
	<label for="inputPassword" class="col-sm-2 control-label">Passwort eingeben:</label>
	<div class="col-sm-4">
		<input type="password" class="form-control" name="inputMailPassword" placeholder="Passwort eingeben">
	</div>

</div>






<?php


//Ausgabe Mail-Änderung
switch ($mailstatus) {
	case 0:
			echo  '<div class="alert alert-success" role="alert">Die E-Mail Adresse wurde erfolgreich in "'.$new_mail.'" geändert</div>';
			break;
	case 1:
			echo '<div class="alert alert-danger" role="alert">Die E-Mail Adressen stimmen nicht überein</div>';
			break;
	case 2:
			echo '<div class="alert alert-danger" role="alert">"'.$new_mail.'" ist keine gültige E-Mail Adresse</div>';
			break;
	case 3:
			echo '<div class="alert alert-danger" role="alert">Das Passwort ist nicht korrekt</div>';
			break;
	case 4:
			echo '<div class="alert alert-danger" role="alert">Bitte alle Felder ausfüllen</div>';
			break;
	}
?>


				<div class="form-group">
					<label class="col-sm-2 control-label"></label>
					<div class="col-sm-10">
						<input type="submit" class="btn btn-primary btn" value='E-Mail Adresse ändern' name=submitnewmail>
					</div>
				</div>
			</form>



		</div>
	</div>
</div> <!-- /container -->


	<?php

include('footer.php');

?>
