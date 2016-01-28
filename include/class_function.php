	<?php

	
//<--- TODO
//########## <---- Kommentar
class User
{
	private $email = string;
	private $username = string;
	private $password = string;
	private $friendlist = friendlist;
	private $cardsetlist = array();
			
	function login(){
		echo 'Dieser Text ist statisch';}
		//####################Login
		//Abfrage Textfelder leer
		//Abfrage Benutzer in der DB vorhanden
		//Abfrage Passt das Passwort zum Benutzernamen
		//Ausgabe Benutzer oder Passwort falsch (nicht in DB vorhanden) eventuell Verweis auf Registrierung
		function registry(){
			echo 'Dieser Text ist statisch'; }
		//####################Registrieren
		//Benutzername eingeben
		//Abfrage Benutzername schon vorhanden
		//Passwort eingeben
		//Passwortkriterien müssen erfüllt sein
		//Daten in die Datenbank schreiben
			function resetpassword(){
				echo 'Dieser Text ist statisch'; }
				//############Passwort vergessen
				//Email-adresse eingeben
				//Email-adresse vorhanden? DB abgleich
				//Benutzername und Passwort zuschicken

}

class CardSet
{
	private $cardsetid = int;
	private $name = string;
	private $cardlist = array();
		
	function cardset(){
		echo 'Dieser Text ist statisch';}
		//CardSet(cardsetid,name)
		function deletecardset(){
			echo 'Dieser Text ist statisch'; }
		//deleteCardSet(cardSetID)
			function showstats(){
				echo 'Dieser Text ist statisch'; }
		//showStats(cardlist)
				function sharecardset(){
					echo 'Dieser Text ist statisch'; }
		//shareCardSet(username,CardSetID)

}

class Card
{
	private $cardid = int;
	private $question = string;
	private $answer = string;
	private $score = int;
		
	function card(){
		echo 'Dieser Text ist statisch';}
		//Card(CardID, question, answer)
		function deletecard(){
			echo 'Dieser Text ist statisch'; }
		//deleteCard(cardID)
	}


class Learn
{
	private $known = boolean;
	private $testmode = boolean;
	private $cardside = boolean;
	private $learnlist = array();
		
	function knownanswer(){
		echo 'Dieser Text ist statisch';}
		//knownAnswer(cardID, known)
		function result(){
			echo 'Dieser Text ist statisch'; }
		//result()
			function flipcard(){
				echo 'Dieser Text ist statisch'; }
		//flipCard (cardID, cardSide)
				function shownextcard(){
					echo 'Dieser Text ist statisch'; }
		//showNextCard(learnList)
	}

class FriendList
{

	private $friendlist = array();
		
	function addfriend(){
		echo 'Dieser Text ist statisch'; }
		//addFriend(Username:String)
		function deletefriend(){
			echo 'Dieser Text ist statisch'; }
		//deleteFriend(Username:String)
	}

?>
    
