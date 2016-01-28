<?php
include("header.php");
//echo "<div class=\"container\">";
$current_file_name = basename($_SERVER['REQUEST_URI'], ".php");
$dbhandler->userlog($clientip." ".$host." ".$_SESSION['userid']." ".$current_file_name);

if(isset($_POST['editcard'])){

$currentcardid = $_POST['editcard'];

	$card = $dbhandler->getCard($currentcardid);
//print_r($card);
}
$currentsetid = $_POST['cardsetid2'];



//
// if (isset($_POST['submit'])) {
//
// 					if (isset($_POST['editcardid'])){
//
//
//
// 						$text_question = $_POST['frage'];
// 						$text_awnser =	$_POST['antwort'];
//
//
// 						$updatecard = $dbhandler->updateCard($_SESSION['userid'], $_POST['editcardid'], 0, $text_question, $text_awnser);
// 						if($updatecard==1){
//
// 						}else{
// 							echo "<br><br><br><div class=\"alert alert-danger\" role=\"alert\">Karte konnte nicht ge&auml;ndert werden!</div>";
// 						}
// 			}
// 		else {
//
// 			echo "<br><br><br><div class=\"alert alert-success\" role=\"alert\">Karte wurde angelegt!</div>";
// 				$text_question = $_POST['frage'];
// 				$text_awnser =	$_POST['antwort'];
//
// 				$delset = $dbhandler->createCard($_POST['editcardsetid'],0,"$text_question", "$text_awnser");
// 				// echo "<br>createCard: ".$delset;
// 			}
//
//
// }


?>

<div class="container">
<script src="libs/ckeditor/ckeditor.js"></script>

	<form action="cards.php" method="POST">
	 <br><br><br><br>
	 	<p>Frage</p>
		<?php if (isset($currentcardid)): ?>
			<input type="hidden" name="editcardid" value="<?php echo $currentcardid; ?>">
			<input type="hidden" name="cardsetid" value="<?php echo $currentsetid; ?>">
		<?php endif; ?>
		<?php if (isset($_POST['addcard'])): ?>
			<input type="hidden" name="cardsetid" value="<?php echo $_POST['addcard']; ?>">

		<?php endif; ?>
		 <textarea class="ckeditor" name="frage" cols="50" rows="10"><?php if(isset($card)){echo $card["question"];} ?></textarea>
		 <br>
		 <p>Antwort</p>
		 <textarea class="ckeditor" name="antwort" cols="50" rows="10"><?php if(isset($card)){echo $card["answer"];} ?></textarea>
	<br>

	 		<input class="btn btn-primary" type="submit" value="Speichern" name="submit">
	  </form>

</div> <!-- /container -->
<br><br>
<?php
include("footer.php");
?>
