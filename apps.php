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
        <h1>Apps</h1>
        <p>Unsere App ist sowohl auf IOS- als auch (Android) Smartphones erh&auml;ltlich. Wir wollen m&ouml;glichst jedem die Chance geben, einen Eindruck von unsere App zu machen und gegebenenfalls sie zu nutzen.</p>
        <p>Die App ist f&uuml;r jede Zielgruppe gedacht und in der Bedienung sehr leicht anzuwenden. Die Schritte zum Lernen sind selbsterkl&auml;rend und das Design ist besonders schlicht gestaltet.</p>
        <br>
				<table width="100%">
					<tr>
						<td width="50%">
							<center><b>iPhone</b>
							<div class="iphone-body">
								<div class="camera-1"></div>
								<div class="camera-2"></div>
								<div class="iphone-screen">
									<div class="banner1"></div>
								</div>
							</div><br>
							<a href="#"><img src="images/AppStore.png" alt="" width="135" height="47"/></a>
						</center>
						</td>
						<td width="50%">
							<center><b>Android</b>
								<div class="phone device-fill-color device-border">
								  <div class="screen"></div>
								  <div class="button-android"></div>
								</div>
							<br>
							<a href="#"><img src="images/playstore.jpg" alt="" width="135" height="47"/></a>
						</center>
						</td>
					</tr>
				</table>


      </div>

    </div> <!-- /container -->

	<?php

include('footer.php');
?>
