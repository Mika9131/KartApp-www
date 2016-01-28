<?php

include ("headernav.php");
?>

<div class="container">
	<br><br><br><br>
<form action="index.php" method="post">

	<div class="panel panel-default">
	  <!-- Default panel contents -->
	  <div class="panel-heading">E-Mailadresse eingeben</div>
	  <div class="panel-body">
			<input type="text" name="resetmail" class="form-control" value="">
      <br>
			<button type="submit" name="button" class="btn btn-primary btn-sm">Abschicken</button>
	  </div>
	</div>
</div>
</form>

<?php
include ("footer.php");
?>
