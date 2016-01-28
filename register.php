<?php
include("headernav.php");
$current_file_name = basename($_SERVER['REQUEST_URI'], ".php");
$dbhandler->userlog($clientip." ".$host." ".$_SESSION['userid']." ".$current_file_name);

//Variable resetten
$success = 5;



if (isset($_POST['inputPassword'])){
    $mail = $_POST['inputMail'];
    $username = $_POST['inputUsername'];
    $password = $_POST['inputPassword'];

    //Prüfen, ob alle Felder gefüllt
    if (empty($_POST['inputMail']) == false && empty($_POST['inputUsername']) == false && empty($_POST['inputPassword']) == false){

        //Prüfung, ob der String eine E-Mail Adresse ist
        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {

            //Lege User an
            $success = $dbhandler->createUser($username, $mail, $password);

            //Wenn Registrierung erfolrgreich, gehe auf index.php
            if ($success == 0) {
              header("Location: http://karta.dima23.de/index.php");}

            } else {$success = 3;}
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

      <form class="form-horizontal" method="POST">






<div class="form-group">
  <label for="inputMail" class="col-sm-2 control-label">E-Mail Adresse:</label>
  <div class="col-sm-10">
    <input type="email" class="form-control" name="inputMail" placeholder="E-Mail Adresse eingeben">
  </div>
</div>

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

//Ausgabe
switch ($success) {
  case 0:
    echo '<div class="alert alert-success" role="alert">Registrierung erfolrgreich</div>';
      break;
  case 1:
      echo '<div class="alert alert-danger" role="alert">Benutzername oder Passwort schon vergeben</div>';
      break;
  case 2:
      echo '<div class="alert alert-danger" role="alert">Benutzername oder Passwort bereits vergeben</div>';
      break;
  case 3:
      echo '<div class="alert alert-danger" role="alert">Keine gültige E-Mail Adresse</div>';
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

    </div>
  </form>
</div>
</div>
<?php

include('footer.php');

?>
