<?php

//if(isset($_POST)){
	if(/*isset($_POST['button']) &&*/ isset($_POST['username']) && isset($_POST['password'])){

    require_once ('include/dbhandler.php');
    require_once ('include/passhash.php');
    $dbhandler = new DBHandler();

    $username = $_POST['username'];
		$password = $_POST['password'];

		$login = $dbhandler->checkLogin($username,$password);

		if($login==1)
		{
			session_start();

			$user = $dbhandler->getUser($username);

			$_SESSION['userid']=$user["userid"];
			$_SESSION['username']=$username;

      include("header.php");

			include("cardsetsload.php");

		}// Ende Login
		else{ //Login fehlgeschlagen
      include("headernav.php");
      ?>
      <div class="container">
        <br><br><br><br>

				<form method="post" action="cardsets.php">
        <div class="panel panel-danger">
          <div class="panel-heading">
            <h3 class="panel-title">Benutzername oder Passwort ist nicht korrekt!</h3>
          </div>
          <div class="panel-body">
            <label for="exampleInputUser1">Benutzer</label>
            <input type="text" name="username" class="form-control" id="exampleInputEmail1" placeholder="Benutzername"><br>
            <label for="exampleInputPassword1">Password</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password"><br>
            <button type="submit" name="button" class="btn btn-default">Login</button>
          </div>
        </div>
      </div>
		</form>

      <?php
    }//Ende Login fehlgeschalgen
}//Ende Post User + Password
//}//Ende POST
else{//Start kein POST

	session_start();
	if(isset($_SESSION['userid']) && isset($_SESSION['username']))//Start eingeloggt
	{
		include("header.php");
		include("cardsetsload.php");

}//Ende eingeloggt
else{//Start nicht eingeloggt
	header("Location: http://karta.dima23.de/login.php");

}//Ende nicht eingeloggt
}//Ende kein POST

include('footer.php');

?>
