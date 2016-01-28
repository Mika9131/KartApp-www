<?php
/**
* Klasse um Datenbank Operationen auszuführen
* @author Dimitrij Vogt
* @version 0.5
**/

class DBHandler {

    private $conn;

    // Konstruktur erstellt eine Verbindung zur Datenbank
    // speichert diese in der VAR $conn
    function __construct() {
        require_once dirname(__FILE__) .'/dbconnect.php';
        // opening db connection
        $db = new DBCONNECT();
        $this->conn = $db->connect();
    }

/* ------------- `users` Tabelle Methoden ------------------ */

/**
 * createUser erstellt einen neuen Benutzer
 * @param String $name Benutzername
 * @param String $email Email Adresse des Benutzers
 * @param String $password Benutzerpasswort
 * @return 0 bei Erfolgreichem anlegen
 * @return 1 bei Fehler
 * @return 2 wenn User schon vorhanden
 */
public function createUser($name, $email, $password) {
  require_once ('passhash.php');
  $response = array();

  // Prüfe ob Benutzer bereits existiert
  if (!($this->isUserExists2($name)) && !($this->isUserExists($email))) {
    // Generiere aus dem Passwort ein Hash
    $password_hash = PassHash::hash($password);

    // Generiere einen neuen API-Key
    $apikey = $this->generateApiKey();

    // SQL: INSERT Befehl
    // Der Variable stmt den SQL Ausdruck zuweisen
    $stmt = $this->conn->prepare("INSERT INTO user(username, email, password, apikey) values(?, ?, ?, ?)");
    // Den SQL-Ausdruck in der stmt Variable mit Werten füllen
    $stmt->bind_param("ssss", $name, $email, $password_hash, $apikey);

    // Speichert das Ergebnis der Ausführung des Befehls in die Variable result
    $result = $stmt->execute();

    // Schließt die DB-Verbindung
    $stmt->close();

    // Check Ausführung des SQL Befehls
    if ($result) {
        // Benutzer erfolgreich angelegt
        $user = $this->getUserByEmail($email);

        $this->assignUserCardset($user["userid"], 83, 1);
      return USER_CREATED_SUCCESSFULLY;
    } else {
       // Benutzer anlegen fehlgeschlagen
      return USER_CREATE_FAILED;
    }
  } else {
      // Benutzer bereits in DB vorhanden
     return USER_ALREADY_EXISTED;
  }
  /**
  * @todo Prüfen, ob der Befehl noch gebraucht wird!
  **/
  //$this->conn->close();
  //return $response;
}

/**
 * checkLogin prüft Benutzername und Passwort zum Login
 * @param String $email Benutzername
 * @param String $password Benutzerpasswort
 * @return 1: Daten stimmen überein
 * @return 0: Daten sind falsch oder nicht vorhanden
 */
public function checkLogin($username, $password) {
        // Prüfen ob den Benutzername in der DB existiert
        $stmt = $this->conn->prepare("SELECT password FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);

        $stmt->execute();

        // Benutzerpassworthash in die VAR passwort_hash schreiben
        $stmt->bind_result($password_hash);

        $stmt->store_result();

        // Wenn ein Benutzer gefunden wurde
        if ($stmt->num_rows > 0) {
            // Prüfe nun das Passwort

            $stmt->fetch();

            $stmt->close();

            // Passwort Eingabe mit Passworthash aus der DB vergleichen
            if (PassHash::check_password($password_hash, $password)) {
                // Passwort ist korrekt
                return TRUE;
            } else {
                // Passwort falsch
                return FALSE;
            }
        } else {
            $stmt->close();

            // Benutzer existiert nicht in der DB
            return FALSE;
        }
}

// /**
//  * deleteUser Löscht einen Benutzer
//  * @param String $userid BenutzerID des Benutzers
//  * @return 1: Benutzer wurde gelöscht
//  * @return 0: Benutzer existiert nicht
// */
// public function deleteUser($userid){
//   /**
//   * @todo Benutzer aus der user_has_cardsets löschen
//   * @todo Benutzer aus der User Tabelle löschen
//   **/
// }
//
/**
 * updateUser Ändert Daten eines Benutzers
 * @param String $userid BenutzerID des Benutzers
 * @param String $email Benutzer Email Adresse
 * @param String $password Benutzer Passwort
 * @return 1: Benutzer wurde geändert
 * @return 0: Benutzer existiert nicht
*/
public function updateUser($userid, $email, $password){
  require_once('passhash.php');
  $password_hash = PassHash::hash($password);

  $stmt = $this->conn->prepare("UPDATE user SET email=?, password=? WHERE userid=?");
  $stmt->bind_param("ssi", $email, $password_hash, $userid);
  if($stmt->execute()){
    $stmt->close();
    return true;
  }else{
  return false;
  }
}

/**
 * resetPassword Ändert Passwort eines Benutzers
 * @param String $userid BenutzerID des Benutzers
 * @param String $password Benutzer Passwort
 * @return 1: Passwort wurde geändert
 * @return 0: Benutzer existiert nicht
*/
public function resetPassword($userid, $password){
  require_once('passhash.php');
  $password_hash = PassHash::hash($password);

  $stmt = $this->conn->prepare("UPDATE user SET password=? WHERE userid=?");
  $stmt->bind_param("si", $password_hash, $userid);
  $user = $this->getUserId($userid);
  if($stmt->execute()){
    $stmt->close();

    require '../libs/PHPMailer/PHPMailerAutoload.php';

    $text = "Hallo ".$user['username']."!<br />Ihr neues Passwort: ".$password."</p><p><a href=\"http://karta.dima23.de\">KartApp Webseite</a></p><p>Freundliche gr&uuml;&szlig;t Sie<br />Ihr KartApp-Team</p>";

    $subject = "KartA - neues Passwort";

    $mail = new PHPMailer;

    //$mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp-mail.outlook.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'kartaapp@outlook.de';                 // SMTP username
    $mail->Password = 'Totodimiol';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    //$mail->SMTPDebug = 2;                                  // TCP port to connect to

    $mail->From = 'kartaapp@outlook.de';
    $mail->FromName = 'KartA - Mailer';
    $mail->addAddress($user['email'], $user['username']);     // Add a recipient
    $mail->addReplyTo('kartaapp@outlook.de', 'KartA - Mailer');
    $mail->addBCC('kartaapp@outlook.de');

    $mail->isHTML(true);

    $mail->Subject = "KartA - neues Passwort";
    $mail->Body    = "Hallo ".$user['username']."!<br />Ihr neues Passwort: ".$password."</p><p><a href=\"http://fensalir.lin.hs-osnabrueck.de/~karta\">KartA Webseite</a></p><p>Freundlich gr&uuml;&szlig;t Sie<br />Ihr Karta-Team</p>";
    $mail->AltBody = "Hallo ".$user['username']."! Ihr neues Passwort: ".$password."Freundlich gr&uuml;&szlig;t Sie Ihr Karta-Team";

    $mail->send();
    //mail($user['email'], $subject, $text, "From: KartApp-Team <karta@outlook.de>");
    return true;
  }else{
  return false;
  }
}

public function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

/**
 * PRIVATE Methode um zu prüfen, ob der User existiert
 * @uses createUser
 * @param String $email Email Adresse des Benutzers
 * @return 1: Benutzer existiert
 * @return 0: Benutzer existiert nicht
*/
private function isUserExists($email) {
  $stmt = $this->conn->prepare("SELECT userid from user WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();
  $num_rows = $stmt->num_rows;
  $stmt->close();
  return $num_rows > 0;
}

/**
 * PRIVATE Methode um zu prüfen, ob der User existiert
 * @uses createUser
 * @param String $username Benutzername
 * @return 1: Benutzer existiert
 * @return 0: Benutzer existiert nicht
*/
private function isUserExists2($username) {
  $stmt = $this->conn->prepare("SELECT userid from user WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $stmt->store_result();
  $num_rows = $stmt->num_rows;
  $stmt->close();
  return $num_rows > 0;
}

/**
 * getUser gibt Benutzerdaten zurück
 * @param String $username Benutzername
 * @return Array([username], [email], [apikey])
 * @return NULL: Wenn Benutzer nicht existiert
*/
public function getUser($username) {
  $stmt = $this->conn->prepare("SELECT userid, username, email, apikey FROM user WHERE username = ?");
  $stmt->bind_param("s", $username);
  if ($stmt->execute()) {
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $user;
  } else {
    return NULL;
  }
}

/**
 * getUserByEmail gibt Benutzerdaten zurück
 * @param String $userid BenutzerID
 * @return Array([username], [email], [apikey])
 * @return NULL: Wenn Benutzer nicht existiert
*/
public function getUserByEmail($email) {
  $stmt = $this->conn->prepare("SELECT userid, username, email, apikey FROM user WHERE email = ?");
  $stmt->bind_param("s", $email);
  if ($stmt->execute()) {
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $user;
  } else {
    return NULL;
  }
}

/**
 * getUserById gibt Benutzerdaten zurück
 * @param String $userid BenutzerID
 * @return Array([username], [email], [apikey])
 * @return NULL: Wenn Benutzer nicht existiert
*/
public function getUserById($userid) {
  $stmt = $this->conn->prepare("SELECT userid, username, email, apikey FROM user WHERE userid = ?");
  $stmt->bind_param("i", $userid);
  if ($stmt->execute()) {
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $user;
  } else {
    return NULL;
  }
}

/**
 * getApiKeyById gibt den API-Key zurück
 * @param String $userid BenutzerID
 * @return Array([apikey])
 * @return NULL: wenn der Benutzer nicht existiert
*/
public function getApiKeyById($userid) {
  $stmt = $this->conn->prepare("SELECT apikey FROM user WHERE userid = ?");
  $stmt->bind_param("i", $userid);
  /**
  * @todo Prüfen ob die Befehle noch gebraucht werden
  **/
  // $stmt->bind_result($apikey);
  // echo $apikey;
  // $stmt->close();
  // return $apikey;
  if ($stmt->execute()) {
    $apikey = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $apikey;
  } else {
    return NULL;
  }
}

/**
 * getUserId gib die BenutzerID zurück
 * @param String $apikey Benutzer API-Key
 * @return Int: Userid
 * @return NULL: Wenn API-Key nicht gefunden wurde
*/
public function getUserId($apikey) {
  $stmt = $this->conn->prepare("SELECT userid FROM user WHERE apikey = ?");
  $stmt->bind_param("s", $apikey);
  if ($stmt->execute()) {
    $stmt->bind_result($userid);
    // $userid = $stmt->get_result()->fetch_assoc();
    $stmt->fetch();
    $id = $userid;
    $stmt->close();
    return $id;
  } else {
    return NULL;
  }
}

/**
 * isValidApiKey Prüft ob ein API-Key existiert
 * @param String $apikey Benutzer API-Key
 * @return 1: wenn API-Key existiert
 * @return 0: wenn API-Key nicht existiert
*/
public function isValidApiKey($apikey) {
  $stmt = $this->conn->prepare("SELECT userid from user WHERE apikey = ?");
  $stmt->bind_param("s", $apikey);
  $stmt->execute();
  $stmt->store_result();
  $num_rows = $stmt->num_rows;
  $stmt->close();
  return $num_rows > 0;
}

/**
 * generateApiKey generiert einen neuen API-Key
 * @return apikey
*/
private function generateApiKey() {
  return md5(uniqid(rand(), true));
}

/* ------------- `cardsets` Tabelle Methoden ------------------ */

/**
 * createCardset erstellt einen neuen Kartensatz und weist diesen
 * einem Benutzer zu mit assignUserCardset
 * @param String $userid BenutzerID wem der Kartensatz gehört
 * @param String $cardsetname Kartensatzname
 * @return cardsetid: ID des neuen Kartensatzes
 * @return 0: wenn hinzufügen nicht funktioniert hat, oder das zuweisen
 * zu einem Benutzer nicht funktioniert hat
*/
public function createCardset($userid, $cardsetname) {
  $stmt = $this->conn->prepare("INSERT INTO cardsets(name) VALUES(?)");
  $stmt->bind_param("s", $cardsetname);
  $result = $stmt->execute();
  $stmt->close();

  // Kartensatz wurde erfolgreich angelegt
  // Jetzt einem Benutzer zuweisen
  if ($result) {
    // Kartensatz ID speichern
    $new_cardsetid = $this->conn->insert_id;
    // Katzensatz einem Benutzer zuweisen
    $res = $this->assignUserCardset($userid, $new_cardsetid, 0);
    // Bei erfolgreichem zuweisen Kartensatz ID zurückgeben
    if ($res) {
      return $new_cardsetid;
    // Wenn nicht, Kartensatz wieder löschen
    } else {
      // Kartensatz aus der cardset Tabelle löschen
      $stmt = $this->conn->prepare("DELETE c FROM cardsets c WHERE c.setid = ?");
      $stmt->bind_param("i", $cardsetid);
      $stmt->execute();
      return NULL;
    }
  } else {
    // Kartensatz anlegen fehlgeschlagen
    return NULL;
  }
}

/**
 * getCardset gibt einen Kartensatznamen zurück
 * @param String $cardsetid Kartensatz ID
 * @return Name eines Kartensatzes
 * @return NULL: Bei nicht existentem Kartensatz
*/
public function getCardset($cardsetid) {
  $stmt = $this->conn->prepare("SELECT name from cardsets WHERE setid = ?");
  $stmt->bind_param("i", $cardsetid);
  if ($stmt->execute()) {
    $cardset = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $cardset;
  } else {
    return NULL;
  }
}

/**
 * getAllUserCardsets gibt alle Kartensätze eines Benutzers zurück
 * @param String $userid BenutzerID
 * @return Array([setid], [name])
 * @return NULL: wenn Benutzer keine Kartensätze hat
 */
public function getAllUserCardsetsWithCards($userid) {
  $stmt = $this->conn->prepare("SELECT c.setid, c.name, uhc.permission FROM cardsets c, user_has_cardsets uhc WHERE uhc.user_userid = ? AND uhc.cardsets_setid = c.setid");
  $stmt->bind_param("i", $userid);

  // Wenn Abfrage erfolgreich war, gebe es in einem Array zurück
  if ($stmt->execute()) {
    $cardsets = array();
    $stmt->bind_result($setid, $name, $permission);
    while ($stmt->fetch()) {
      $cardsets[] = array('setid' => $setid, 'name' => $name, 'permission' => $permission, 'cards' => '');
      // $cardsets[$setid]['name'] = $name;
    }
    $stmt->close();
    foreach($cardsets as $c => $cardset){
        $cards = $this->getAllCardsWithBox($userid,$cardsets[$c]['setid']);
        $cardsets[$c]['cards'] = $cards;
    }
    return $cardsets;
  } else {
    return NULL;
  }
}

/**
 * getAllUserCardsets gibt alle Kartensätze eines Benutzers zurück
 * @param String $userid BenutzerID
 * @return Array([setid], [name])
 * @return NULL: wenn Benutzer keine Kartensätze hat
 */
public function getAllUserCardsets($userid) {
  $stmt = $this->conn->prepare("SELECT c.setid, c.name, uhc.permission FROM cardsets c, user_has_cardsets uhc WHERE uhc.user_userid = ? AND uhc.cardsets_setid = c.setid");
  $stmt->bind_param("i", $userid);

  // Wenn Abfrage erfolgreich war, gebe es in einem Array zurück
  if ($stmt->execute()) {
    $cardsets = array();
    $stmt->bind_result($setid, $name, $permission);
    while ($stmt->fetch()) {
      $cardsets[] = array('setid' => $setid, 'name' => $name, 'permission' => $permission);
      // $cardsets[$setid]['name'] = $name;
    }
    $stmt->close();
    return $cardsets;
  } else {
    return NULL;
  }
}

/**
 * updateCardset Ändert Namen eines Kartensatzes
 * @param String $userid BenutzerID
 * @param String $cardsetid KartensatzID
 * @param String $cardsetname Neuer Kartensatzname
 * @return 1: Wenn Änderung erfolgreich war
 * @return 0: Wenn Änderung fehlgeschlagen ist
*/
public function updateCardset($userid, $cardsetid, $cardsetname) {
  $stmt = $this->conn->prepare("SELECT cardsets_setid FROM user_has_cardsets WHERE user_userid = ? AND cardsets_setid = ? AND permission='0'");
  $stmt->bind_param("ii", $userid, $cardsetid);
  $stmt->execute();
  $stmt->store_result();
  $num_rows = $stmt->num_rows;
  $stmt->close();

  // Wenn der Kartensatz dem Benutzer zugewiesen ist und er der Besitzer ist
  if ($num_rows > 0) {
    $stmt = $this->conn->prepare("UPDATE cardsets c set c.name = ? WHERE c.setid = ?");
    $stmt->bind_param("si", $cardsetname, $cardsetid);
    $stmt->execute();
    $num_affected_rows = $stmt->affected_rows;
    $stmt->close();
    return $num_affected_rows > 0;
  }else{
    return NULL;
  }
}

/**
 * deleteCardset Löscht ein Kartensatz
 * @param String $userid BenutzerID
 * @param String $cardsetid KartensatzID
 * @return 1: Wenn Löschung erfolgreich war
 * @return 0: Wenn Löschung fehlgeschlagen ist
*/
public function deleteCardset($userid, $cardsetid) {
  $stmt = $this->conn->prepare("SELECT cardsets_setid FROM user_has_cardsets WHERE user_userid = ? AND cardsets_setid = ? AND permission='0'");
  $stmt->bind_param("ii", $userid, $cardsetid);
  $stmt->execute();
  $stmt->store_result();
  $num_rows = $stmt->num_rows;
  $stmt->close();

  // Wenn Benutzer Besitzer des Kartensatzes ist:
  if ($num_rows > 0) {
    // Alle Zuweisungen aus der user_has_cardsets Tabelle löschen
    $stmt = $this->conn->prepare("DELETE u FROM user_has_cardsets u WHERE u.cardsets_setid = ?");
    $stmt->bind_param("i", $cardsetid);
    $stmt->execute();

    // Alle Karten aus der cards Tabelle löschen
    $stmt = $this->conn->prepare("DELETE c FROM cards c WHERE c.cardsets_setid = ?");
    $stmt->bind_param("i", $cardsetid);
    $stmt->execute();

      /**
      * @todo Alle Statistiken für diesen Kartensatz löschen
      * ODER: DB seitig einrichten, dass alle Statistiken gelöscht werden
      **/

    // Kartensatz aus der cardset Tabelle löschen
    $stmt = $this->conn->prepare("DELETE c FROM cardsets c WHERE c.setid = ?");
    $stmt->bind_param("i", $cardsetid);
    $stmt->execute();
    $num_affected_rows = $stmt->affected_rows;
    $stmt->close();
    return $num_affected_rows > 0;
  }
}

/**
 * assignUserCardset Kartensatz einem Benutzer zuweisen
 * @param String $userid BenutzerID
 * @param String $cardsetid KartensatzID
 * @return 1: Erfolgreich
 * @return 0: Fehlgeschlagen
*/
public function assignUserCardset($userid, $cardsetid, $permission) {
  $stmt = $this->conn->prepare("INSERT INTO user_has_cardsets(user_userid, cardsets_setid, permission) values(?, ?, ?)");
  $stmt->bind_param("iii", $userid, $cardsetid, $permission);
  $result = $stmt->execute();
  $stmt->close();
  return $result;
}

/**
 * deleteAssignedUser Benutzerzuweisung löschen
 * @param String $userid BenutzerID
 * @param String $cardsetid KartensatzID
 * @return 1: Erfolgreich
 * @return 0: Fehlgeschlagen
*/
public function deleteAssignedUser($userid, $cardsetid) {
  $stmt = $this->conn->prepare("DELETE u FROM user_has_cardsets u WHERE u.user_userid = ? AND u.cardsets_setid = ?");
  $stmt->bind_param("ii", $userid, $cardsetid);
  $return = $stmt->execute();
  $stmt->close();
  $this->deleteStats($userid, $cardsetid);
  return $return;
}

/**
 * assignedUser Benutzer die einem Kartensatz zugewiesen sind
 * @param String $cardsetid KartensatzID
 * @return 1: Erfolgreich
 * @return 0: Fehlgeschlagen
*/
public function assignedUser($cardsetid) {
  $stmt = $this->conn->prepare("SELECT uhc.user_userid, u.username, uhc.permission FROM user_has_cardsets uhc, user u WHERE cardsets_setid = ? AND u.userid = uhc.user_userid");
  $stmt->bind_param("i", $cardsetid);
  if ($stmt->execute()) {
    $user = array();
    $stmt->bind_result($user_userid, $username, $permission);
    while ($stmt->fetch()) {
      $user[] = array('userid' => $user_userid, 'username' => $username, 'permission' => $permission);
    }
    $stmt->close();
    return $user;
  } else {
    return NULL;
  }
}

/* ------------- `cards` Tabelle Methoden ------------------ */

/**
 * createCard Erstellt Karteikarte
 * @param String $cardsetid KartensatzID
 * @param String $type Kartentyp
 * @param String $question Frage
 * @param String $answer Antwort
 * @return cardid: Karte wurde angelegt
 * @return NULL: Karte konnte nicht angelegt werden
*/
public function createCard($cardsetid, $type, $question, $answer){
  $stmt = $this->conn->prepare("INSERT INTO cards(type, question, answer, cardsets_setid) VALUES(?, ?, ?, ?)");
  $stmt->bind_param("issi", $type, $question, $answer, $cardsetid);
  $result = $stmt->execute();
  $stmt->close();

  if($result){
    $new_cardid = $this->conn->insert_id;
    return $new_cardid;
  }else{
    return NULL;
  }
}

/**
 * deleteCard Löscht Karteikarte
 * @param String $cardid Karten ID
 * @return 1: Karte wurde gelöscht
 * @return 0: Karte konnte nicht gelöscht werden
*/
public function deleteCard($cardid){
  // Statistik für die Karte löschen
  $stmt = $this->conn->prepare("DELETE FROM stats WHERE cards_cardid = ?");
  $stmt->bind_param("i", $cardid);
  $result = $stmt->execute();

  // Karte löschen
  $stmt = $this->conn->prepare("DELETE FROM cards WHERE cardid = ?");
  $stmt->bind_param("i", $cardid);
  $result = $stmt->execute();
  $stmt->store_result();
  $num_rows = $stmt->num_rows;
  $stmt->close();
  return $result;
}

/**
 * updateCard Ändert Karteikarte
 * @param String $cardid Karten ID
 * @param String $question Frage
 * @param String $answer Antwort
 * @return 1: Karte wurde geändert
 * @return 0: Karte konnte nicht geändert werden
*/
public function updateCard($userid, $cardid, $type, $question, $answer){
  $stmt = $this->conn->prepare("SELECT u.cardsets_setid FROM user_has_cardsets u, cards c WHERE u.cardsets_setid = c.cardsets_setid AND u.permission='0' AND c.cardid = ? AND u.user_userid = ?");
  $stmt->bind_param("ii", $cardid, $userid);
  $stmt->execute();
  $stmt->store_result();
  $num_rows = $stmt->num_rows;
  $stmt->close();

  // Wenn der Kartensatz dem Benutzer zugewiesen ist und er der Besitzer ist
  if ($num_rows > 0) {
    $stmt = $this->conn->prepare("UPDATE cards c set c.type = ?, c.question = ?, c.answer= ? WHERE c.cardid = ?");
    $stmt->bind_param("issi", $type, $question, $answer, $cardid);
    $stmt->execute();
    $num_affected_rows = $stmt->affected_rows;
    $stmt->close();
    return $num_affected_rows > 0;
  }else{
    return NULL;
  }

}

/**
 * @todo Prüfen ob User auf Karte Zugriff hat
 * getCard Gibt Karteikarte zurück
 * @param String $cardid Karten ID
 * @return Array([question], [answer])
 * @return NULL: Karte nicht gefunden
*/
public function getCard($cardid){
  $stmt = $this->conn->prepare("SELECT type, question, answer, cardsets_setid from cards WHERE cardid = ?");
  $stmt->bind_param("i", $cardid);
  if ($stmt->execute()) {
    $card = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $card;
  } else {
    return NULL;
  }
}

/**
 * getAllCards Gibt alle Karten mit Inhalt zurück
 * @param String $cardsetid Kartensatz ID
 * @return Array([cardid], [question], [answer])
 * @return NULL: Kartensatz nicht gefunden
*/
public function getAllCards($cardsetid){
  $stmt = $this->conn->prepare("SELECT cardid, type, question, answer, cardsets_setid FROM cards c WHERE c.cardsets_setid = ?");
  $stmt->bind_param("i", $cardsetid);

  // Wenn Abfrage erfolgreich war, gebe es in einem Array zurück
  if ($stmt->execute()) {
    $cards = array();
    $stmt->bind_result($cardid, $type, $question, $answer, $cardsets_setid);
    while ($stmt->fetch()) {
      $cards[] = array('cardid' => $cardid, 'type' => $type, 'question' => $question, 'answer' => $answer, 'cardsets_setid' => $cardsets_setid);
    }
    $stmt->close();
    return $cards;
  } else {
    return NULL;
  }
}

public function getAllCardsWithBox($userid, $cardsetid){
  $stmt = $this->conn->prepare("SELECT cardid, type, question, answer, cardsets_setid FROM cards c WHERE c.cardsets_setid = ?");
  $stmt->bind_param("i", $cardsetid);

  // Wenn Abfrage erfolgreich war, gebe es in einem Array zurück
  if ($stmt->execute()) {
    $cards = array();
    $stmt->bind_result($cardid, $type, $question, $answer, $cardsets_setid);
    while ($stmt->fetch()) {
      $cards[] = array('cardid' => $cardid, 'type' => $type, 'question' => $question, 'answer' => $answer, 'cardsets_setid' => $cardsets_setid, 'box' => 0);
    }
    foreach($cards as $c => $card){
        $box = $this->getBox($userid,$cards[$c]['cardid']);
        $cards[$c]['box'] = $box;
    }
    $stmt->close();
    return $cards;
  } else {
    return NULL;
  }
}

/**
 * getLearnCards Gibt Karten zum Lernen zurück
 * @param String $cardsetid Kartensatz ID
 * @param String $userid Benutzer ID
 * @return Array([cardid], [question], [answer])
 * @return NULL: Kartensatz nicht gefunden
*/


/**
 * deleteCards Löscht Karteikarten eines Kartensatzes
 * @param String $cardid Karten ID
 * @return 1: Karten wurde gelöscht
 * @return 0: Karten konnte nicht gelöscht werden
*/
public function deleteAllCards($cardsetid){
  // Karte löschen
  $stmt = $this->conn->prepare("DELETE c FROM cards c WHERE c.cardsets_setid = ?");
  $stmt->bind_param("i", $cardsetid);
  $result = $stmt->execute();
  $stmt->store_result();
  $num_rows = $stmt->num_rows;
  $stmt->close();
  return $num_rows > 0;
}

/* ------------- `stats` Tabelle Methoden ------------------ */

/**
 * setStats Setze stat für eine Karte
 * @param String $cardid Karten ID
 * @param String $userid Benutzer ID
 * @param String $know Antwort
 * @return 1: stat gesetzt
 * @return 0: stat konnte nicht gesetzt werden
*/
public function setStats($userid, $cardid, $known){
  $stmt = $this->conn->prepare("INSERT INTO stats(user_userid, cards_cardid, known) values(?, ?, ?)");
  $stmt->bind_param("iii", $userid, $cardid, $known);
  $result = $stmt->execute();
  $stmt->close();

  return $result;
}



/**
 * getStats Gibt Statistik für Kartensatz zurück
 * @param String $cardsetid Karten ID
 * @param String $userid Benutzer ID
 * @return % Gewusst
 * @return NULL Kartensatz nicht gefunden bzw. keine Statistik
*/
public function getStats($userid, $cardsetid){
  $stmt = $this->conn->prepare("SELECT cardid FROM cards WHERE cardsets_setid = ?");
  $stmt->bind_param("i", $cardsetid);

  if ($stmt->execute()) {
    $stmt->bind_result($cardid);
    $stmt->store_result();
    $countCards = $stmt->num_rows;
    // $stepsToComplete = $countCards * BOXCOUNT - $countCards;
    $stepsToComplete = 0;
    $boxSteps = $countCards * BOXCOUNT - $countCards;
    $cardsWithoutStats = 0;
    // Alle Karten eines Kartensatzes in einen Array schreiben
    while ($stmt->fetch()) {
      $stats[] = array('cardid' => $cardid);
    }

    // Prüfen ob für den User eine Statistik für den Kartensatz besteht
    foreach($stats as $cardid => $card){
      if(!$this->existStats($userid, $card['cardid'])){
        $cardsWithoutStats++;
      }
    }

    if($cardsWithoutStats == $countCards){
      return 0;
    }else{
      // Für jede Karte im Array die Box abgfragen
      foreach($stats as $cardid => $card){
        $box = $this->getBox($userid, $card['cardid']);
        if($box <= BOXCOUNT){
          $stepsToComplete = $stepsToComplete + ($box-1);
        }
      }
      $stmt->close();
      // Prozentsatz noch zu Lernende Karten zurückgeben
      echo $stepsToComplete;
      echo $boxSteps;
      return $stepsToComplete/$boxSteps;
    }
  } else {
    return 0;
  }
}

/**
 * getBox Gibt aktuelle Box für eine Karte zurück
 * @param String $cardid Karten ID
 * @param String $userid Benutzer ID
 * @return 1: stat gesetzt
 * @return 0: stat konnte nicht gesetzt werden
*/
public function getBox($userid, $cardid){
  $stmt = $this->conn->prepare("SELECT known FROM stats WHERE cards_cardid = ? AND user_userid = ? ORDER BY date");
  $stmt->bind_param("ii", $cardid, $userid);

  if ($stmt->execute()) {
    $box = 1;
    $stmt->bind_result($known);
    while ($stmt->fetch()) {
      if($known == '1'){
        $box++;
      }else{
        $box = 1;
      }
    }
    $stmt->close();
    if($box >= BOXCOUNT){$box = BOXCOUNT;}
    return $box;
  } else {
    return NULL;
  }
}

/**
 * existStats Gibt zurück ob Statistik zu Karte existiert
 * @param String $cardid Karten ID
 * @param String $userid Benutzer ID
 * @return 1: Statistik vorhanden
 * @return NULL: Keine Statstik vorhanden
 * @uses getStats
*/
public function existStats($userid, $cardid){
  $stmt = $this->conn->prepare("SELECT known FROM stats WHERE cards_cardid = ? AND user_userid = ?");
  $stmt->bind_param("ii", $cardid, $userid);
  $stmt->execute();
  $stmt->store_result();
  $num_rows = $stmt->num_rows;
  $stmt->close();
  return $num_rows > 0;
}

/**
 * deleteCardStats Löscht Statistik für eine Karte
 * @param String $cardid Karten ID
 * @param String $userid Benutzer ID
 * @return 1: Statistik vorhanden
 * @return NULL: Keine Statstik vorhanden
 * @uses deleteStats
*/
public function deleteCardStats($userid, $cardid){
  $stmt = $this->conn->prepare("DELETE FROM stats WHERE user_userid = ? AND cards_cardid = ?");
  $stmt->bind_param("ii", $userid, $cardid);
  $result = $stmt->execute();
  $stmt->store_result();
  $num_rows = $stmt->num_rows;
  $stmt->close();
  return $result;
}

/**
 * resetStats Lösche Statistik für einen Benutzer
 * @param String $userid Benutzer ID
 * @return 1: stats zurückgesetzt
 * @return 0: stats konnten nicht zurückgesetzt werden
*/
public function resetStats($userid){
  $stmt = $this->conn->prepare("DELETE FROM stats WHERE user_userid = ?");
  $stmt->bind_param("i", $userid);
  $result = $stmt->execute();
  $stmt->store_result();
  $num_rows = $stmt->num_rows;
  $stmt->close();
  return $result;
}

/**
 * deleteStats Lösche Statistik für einen Kartensatz pro Benutzer
 * @param String $userid Benutzer ID
 * @param String $cardsetid Kartensatz ID
 * @return 1: stats zurückgesetzt
 * @return 0: stats konnten nicht zurückgesetzt werden
*/
public function deleteStats($userid, $cardsetid){
  $stmt = $this->conn->prepare("SELECT cardid FROM cards WHERE cardsets_setid = ?");
  $stmt->bind_param("i", $cardsetid);

  if ($stmt->execute()) {
    $stmt->bind_result($cardid);
    $stmt->store_result();
    $cardsNotDone = $stmt->num_rows;
    $countCards = $cardsNotDone;
    $cardsWithoutStats = 0;
    // Alle Karten eines Kartensatzes löschen
    while ($stmt->fetch()) {
      $this->deleteCardStats($userid, $cardid);
    }
    $stmt->close();
    return true;
  } else {
    return NULL;
  }
}

// /* ------------- `friendlist` Tabelle Methoden ------------------ */

/**
 * getFriends Gibt alle Freunde eines Benutzers zurück
 * @param String $userid Benutzer ID
 * @return Array ([userid], [username])
 * @return NULL: Konnte Benutzer nicht finden
*/
public function getFriends($userid){
  $stmt = $this->conn->prepare("SELECT userid, username FROM user u, friends f WHERE f.user_userid = ? AND f.user_friendid = u.userid");
  $stmt->bind_param("i", $userid);

  // Wenn Abfrage erfolgreich war, gebe es in einem Array zurück
  if ($stmt->execute()) {
    $stmt->bind_result($userid, $username);
    while ($stmt->fetch()) {
      $friends[] = array('userid' => $userid, 'username' => $username);
    }
    $stmt->close();
    return $friends;
  } else {
    return NULL;
  }
}

/**
 * addFriend Fügt einen neuen Freund der Freundesliste hinzu
 * @param String $userid Benutzer ID
 * @param String $friendid Freundes ID
 * @return 1: Freund hinzugefügt
 * @return 0: Freund nicht gefunden
*/
public function addFriend($userid, $friendid){
  $stmt = $this->conn->prepare("INSERT INTO friends(user_userid, user_friendid) values(?, ?)");
  $stmt->bind_param("ii", $userid, $friendid);
  $result = $stmt->execute();
  $stmt->close();
  return $result;
}

/**
 * deleteFriend Löscht einen Freund aus der Freundesliste
 * @param String $userid Benutzer ID
 * @param String $friendid Freundes ID
 * @return 1: Freund gelöscht
 * @return 0: Freund nicht gefunden
*/
public function deleteFriend($userid, $friendid){
  $stmt = $this->conn->prepare("DELETE FROM friends WHERE user_userid = ? AND user_friendid = ?");
  $stmt->bind_param("ii", $userid, $friendid);
  $result = $stmt->execute();
  $stmt->close();
  return $result;
}

public function userlog($message){
  $stmt = $this->conn->prepare("INSERT INTO userlog(ipadr) values(?)");
  $stmt->bind_param("s", $message);
  $result = $stmt->execute();
  $stmt->close();
}


//public function checkMail($email)
// {
// $s = '/^[A-Z0-9._-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z.]{2,6}$/i';
// if(preg_match($s, $email))        return true;
// return FALSE;
//}
// {
//     if(preg_match('/^[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+(?:\.[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+)*\@[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+(?:\.[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+)+$/i'), $email) return true;
//
//     return false;
// }
//End of Class
}

?>
