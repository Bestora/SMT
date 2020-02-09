<?php

/**
 * Klasse zur Verwaltung der FTP Accounts KGU
 *
 * @author    Werner Pallentin <wpa@palle.de>
 * @package   Module
 */
class Proftpd
{

    public $uid = '2001';
    public $gid = '2001';
    public $shell = '/sbin/nologin';
    public $fTable = '';
    public $sTable = '';
    public $result = False;

    /**
     * Methode zum auslesen eines Accounts/Users
     * @param string $sUser
     * @return string
     */
    public function getUser($sUser)
    {
        $db = new Database('SMT-FTP');

        $query = "SELECT * FROM ftpuser WHERE userid=:userid";
        $value = array(
            ':userid' => $sUser
        );

        $db->getQuery($query, $value);
        return $db->getValue();
    }

    /**
     * Methode zum setzen eines Status zu einem Account
     * @param string $sStatus
     * @param string $sUser
     */
    public function setStatus($sStatus, $sUser)
    {
        $db = new Database('SMT-FTP');
        $temp_passwd = base::createCode();

        if ($sStatus == 'block') {
            $this->fTable = 'ftpuser';
            $this->sTable = 'ftpclosed';
        }

        if ($sStatus == 'unlock') {
            $this->fTable = 'ftpclosed';
            $this->sTable = 'ftpuser';
            Session::set('temp_passwd', $temp_passwd);
            $initial = True;
        }

        if ($sStatus == 'delete') {
            $this->fTable = 'ftpuser';
            $this->sTable = 'ftpdelete';
        }

        $query = "SELECT * FROM $this->fTable WHERE userid=:userid";
        $db->getQuery($query, array(
            ':userid' => $sUser
        ));

        $query = "INSERT INTO $this->sTable (userid,passwd,uid,gid,homedir,shell,count,accessed,modified) VALUES(:userid,:passwd,:uid,:gid,:homedir,:shell,:count,:accessed,:modified)";
        $value = array(
            ':userid' => $db->getValue('userid', 0),
            ':passwd' => $temp_passwd,
            ':uid' => $db->getValue('uid', 0),
            ':gid' => $db->getValue('gid', 0),
            ':homedir' => str_replace("../", "", $db->getValue('homedir', 0)),
            ':shell' => $db->getValue('shell', 0),
            ':count' => $db->getValue('count', 0),
            ':accessed' => $db->getValue('accessed', 0),
            ':modified' => $db->getValue('modified', 0)
        );

        $db->getQuery($query, $value);

        $query = "DELETE FROM $this->fTable WHERE userid=:userid";
        $value = array(
            ':userid' => $sUser
        );
        $db->getQuery($query, $value);

        if (isset($initial)) {
            $query = "UPDATE ftpuser SET gueltig=:gueltig WHERE userid=:userid";
            $value = array(
                ':userid' => $sUser,
                ':gueltig' => date('Y-m-d', time())
            );
            $db->getQuery($query, $value);
        }

        // Logeintrag in die Datenbank schreiben
        $this->weblog($db->getValue('userid', 0), "Status auf $sStatus gesetzt");
    }

    /**
     * Methode zum speichern eines Logeintrages
     *
     * @param <string> $sUser
     * @param <string> $sInhalt
     */
    public function weblog($sUser, $sInhalt)
    {
        $db = new Database('SMT-FTP');

        $query = "INSERT INTO weblog (benutzer,userid,inhalt) VALUES(:benutzer,:userid,:inhalt)";
        if (isset($_SERVER ['PHP_AUTH_USER'])) {
            $value = array(
                ':benutzer' => $_SERVER ['PHP_AUTH_USER'],
                ':userid' => $sUser,
                ':inhalt' => $sInhalt
            );
        } else {
            $value = array(
                ':benutzer' => 'sys',
                ':userid' => $sUser,
                ':inhalt' => $sInhalt
            );
        }
        $db->getQuery($query, $value);
    }

    /**
     * Methode zum speichern eines neuen Accounts
     * @param array $aForm
     */
    public function newUser($aForm)
    {
        $db = new Database('SMT-FTP');

        $query = "INSERT INTO ftpuser (userid,passwd,uid,gid,homedir,shell,accessed,modified) VALUES(:userid,:passwd,:uid,:gid,:homedir,:shell,:accessed,:modified)";
        $value = array(
            ':userid' => $aForm ['userid'],
            ':passwd' => $aForm ['passwd'],
            ':uid' => $this->uid,
            ':gid' => $this->gid,
            ':homedir' => str_replace("../", "", $db->getValue('homedir', 0)),
            ':shell' => $this->shell,
            ':accessed' => date("Y-m-d H:i:s"),
            ':modified' => date("Y-m-d H:i:s")
        );
        $db->getQuery($query, $value);
        $this->weblog($aForm ['userid'], 'Benutzer angelegt mit dem Verzeichnis ' . $aForm ['homedir'] . 'angelegt');
    }

    /**
     * Methode zum speichern von Accountdaten
     * @param array $aForm
     * @param string $iID
     */
    public function saveUser($aForm, $iID)
    {
        $db = new Database('SMT-FTP');

        $query = "UPDATE ftpuser SET passwd=:passwd, userid=:userid, homedir=:homedir WHERE id=:id";
        $value = array(
            ':passwd' => $aForm ['passwd'],
            ':userid' => $aForm ['userid'],
            ':homedir' => $aForm ['homedir'],
            ':id' => $iID
        );
        $db->getQuery($query, $value);

        Session::set('save_erfolg', 'Benutzerdaten erfolgreich geändert !');
        $this->weblog($aForm ['userid'], $aForm ['userid'] . ' - ' . $aForm ['passwd'] . ' - ' . $aForm ['homedir']);
    }

    /**
     * Logfile vom Server lesen
     * und als Array zurückgeben
     */
    public function readLogfileFromServer()
    {

        $access_log = "assets/logfile/proftpd.log";
        $ausgabe = '<pre>' . file_get_contents($access_log) . '</pre>';

        return $ausgabe;
    }

}

?>