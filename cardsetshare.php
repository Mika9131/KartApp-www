<?php

include("header.php");
$current_file_name = basename($_SERVER['REQUEST_URI'], ".php");
$dbhandler->userlog($clientip." ".$host." ".$_SESSION['userid']." ".$current_file_name);

echo "<div class=\"container\"><br><br><br><br>";

if(($_POST['deluser']) && isset($_POST['userid']) && isset($_POST['cardsetid'])){
	$deluser = $dbhandler->deleteAssignedUser($_POST['userid'], $_POST['cardsetid']);
	if($deluser){
		echo "<div class=\"alert alert-danger\" role=\"alert\">Benutzer wurde gel&ouml;scht!</div>";
	}
}

if((isset($_POST['read']) || isset($_POST['write'])) && isset($_POST['username']) && isset($_POST['cardsetid'])){
	if(isset($_POST['read'])){
		$permission = 1;
	}elseif(isset($_POST['write'])){
		$permission = 0;
	}
	$addUser = $dbhandler->getUser($_POST['username']);
	$assigned = $dbhandler->assignUserCardset($addUser['userid'], $_POST['cardsetid'], $permission);
	if($assigned){
		echo "<div class=\"alert alert-success\" role=\"alert\">Benutzer wurde hinzugef&uuml;gt!</div>";
	}else{
		echo "<div class=\"alert alert-danger\" role=\"alert\">Benutzer konnte nicht hinzugef&uuml;gt werden!</div>";
	}
}

if(isset($_POST['cardsetid']) && isset($_POST['cardsetname'])){
	$aUser = $dbhandler->assignedUser($_POST['cardsetid']);
}

?>
	<h3>
		Freigabe für Kartensatz: <b><?php echo $_POST['cardsetname']?></b>
	</h3>
	<div class="panel panel-default">
	  <!-- Default panel contents -->
	  <div class="panel-heading"> <table width="100%">
	  	<tr>
	  		<td >
					<b>Benutzer</b>&nbsp;<span class="label label-default"><?php echo count($aUser);?></span>
	  		</td>
				<td width="25%" align="right">
					<form action="cardsetshare.php" method="POST">
					<div class="col-lg-12">
					    <div class="input-group">
					      <input type="text" class="form-control" name="username" placeholder="Benutzername">
					      <input type="hidden" name="cardsetid" value="<?php echo $_POST['cardsetid'];?>">
					      <input type="hidden" name="cardsetname" value="<?php echo $_POST['cardsetname'];?>">
					      <span class="input-group-btn">
					        <button name="read" class="btn btn-default" type="submit" title="Lesen"><span class="glyphicon glyphicon-eye-open"> </span></button>
									<button name="write" class="btn btn-default btn-success" type="submit" title="Schreiben"><span class="glyphicon glyphicon-pencil"> </span></button>
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
		foreach ($aUser as $key => $row) {
				$permission[$key]    = $row['permission'];
				$username[$key] = $row['username'];
		}
		array_multisort($permission, SORT_DESC, $username, SORT_ASC, $aUser);

		for($i=0; $i < sizeOf($aUser); $i++) {
			echo "<tr>";
			echo "<td padding-top=\"10px\"><span class=\"glyphicon glyphicon-user\"></span>&nbsp;".$aUser[$i]['username'];
			if($aUser[$i]['permission'] == 0){
				echo "&nbsp;</span><span class=\"label label-default alert-success\">schreiben/lesen</span></td>";
			}elseif($aUser[$i]['permission'] == 1){
				echo "&nbsp;<span class=\"label label-default alert-info\">lesen</span></td>";
			}
				echo "<td width=\"10%\" align=\"right\"><form method=\"post\" action=\"cardsetshare.php\">
				<input type=\"hidden\" name=\"userid\" value=\"".$aUser[$i]['userid']."\">
				<input type=\"hidden\" name=\"cardsetid\" value=\"".$_POST['cardsetid']."\">
				<input type=\"hidden\" name=\"cardsetname\" value=\"".$_POST['cardsetname']."\">
				<button name=\"deluser\" type=\"submit\" value=\"true\""; if($aUser[$i]['userid']==$_SESSION['userid']){echo 'class="btn btn-default btn-sm disabled';}else{echo 'class="btn btn-warning btn-sm';}
				echo "\" onclick=\"return confirm('Wirklich L&ouml;schen?');\"><span class=\"glyphicon glyphicon-trash\"></span>"; if($aUser[$i]['userid']==$_SESSION['userid']){echo "&nbsp;verlassen</button>";}else{echo "&nbsp;l&ouml;schen</button>";}
				echo "</form></td>";
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
