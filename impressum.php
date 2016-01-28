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
?>
	<div class="container">

      <!-- Mainn component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Impressum</h1>
        <p><h2>Hochschule Osnabr&uuml;ck</h2>
		<br>
		<img src="images/hochschule.jpeg" class="img-responsive" >

			<h2>Anschrift</h2>
			Kaiserstrasse 10 c 	<br>
			49808 Lingen		<br>
			<br>
			E-Mail: kartaapp@outlook.de <br>
			<br>
			Sie erreichen uns telefonisch Montag bis Freitag von 09:00 Uhr bis 18:00 Uhr und Samstag von 09:00 Uhr bis 16:00 Uhr.
        <br><br>
        <b>Telefon: 0591 xxxxxx</b>
        <br><br>
        <p>Ihr Karta Team</p>

      </div>

    </div> <!-- /container -->

	<?php

include('footer.php');
?>
