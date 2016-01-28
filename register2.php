<?php
include("headernav.php");

//reset der Variable
$success = 5;

//Überprüfung der Eingaben

//Prüfen, ob $_POST Variable gesetzt
if (isset($_POST['inputPassword'])){
  //Prüfung, ob alle Felder ausgefüllt
  if (empty($_POST['inputPassword']) == false && empty($_POST['inputMail']) == false && empty($_POST['inputUsername']) == false){

    $mail = $_POST['inputMail'];
    $username = $_POST['inputUsername'];
    $password = $_POST['inputPassword'];

    //Prüng, ob E-Mail-String korrete Syntax hat
    if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        //registriere User
        $success = $dbhandler->createUser($username, $mail, $password);
          //Wenn erfolgreich registriert, index.php laden
          if ($success == 0) {
            header("Location: http://fensalir.lin.hs-osnabrueck.de/~karta/index.php");}

          //Werte für Ausgabe der anderen Ergebnisparameter
    }  else {$success = 3;}
  } else {$success = 4;}
}
?>


<div class="container">
  <br><br>
  <h1>Registrieren</h1>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Neuen Benutzer anlegen</h3>
    </div>
    <div class="panel-body">
      <form class="form-horizontal" method='POST'>






<div class="form-group">
  <label for="inputUsername" class="col-sm-2 control-label">Benutzername:</label>
  <div class="col-sm-10">
    <input type="username" class="form-control" name="inputUsername" placeholder="Benutzernamen eingeben">
  </div>
</div>


<div class="form-group">
  <label for="inputPassword" class="col-sm-2 control-label">Passwort:</label>
  <div class="col-sm-10">
    <input type="password" class="form-control" name="inputPassword" placeholder="Passwort eingeben">
  </div>
</div>

<?php

//Ausgabe bei Fehler
switch ($success) {
  case 0:
    echo '<div class="alert alert-success" role="alert">Registrierung erfolrgreich</div>';

      break;
  case 1:
      echo '<div class="alert alert-danger" role="alert">Unknown Error</div>';
      break;
  case 2:
      echo '<div class="alert alert-danger" role="alert">Benutzername oder E-Mail Adresse bereits vergeben</div>';
      break;
  case 3:
      echo '<div class="alert alert-danger" role="alert">"' .$mail.'" ist keine gültige E-Mail Adresse</div>';
      break;
  case 4:
      echo '<div class="alert alert-danger" role="alert">Bitte alle Felder ausfüllen</div>';
      break;
  }
?>

        <div class="form-group">
          <label for="inputPassword" class="col-sm-2 control-label"></label>
          <div class="col-sm-10">
            <input type="submit" class="btn btn-primary btn" value="Registrieren" name="submitNewUser">
          </div>
        </div>


      </form>
    </div>
  </div>
</div>
<?php

include('footer.php');

?>
