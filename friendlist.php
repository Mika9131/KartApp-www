<?php

include("header.php");
$current_file_name = basename($_SERVER['REQUEST_URI'], ".php");
$dbhandler->userlog($clientip." ".$host." ".$_SESSION['userid']." ".$current_file_name);
echo "<div class=\"container\"><br><br><br><br>";

if(($_POST['delfriend']) && isset($_POST['friendid'])){
	$delfriend = $dbhandler->deleteFriend($_SESSION['userid'], $_POST['friendid']);
	if($delfriend){
		echo "<div class=\"alert alert-danger\" role=\"alert\">Freund wurde gel&ouml;scht!</div>";
	}
}

if(($_POST['addfriend']) && isset($_POST['username'])){
	$friend = $dbhandler->getUser($_POST['username']);
	$addfriend = $dbhandler->addFriend($_SESSION['userid'], $friend['userid']);
	if($addfriend){
		echo "<div class=\"alert alert-success\" role=\"alert\">Freund wurde hinzugef&uuml;gt!</div>";
	}else{
		echo "<div class=\"alert alert-danger\" role=\"alert\">Benutzer mit dem Namen wurde nicht gefunden!</div>";
	}
}


$friends = $dbhandler->getFriends($_SESSION['userid']);

?>
	<br>

	<div class="panel panel-default">
	  <!-- Default panel contents -->
	  <div class="panel-heading"> <table width="100%">
	  	<tr>
	  		<td >
					<h4>Freunde&nbsp;<span class="badge"> <?php echo count($friends); ?></span></h4>
	  		</td>
				<td width="25%" align="right">
					<form action="friendlist.php" method="POST">
					<div class="col-lg-12">
					    <div class="input-group">
					      <input type="text" class="form-control" name="username" placeholder="Benutzername">
					      <input type="hidden" name="addfriend" value="true">
					      <span class="input-group-btn">
					        <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-plus"></span></button>
					      </span>
					    </div><!-- /input-group -->
					  </div>
					</form>
				</td>
	  	</tr>
	  </table>
		</div>
	<table class="table">
		<?php
		for($i=0; $i < sizeOf($friends); $i++) {
			echo "<tr>";
			echo "<td padding-top=\"10px\"><span class=\"glyphicon glyphicon-user\"></span>&nbsp;".$friends[$i]['username']."</td>";
			echo "<td width=\"10%\" align=\"right\"><form method=\"post\" action=\"friendlist.php\">
			<input type=\"hidden\" name=\"friendid\" value=\"".$friends[$i]['userid']."\">
			<button name=\"delfriend\" type=\"submit\" value=\"true\" class=\"btn btn-warning btn-sm\" onclick=\"return confirm('Wirklich L&ouml;schen?');\"><span class=\"glyphicon glyphicon-trash\"></span>&nbsp;l&ouml;schen</button>
			</form></td>";
			echo "</td>";}
			echo "</tr>";
		?>

	</table>

</div>
</div> <!-- /container -->
<br><br>
<?php

include('footer.php');

?>
