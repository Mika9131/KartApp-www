<?php

include("header.php");

$current_file_name = basename($_SERVER['REQUEST_URI'], ".php");
$dbhandler->userlog($clientip." ".$host." ".$_SESSION['userid']." ".$current_file_name);

if(isset($_POST['aktNumber'])){
		$number = $_POST['aktNumber'] + 1;
}

if(!(isset($number))){
	$number = 0;
}

if(isset($_POST['cardsetid'])){
	$cardsetid = $_POST['cardsetid'];
}

$cardset = $cardsetid;
$card = $dbhandler->getAllCards($cardset);
$cardsetname = $dbhandler->getCardset($cardset)["name"];
$maxCards = sizeOf($card);

if(!(isset($known))){
	$known = 0;
}

if(!(isset($notknown))){
	$notknown = 0;
}

$bar = $number/$maxCards*100;

$aktCard = $card[$number];
if(isset($_POST)){
	if(isset($_POST['notKnown'])){
		$statCard = $card[$number-1];
		$dbhandler->setStats($_SESSION['userid'], $statCard["cardid"], 0);
		//echo "<br><br><br>nicht gewusst".$notknown;
	}

	if(isset($_POST['Known'])){
		$statCard = $card[$number-1];
		$dbhandler->setStats($_SESSION['userid'], $statCard["cardid"], 1);
		//echo "<br><br><br>gewusst".$known;
	}
}



?>
<div class="container">
	<br><br>

	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<center><br>
				<h1><?php echo $cardsetname; ?></h1>
				<div class="progress" style="height: 18px;">
					<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $bar; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo ceil($bar); ?>%;">
						<?php echo ceil($bar); ?> %
					</div>
				</div>
				<?php
				if($number < $maxCards){ ?>

					<div id="card" class="card">
						<div class="front"><br>
							<?php
							echo $aktCard["question"];
							?>
						</div>
						<div class="back"><br>
							<?php
							echo $aktCard["answer"];
							?>
						</div>
					</div>

					<nav>
						<form class="form-inline" method="POST" action="learn.php">
							<div class="btn-group btn-group-justified" role="group" aria-label="...">
								<div class="btn-group" role="group">
									<button type="submit" class="btn btn-danger btn-lg" name="notKnown" value="nicht gewusst"><span class="glyphicon glyphicon-remove"></span> Nicht gewusst</button>
								</div>
								<!-- <div class="btn-group" role="group">
									<button type="submit" class="btn btn-default btn-lg" id="flip"><span class="glyphicon glyphicon-refresh"></span></button>
								</div> -->
								<div class="btn-group" role="group">
									<button type="submit" class="btn btn-success btn-lg" name="Known" value="gewusst">Gewusst <span class="glyphicon glyphicon-ok"></span></button>
								</div>
							</div>
							<input type="hidden" name="aktNumber" value="<?php echo $number; ?>">
							<input type="hidden" name="cardsetid" value="<?php echo $cardset; ?>">
						</div>
					</form>
				</div>
			</nav>
				<?php
			}else{ ?>

					<p class="bg-success" ><a href="cardsets.php">Fertig mit lernen!</a></p>

			<?php
			}
			?>
	</center>
</div>
<div class="col-md-3"></div>
</div>
</div> <!-- /container -->

<script type="text/javascript">
$("#card").flip({
	axis: "y",
	reverse: true,
	trigger: "click"
});
</script>

<br><br><br>

<?php


include('footer.php');

?>
