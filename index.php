<?php

require_once('includes/classes/Database.php');

define('DB_HOST', 'localhost');
define('DB_NAME', 'webdev_ue6');
define('DB_USER', 'benutzer12345');
define('DB_PASS', '12345');

$db = new Database();
$cryptedPassword = password_hash('testpassword', PASSWORD_BCRYPT);
$username = "awesome_benutzer";

$cryptedPassword = $db->escapeString($cryptedPassword);
$username = $db->escapeString($username);

//$sql = "INSERT INTO user(name,`password`) VALUES('" . $username . "','" . $cryptedPassword . "')";
//$db->query($sql);

$sql = "SELECT * FROM user WHERE name='" . $username . "'";
$result = $db->query($sql);
if ($db->numRows($result) > 0) //anzahl zeilen mehr als 0
{
            //kein while nötig – wir wissen es gibt nur einen Wert. Mehre Zeilen könnte man
            //mit while($row = $db->fetchAssoc($result)) //herausholen
    $row = $db->fetchAssoc($result);
            //fetch Assoc heißt man greift auf die Spalten wie folgt zu:
            //$row['spaltenname'];
            //fetchObject würde heißen man greift auf die Spalten so zu:
            //$row->spaltenname;
            //In Java und JavaScript greifen Sie Objektorientiert mittels . zu
            //z.B. row.spaltenname. Das ist in PHP anders.y
    if (password_verify("testpassword", $row['password'])) {
        echo "Der Nutzer " . $username . " mit der ID " . $row['id'] . " hat";
        echo " das Passwort testpassword";
    } else {
        echo "Nutzer gefunden aber falsches Passwort!";
    }
} else {
    echo "Keinen Nutzer gefunden";
}
