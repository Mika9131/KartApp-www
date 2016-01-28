<?php
include ("header.php");
$current_file_name = basename($_SERVER['REQUEST_URI'], ".php");
$dbhandler->userlog($clientip." ".$host." ".$_SESSION['userid']." ".$current_file_name);

if(isset($_POST)){


	if(isset($_POST['editcardset']) && isset($_POST['cardsetid']) && isset($_POST['cardsetname']))
	{

?>
<div class="container">
	<br><br><br><br>
<form action="cardsets.php" method="post">

	<div class="panel panel-default">
	  <!-- Default panel contents -->
	  <div class="panel-heading"><?php echo "Geben Sie den neuen Namen ein" ?></div>
	  <div class="panel-body">
			<input type="text" name="cardsetname" class="form-control" value="<?php echo $_POST['cardsetname']; ?>">
			<input type="hidden" name="cardsetid" value="<?php echo $_POST['cardsetid']; ?>">
			<br>
			<button type="submit" name="button" class="btn btn-primary btn-sm">Speichern</button>
	  </div>
	</div>
</div>
</form>
<?php


	}
	if(isset($_POST['newcardset']))
	{

?>
<div class="container">
	<br><br><br><br>
<form action="cardsets.php" method="post">

	<div class="panel panel-default">
		<!-- Default panel contents -->
		<div class="panel-heading"><?php echo "Geben Sie den neuen Namen ein" ?></div>
		<div class="panel-body">
			<input type="text" name="cardsetname" class="form-control" placeholder="Kartensatzname">
			<br>
			<button type="submit" name="button" class="btn btn-primary btn-sm">Speichern</button>
		</div>
	</div>
</div>
</form>
<?php


	}


}

include ("footer.php");
?>
