<?php
$current_file_name = basename($_SERVER['REQUEST_URI'], ".php");
$dbhandler->userlog($clientip." ".$host." ".$_SESSION['userid']." ".$current_file_name);

if(isset($_POST)){

	if(isset($_POST['cardsetid']) && isset($_POST['cardsetname']))
	{
		$update = $dbhandler->updateCardset($_SESSION['userid'],$_POST['cardsetid'],$_POST['cardsetname']);
	}

	if(isset($_POST['cardsetname']) && !(isset($_POST['cardsetid'])))
	{
		$dbhandler->createCardset($_SESSION['userid'],$_POST['cardsetname']);
	}

	if(($_POST['deletecardset']) && isset($_POST['cardsetid']))
	{
		$delcardset = $dbhandler->deleteCardset($_SESSION['userid'],$_POST['cardsetid']);
	}

	if(($_POST['resetstats']) && isset($_POST['cardsetid']))
	{
		$resetstats = $dbhandler->deleteStats($_SESSION['userid'],$_POST['cardsetid']);
		echo $resetstats;
	}
}
$cardsets = $dbhandler->getAllUserCardsets($_SESSION['userid']);
?>
	<div class="container">
	<br><br><br>
	<?php if($update){echo "<div class=\"alert alert-success\" role=\"alert\">Kartensatz wurde ge&auml;ndert!</div>";} ?>
	<?php if($delcardset){echo "<div class=\"alert alert-success\" role=\"alert\">Kartensatz wurde gel&ouml;scht!</div>";} ?>
	<?php if($resetstats){echo "<div class=\"alert alert-success\" role=\"alert\">Statistik für Kartensatz wurde gel&ouml;scht!</div>";} ?>
	<p>
			<form action="cardseteditor.php" method="POST"><button name="addcardset" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>&nbsp;Kartensatz hinzufügen</button><input type="hidden" name="newcardset" value="true"></form>
	</p>
	<br>
	<?php for ($i=0; $i < sizeof($cardsets); $i++) { ?>
	<div class="panel panel-default">
	  <!-- Default panel contents -->
	  <div class="panel-heading">
			<table width="100%">
				<tr>
					<td>
					<b><?php echo $cardsets[$i]['name']; ?>&nbsp;<span class="label label-default"> <?php $countcards = $dbhandler->getAllCards($cardsets[$i]['setid']); echo count($countcards)." Karte(n)"; ?>&nbsp;</span></b>
					</td>
					<td width="10%" align="right">
					<?php if($cardsets[$i]['permission'] == 0){ ?>
					<form action="cardsets.php" method="POST">
					    <input type="hidden" name="cardsetid" value="<?php echo $cardsets[$i]['setid']; ?>">
							<input type="hidden" name="deletecardset" value="true">
							<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Wirklich L&ouml;schen?');"><span class="glyphicon glyphicon-trash"></span>&nbsp;löschen</button></a>
					</form>
					<?php } ?>
					</td>
					<td width="10%" align="left">
					<?php if($cardsets[$i]['permission'] == 0){ ?>
					<form action="cardseteditor.php" method="POST">
					    <input type="hidden" name="cardsetid" value="<?php echo $cardsets[$i]['setid']; ?>">
					    <input type="hidden" name="cardsetname" value="<?php echo $cardsets[$i]['name']; ?>">
							<input type="hidden" name="editcardset" value="true">
							&nbsp;<button name="addcardset" type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span>&nbsp;bearbeiten</button></a>
					</form>
					<?php } ?>
					</td>
					<td width="10%" align="left">
					<?php if($cardsets[$i]['permission'] == 0){ ?>
					<form action="cardsetshare.php" method="POST">
							<input type="hidden" name="cardsetid" value="<?php echo $cardsets[$i]['setid']; ?>">
							<input type="hidden" name="cardsetname" value="<?php echo $cardsets[$i]['name']; ?>">
							<input type="hidden" name="sharecardset" value="true">
							&nbsp;<button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-share"></span>&nbsp;teilen</button>
					</form>
					<?php } ?>
					</td>
					<td width="10%" align="right">
					<form action="cards.php" method="POST">
							<input type="hidden" name="cardsetid" value="<?php echo $cardsets[$i]['setid']; ?>">
							<input type="hidden" name="permission" value="<?php echo $cardsets[$i]['permission']; ?>">
							<button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-th-list"></span>&nbsp; Karten anzeigen</button></a>
					</form>
					</td>
					<td width="10%" align="right">
					<form action="learn.php" method="POST">
					    <input type="hidden" name="cardsetid" value="<?php echo $cardsets[$i]['setid']; ?>">
							<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-repeat"></span>&nbsp;Lernen</button></a>
					</form>
					</td>
				</tr>
			</table>
		</div>
	  <div class="panel-body">
			<!-- <p>
				Anzahl Karteikarten: <?php //$countcards = $dbhandler->getAllCards($cardsets[$i]['setid']); echo count($countcards); ?>
			</p> -->
			<table width="92%">
				<tr>
					<td class="bar">
							<div class="progress" style="height: 30px;">
								<div class="progress-bar progress-bar-custom" role="progressbar" aria-valuenow="<?php $stats=$dbhandler->getStats($_SESSION['userid'],$cardsets[$i]['setid']); echo $stats*100; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $stats*100; ?>%; min-width: 40px; font-size: 20px; padding-top: 4px;">
									<?php echo round($stats*100); ?> %
								</div>
							</div>
					</td>
					<td width="4%" class="bar2">
							<span style="padding: 3px; float: left; width: 25px; text-align: center;">
								<form action="cardsets.php" method="POST">
									<input type="hidden" name="cardsetid" value="<?php echo $cardsets[$i]['setid']; ?>">
									<input type="hidden" name="resetstats" value="true">
									<button type="resetstats" class="btn btn-warning btn-sm" onclick="return confirm('Wirklich L&ouml;schen?');"><span class="glyphicon glyphicon-erase"></span>&nbsp;Statistik l&ouml;schen</button></a>
							</form></span>
					</td>
				</tr>
			</table>
			<?php //echo $stats; $stats*10   min-width: 40px;   <?php echo "20"; ?>
	  </div>
	</div>
	<?php
	}
	?>

</div> <!-- /container -->
