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
?>
	<div class="container">

      <!-- Mainn component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Datenschutz</h1>
        <br>
        <p>Die Nutzung unserer Webseite ist in der Regel ohne Angabe personenbezogener Daten m&ouml;glich.
Soweit auf unseren Seiten personenbezogene Daten (beispielsweise Name, Anschrift oder eMail-Adressen) erhoben werden, erfolgt dies, soweit m&ouml;glich, stets auf freiwilliger Basis. Diese Daten werden ohne Ihre ausdr&uuml;ckliche Zustimmung nicht an Dritte weitergegeben.
Wir weisen darauf hin, dass die Daten&uuml;bertragung im Internet (z.B. bei der Kommunikation per E-Mail) Sicherheitsl&uuml;cken aufweisen kann.
Ein l&uuml;ckenloser Schutz der Daten vor dem Zugriff durch Dritte ist nicht m&ouml;glich.
Der Nutzung von im Rahmen der Impressumspflicht ver&ouml;ffentlichten Kontaktdaten durch Dritte zur &Uuml;bersendung von nicht ausdr&uuml;cklich angeforderter Werbung und Informationsmaterialien wird hiermit ausdr&uuml;cklich widersprochen.
Die Betreiber der Seiten behalten sich ausdr&uuml;cklich rechtliche Schritte im Falle der unverlangten Zusendung von Werbeinformationen, etwa durch Spam-Mails, vor.
        <br><br><br> 
        </p>
        
        <p>Quelle: eRecht24</p>
      </div>

    </div> <!-- /container -->

	<?php

include('footer.php');
?>
