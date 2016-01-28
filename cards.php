<?php

include("header.php");

$current_file_name = basename($_SERVER['REQUEST_URI'], ".php");
$dbhandler->userlog($clientip." ".$host." ".$_SESSION['userid']." ".$current_file_name);

echo "<div class=\"container\"><br><br><br><br>";
//Karte löschen
	if(isset($_POST['delcard']) )
	{
		$delcard = $dbhandler->deleteCard($_POST['delcard']);
		if($delcard==1){
			echo "<div class=\"alert alert-danger\" role=\"alert\">Karte wurde gel&ouml;scht!</div>";
		}
	}

$setid = $_POST['cardsetid'];





if (isset($_POST['submit'])) {

//Karte bearbeiten
					if (isset($_POST['editcardid'])){



						$text_question = $_POST['frage'];
						$text_awnser =	$_POST['antwort'];


						$updatecard = $dbhandler->updateCard($_SESSION['userid'], $_POST['editcardid'], 0, $text_question, $text_awnser);
						if($updatecard==1){
							echo "<div class=\"alert alert-success\" role=\"alert\">Karte wurde ge&auml;ndert!</div>";
						}
			}
//Karte anlegen
		else {

			echo "<div class=\"alert alert-success\" role=\"alert\">Karte wurde angelegt!</div>";
				$text_question = $_POST['frage'];
				$text_awnser =	$_POST['antwort'];

				$delset = $dbhandler->createCard($_POST['cardsetid'],0,"$text_question", "$text_awnser");
				// echo "<br>createCard: ".$delset;
			}


}
//hole Karten aus DB
$cardset = $dbhandler->getCardset($setid);
$nameofset = $cardset['name'];
$cards = $dbhandler->getAllCards($setid);


if ($_POST['permission'] == 0) {

	echo "<p>

		<form action=\"cardeditor.php\"  method=\"post\">
		<button name=\"addcard\" type=\"submit\" value=\" $setid\" class=\"btn btn-primary\"><span class=\"glyphicon glyphicon-plus\"></span>&nbsp;Karte hinzufügen</button>
		</form>
	</p>";
};?>
	<br>

	<div class="panel panel-default">
	  <!-- Default panel contents -->
	  <div class="panel-heading"> <table width="100%">
	  	<tr>
	  		<td>
					<b><?php echo $cardset['name']; ?> </b><span class="label label-default"> <?php echo count($cards)." Karte(n)"; ?></span>
	  		</td>
				<td width="10%" align="right">
					<form action="learn.php" method="POST" >
							<input type="hidden" name="cardsetid" value="<?php echo $setid; ?>">
							<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-repeat"></span>&nbsp;Lernen</button></a>
					</form>
				</td>
	  	</tr>
	  </table>



		</div>


	<table class="table">


		<?php

		//print_r($cards);

//Karte darstellen + Buttons
		for ($i=0; $i < sizeof($cards) ; $i++) {
			//echo $i;
			//print_r($cards[$i]);
			$id = $cards[$i]['cardid'];

			echo "
			<tr>";
			echo "<td>".$cards[$i]['question']."</td>";
			if($_POST['permission'] == 0){
				echo "
			<td width=\"10%\" align=\"right\"><form method=\"post\">
			<input type=\"hidden\" name=\"cardsetid\" value=\"$setid\">
			<input type=\"hidden\" name=\"delcard\" value=\"$id\">
			<button type=\"submit\" class=\"btn btn-warning btn-sm\" onclick=\"return confirm('Wirklich L&ouml;schen?');\"><span class=\"glyphicon glyphicon-trash\"></span>&nbsp;l&ouml;schen</button>
			</form></td>";
			echo "<td width=\"10%\" align=\"right\"><form action=\"cardeditor.php\"  method=\"post\">
			<input type=\"hidden\" name=\"cardsetid2\" value=\" $setid\">
			<button name=\"editcard\" type=\"submit\" value=\"$id\" class=\"btn btn-primary btn-sm\"><span class=\"glyphicon glyphicon-edit\"></span>&nbsp;bearbeiten</button>
			</form></td>";}
			echo "</tr>
			";

		}

		?>

	</table>

</div>
</div> <!-- /container -->

<?php

include('footer.php');

?>
