<?php

include("header.php");

$current_file_name = basename($_SERVER['REQUEST_URI'], ".php");
$dbhandler->userlog($clientip." ".$host." ".$_SESSION['userid']." ".$current_file_name);

$db_link = mysqli_connect (MYSQL_HOST,MYSQL_BENUTZER,MYSQL_KENNWORT,MYSQL_DATENBANK);

$sqluser = "SELECT * FROM user";
$sqlcards = "SELECT * FROM cards";
$sqlcardsets = "SELECT * FROM cardsets";
$sqlstats = "SELECT * FROM stats";
$sqluserhascardsets = "SELECT * FROM user_has_cardsets";
$sqlfriends = "SELECT * FROM friends";
$sqllog = "SELECT * FROM userlog ORDER BY id DESC";

$db_erg = mysqli_query( $db_link, $sqluser );
$numrows = mysqli_num_rows($db_erg);

if (!$db_erg)
{
  echo '<br><br><br>Fehler!';
  die('Ung&uuml;ltige Abfrage user: ' . mysqli_error());
}


echo '<br><br><br><br><br><div class="container">'."\n";


// USER Tabelle ausgeben
echo '<div class="col-md-10"><table class="table table-hover table-condensed"><thead><tr><th colspan=7 class="active">User</th></tr></thead><tbody>'."\n";
echo '<thead><tr><th>userid</th><th>username</th><th>password</th><th>email</th><th>apikey</th><th>maxscore</th><th>minscore</th></tr></thead><tbody>'."\n";
while($row = mysqli_fetch_object($db_erg))
{
  echo '<tr>'."\n";
  echo '<td>'.$row->userid.'</td>'."\n";
  echo '<td> '.$row->username.'</td>'."\n";
  echo '<td> '.substr($row->password,-5).'</td>'."\n";
  echo '<td> '.$row->email.'</td>'."\n";
  echo '<td> '.substr($row->apikey,-5).'</td>'."\n";
  echo '<td> '.$row->maxscore.'</td>'."\n";
  echo '<td> '.$row->minscore.'</td>'."\n";
  echo '</tr>'."\n";
}
echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td><td>'.$numrows.'</td></tr>';
echo '</tbody></table></div><br>';
// # ENDE User Tabelle ausgeben

$db_erg = mysqli_query( $db_link, $sqlcardsets );
$numrows = mysqli_num_rows($db_erg);

if (!$db_erg)
{
  echo '<br><br><br>Fehler!';
  die('Ung&uuml;ltige Abfrage cardsets: ' . mysqli_error());
}

// CARDSET Tabelle ausgeben
echo '<div class="col-md-4"><table class="table table-hover table-condensed"><thead><tr><th colspan=2 class="active">Cardset</th></tr></thead><tbody>'."\n";
echo '<thead><tr><th>setid</th><th>name</th></tr></thead><tbody>'."\n";
while($row = mysqli_fetch_object($db_erg))
{
  echo '<tr>'."\n";
  echo '<td>'.$row->setid.'</td>'."\n";
  echo '<td> '.$row->name.'</td>'."\n";
  echo '</tr>'."\n";
}
echo '<tr><td></td><td>'.$numrows.'</td></tr>';
echo '</tbody></table></div>';
// # ENDE Cardset Tabelle ausgeben

$db_erg = mysqli_query( $db_link, $sqlcards );
$numrows = mysqli_num_rows($db_erg);

if (!$db_erg)
{
  echo '<br><br><br>Fehler!';
  die('Ung&uuml;ltige Abfrage cards: ' . mysqli_error());
}

// CARDS Tabelle ausgeben
echo '<div class="col-md-8"><table class="table table-hover table-condensed" data-toggle="table" data-height="99"><thead><tr><th colspan=5 class="active">Cards</th></tr></thead><tbody>'."\n";
echo '<thead><tr><th>cardid</th><th>type</th><th>question</th><th>answer</th><th>cardsets_setid</th></tr></thead><tbody>'."\n";
while($row = mysqli_fetch_object($db_erg))
{
  echo '<tr>'."\n";
  echo '<td>'.$row->cardid.'</td>'."\n";
  echo '<td> '.$row->type.'</td>'."\n";
  echo '<td> '.$row->question.'</td>'."\n";
  echo '<td> '.$row->answer.'</td>'."\n";
  echo '<td> '.$row->cardsets_setid.'</td>'."\n";
  echo '</tr>'."\n";
}
echo '<tr><td></td><td></td><td></td><td></td><td>'.$numrows.'</td></tr>';
echo '</tbody></table></div>';
// # ENDE Cards Tabelle ausgeben

$db_erg = mysqli_query( $db_link, $sqluserhascardsets );
$numrows = mysqli_num_rows($db_erg);

if (!$db_erg)
{
  echo '<br><br><br>Fehler!';
  die('Ung&uuml;ltige Abfrage userhascards: ' . mysqli_error());
}

// USERHASCARDSETS Tabelle ausgeben
echo '<div class="col-md-5"><table class="table table-hover table-condensed"><thead><tr><th colspan=3 class="active">Userhascardsets</th></tr></thead><tbody>'."\n";
echo '<thead><tr><th>user_userid</th><th>cardsets_setid</th><th>permission</th></tr></thead><tbody>'."\n";
while($row = mysqli_fetch_object($db_erg))
{
  echo '<tr>'."\n";
  echo '<td>'.$row->user_userid.'</td>'."\n";
  echo '<td> '.$row->cardsets_setid.'</td>'."\n";
  echo '<td> '.$row->permission.'</td>'."\n";
  echo '</tr>'."\n";
}
echo '<tr><td></td><td><td>'.$numrows.'</td></tr>';
echo '</tbody></table></div>';
// # ENDE Userhascardsets Tabelle ausgeben

$db_erg = mysqli_query( $db_link, $sqlstats );
$numrows = mysqli_num_rows($db_erg);

if (!$db_erg)
{
  echo '<br><br><br>Fehler!';
  die('Ung&uuml;ltige Abfrage stats: ' . mysqli_error());
}

// STATS Tabelle ausgeben
echo '<div class="col-md-5"><table class="table table-hover table-condensed"><thead><tr><th colspan=4 class="active">Stats</th></tr></thead><tbody>'."\n";
echo '<thead><tr><th>time</th><th>user_userid</th><th>cards_cardid</th><th>known</th></tr></thead><tbody>'."\n";
while($row = mysqli_fetch_object($db_erg))
{
  echo '<tr>'."\n";
  echo '<td>'.$row->time.'</td>'."\n";
  echo '<td>'.$row->user_userid.'</td>'."\n";
  echo '<td> '.$row->cards_cardid.'</td>'."\n";
  echo '<td> '.$row->known.'</td>'."\n";
  echo '</tr>'."\n";
}
echo '<tr><td></td><td></td><td><td>'.$numrows.'</td></tr>';
echo '</tbody></table></div>';
// # ENDE Stats Tabelle ausgeben

$db_erg = mysqli_query( $db_link, $sqlfriends );
$numrows = mysqli_num_rows($db_erg);

if (!$db_erg)
{
  echo '<br><br><br>Fehler!';
  die('Ung&uuml;ltige Abfrage friends: ' . mysqli_error());
}

// FRIENDS Tabelle ausgeben
echo '<div class="col-md-3"><table class="table table-hover table-condensed"><thead><tr><th colspan=2 class="active">Friends</th></tr></thead><tbody>'."\n";
echo '<thead><tr><th>userid</th><th>friendid</th></tr></thead><tbody>'."\n";
while($row = mysqli_fetch_object($db_erg))
{
  echo '<tr>'."\n";
  echo '<td>'.$row->user_userid.'</td>'."\n";
  echo '<td>'.$row->user_friendid.'</td>'."\n";
  echo '</tr>'."\n";
}
echo '<tr><td></td><td>'.$numrows.'</td></tr>';
echo '</tbody></table></div>';
// # ENDE Friends Tabelle ausgeben

$db_erg = mysqli_query( $db_link, $sqllog );
$numrows = mysqli_num_rows($db_erg);

if (!$db_erg)
{
  echo '<br><br><br>Fehler!';
  die('Ung&uuml;ltige Abfrageuserlogs: ' . mysqli_error());
}

// userlog Tabelle ausgeben
echo '<div class="col-md-7"><table class="table table-hover table-condensed"><thead><tr><th colspan=2 class="active">Userlog</th></tr></thead><tbody>'."\n";
echo '<thead><tr><th>ipadr</th><th>time</th></tr></thead><tbody>'."\n";
while($row = mysqli_fetch_object($db_erg))
{
  echo '<tr>'."\n";
  echo '<td>'.$row->ipadr.'</td>'."\n";
  echo '<td>'.$row->timestamp.'</td>'."\n";
  echo '</tr>'."\n";
}
echo '<tr><td></td><td>'.$numrows.'</td></tr>';
echo '</tbody></table></div>';
// # ENDE Userlog Tabelle ausgeben

echo '</div>';

mysqli_close($db_link);
include('footer.php');

?>
