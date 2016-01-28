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
        <h1>Über uns</h1>
        <p>Wir sind eine Gruppe aus f&uuml;nf Studenten der Hochschule Osnabr&uuml;ck am Campus Lingen, die sich zum Ziel gesetzt haben, das lernen für ihre Kommillitonen so angenehm und reibungslos wie m&ouml;glich zu gestalten. Dabei ist es unsere oberste Prämisse, das Portmonnaie von armen Studenten nicht weiter zu strapazieren, als es ohnehin schon passiert.</p>
        <p>Wir bieten Ihnen ein junges innovatives Team, das bereit ist, die erworbenen Kenntnisse des Studiums anzuwenden, um damit auf Kundenwünsche schnell und effizient einzugehen.</p>
        <p>
          Bei uns Lernen Sie rund um die Uhr. Die Website und die App sind 7 Tagen die Woche erreichbar und nutzbar.
          Bitte nutzen Sie auch die Feedback-Funktion.
        </p>
				<p>
					<b>Das Team:</b>
				</p>
				<div class="table-responsive">
			<table>
				<tr>
					<td>
							<img style="padding: 5px; border: solid 1px #e2e0e0; border-radius: 50%;" src="images/torben.JPG" alt="Foto xxx" width="132" height="132" align="left" hspace="20" vspace="5" />
							<center><p style="font-size: 18px;">Torben Pretzel<br><i>CFO</i></p></center>
					</td>
					<td>
							<img style="padding: 5px; border: solid 1px #e2e0e0; border-radius: 50%;" src="images/schrand.jpg" alt="Foto xxx" width="132" height="132" align="left" hspace="20" vspace="5" />
							<center><p style="font-size: 18px;">Oliver Schrand<br><i>CIO</i></p></center>
					</td>
					<td>
							<img style="padding: 5px; border: solid 1px #e2e0e0; border-radius: 50%;" src="images/sundermann.jpg" alt="Foto xxx" width="132" height="132" align="left" hspace="20" vspace="5" />
							<center><p style="font-size: 18px;">Thomas Sundermann<br><i>CTO</i></p></center>
					</td>
					<td>
							<img style="padding: 5px; border: solid 1px #e2e0e0; border-radius: 50%;" src="images/dvogt.jpg" alt="Foto D. Vogt" width="132" height="132" align="left" hspace="20" vspace="5" />
							<center><p style="font-size: 18px;">Dimitrij Vogt<br><i>CEO</i></p></center>
					</td>
					<td>
							<img style="padding: 5px; border: solid 1px #e2e0e0; border-radius: 50%;" src="images/m.yaray.JPG" alt="Foto xxx" width="132" height="132" align="left" hspace="20" vspace="5" />
							<center><p style="font-size: 18px;">Mikail Yaray<br><i>COO</i></p></center>
					</td>
					<td>
							<img style="padding: 5px; border: solid 1px #e2e0e0; border-radius: 50%;" src="images/c3po.jpg" alt="Foto xxx" width="132" height="132" align="left" hspace="20" vspace="5" />
							<center><p style="font-size: 18px;">Bruce<br><i>C3PO</i></p></center>
					</td>
				</tr>
			</table>
		</div>
      </div>
    </div> <!-- /container -->

	<?php

include('footer.php');
?>
