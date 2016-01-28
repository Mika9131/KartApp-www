<?php
session_start();

// Datenbank-Config Datei einbinden
require_once ('include/config.php');
require_once ('include/dbhandler.php');
require_once ('include/passhash.php');

$dbhandler = new DBHandler();

if(isset($_SESSION['userid']) && isset($_SESSION['username']))
{
  $user = $dbhandler->getUserById($_SESSION['userid']);
 }else{
 	header("Location: http://karta.dima23.de/login.php");
 }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="apple-touch-icon" sizes="57x57" href="apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="android-chrome-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="manifest.json">
    <meta name="msapplication-TileColor" content="#00aba9">
    <meta name="msapplication-TileImage" content="mstile-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <title>KartA - Karteikarten App</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/navbar-fixed-top.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/custom.css" rel="stylesheet">

    <?php
    $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");
    if($current_file_name == "learn"){ ?>
      <script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script src="js/flip.js"></script>
    <?php
    }
    ?>

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

      <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://karta.dima23.de"><span><img src="images/logo.png" style="width:45px;"></span>KartA</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li <?php if($current_file_name == "apps") {echo "class=\"active\"";} ?>><a href="apps.php">Apps</a></li>
            <li <?php if($current_file_name == "about") {echo "class=\"active\"";} ?>><a href="about.php">&Uuml;ber</a></li>
            <li <?php if($current_file_name == "cardsets") {echo "class=\"active\"";} ?>><a href="cardsets.php">Kartens&auml;tze</a></li>
            <li <?php if($current_file_name == "friendlist") {echo "class=\"active\"";} ?>><a href="friendlist.php">Freundesliste</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-user"></span>&nbsp;<?php if(isset($user)){echo $user["username"];}else{echo "USER";} ?><span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li <?php if($current_file_name == "settings") {echo "class=\"active\"";} ?>><a href="settings.php">Einstellungen</a></li>
            <li class="divider"></li>
            <li>
              <form action="index.php" method="POST">
                <input type="hidden" name="logout" value="true">
                <a class="nav" href="" onclick="document.forms[0].submit();return false;">Logout</a>
              </form>
            </li>
          </ul>
        </li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
