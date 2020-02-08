<?php

/**
 * PHP SMT by palle
 * Monitor your servers and websites.
 *
 * This file is part of PHP SMT by palle.
 * PHP SMT by palle is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PHP SMT by palle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PHP SMT by palle.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     SMT
 * @author      Werner Pallentin <wpa@palle.de>
 * @copyright   Copyright (c) Werner Pallentin <wpa@palle.de>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: v2.1
 * @link        https://smt.palle.dev
 **/

class Server extends Service
{

    public $server;
    public $serverart;

    /**
     * Initiiator mit setzen des Controllers / Serverart
     * @param type $serverart
     */
    public function __construct($serverart = '')
    {
        if (!empty($serverart)) {
            $this->serverart = $serverart;
        }
    }

    /**
     * getter für die IP Adressliste
     */
    public function getSystemIPs()
    {
        $db = new Database('SMT-ADMIN');
        $db->getQuery("SELECT * FROM wos_server ORDER BY INET_ATON(ipadressen)", array(), True);

        return $db->getValue();
    }

    /**
     * Getter für die Systeme die aktuealisiert werden sollen, nach Priorität sortiert
     * @param type $prio
     * @return array
     */
    public function getAllUpdateSystem($prio)
    {
        $db = new Database('SMT-ADMIN');
        $db->getQuery("SELECT id FROM wos_server WHERE prio=:prio", array(':prio' => $prio));

        return $db->getValue();
    }

    /**
     * Liste aller Systeme einlesen
     * @return type
     */
    public function getAllSystem($details = True)
    {

        $db = new Database('SMT-ADMIN');

        if (!empty($this->serverart)) {
            $result = $db->getQuery("SELECT * FROM wos_server WHERE serverart=:serverart ORDER BY prio DESC, bezeichnung ASC", array(':serverart' => $this->serverart), True);
        } else {
            $result = $db->getQuery("SELECT * FROM wos_server WHERE monitor=:monitor ORDER BY prio DESC, bezeichnung ASC", array(':monitor' => 1), True);
        }

        if ($details === True) {
            for ($i = 0; $i < count($result); $i++) {
                $result[$i] = $this->getSystem($result[$i]['id'], True);
            }
        }

        return $result;
    }

    /**
     * Alles Syteminfotmationen auslesen
     * @param type $iId
     * @param type $return
     * @return type
     */
    public function getSystem($iId, $services = True, $return = True)
    {

        $db = new Database('SMT-ADMIN');
        $db->getQuery("SELECT * FROM wos_server WHERE id=:iId", array(':iId' => $iId));

        $result = $db->getValue();
        $this->server = $result['0'];

        // Standardstatus ist erstmal ON
        $this->server['status'] = 'green';
        $this->server['status_title'] = 'System arbeitet einwandfrei !';
        $this->server['HomeStatusServiceError'] = 0;
        $this->server['detail'] = self::getSystemDetails($iId);
        $this->server['ports'] = self::getPorts($this->server['ipadressen']);

        if ($services === True) {
            // Services einlesen
            $this->server['services'] = parent::getAllSystemService($iId);

            // Falls es keine Services gibt löschen
            if (count($this->server['services']) == 0) {
                unset($this->server['services']);
            }

            $off = parent::getHomeStatusService($iId, 'off');
            $warn = parent::getHomeStatusService($iId, 'warn');
            $monitor = parent::getHomeMonitorService($iId);

            // Wenn es einen Service mit dem Status OFF gibt das System auf OFF stellen
            if ($off > 0) {
                $this->server['HomeStatusServiceError'] = +$off;
                $this->server['status'] = 'red';
                $this->server['status_title'] = 'System ist offline, ein Dienst hat einen Fehler !';
            }
            if ($warn > 0) {
                $this->server['HomeStatusServiceError'] = +$warn;
                $this->server['status'] = 'yellow';
                $this->server['status_title'] = 'System funktioniert eingeschränkt, eine Abhängigkeit ist nicht erfüllt !';
            }
            if ($monitor > 0) {
                $this->server['HomeStatusServiceError'] = +$monitor;
                $this->server['status'] = 'gray';
                $this->server['status_title'] = 'Ein Dienst funktioniert nicht, ist aber nicht wichtig';
            }

            // Abhängikeiten einlesen
            if ($this->server['service_relations'] != '') {
                $sr = explode(',', $this->server['service_relations']);

                for ($i = 0; $i < count($sr); $i++) {
                    $rel = parent::getRelationStatusService($sr[$i], 'off');
                    if ($rel > 0) {
                        $this->server['HomeStatusServiceError'] = +$rel;
                        $this->server['status'] = 'yellow';
                    }
                    $this->server['relations'][$i] = parent::getService($sr[$i]);
                }
            }
        }


        // Anzahl der Sservice die überwacht werden addieren
        if (isset($this->server['relations']) && isset($this->server['services'])) {
            $this->server['anzahl_monitor'] = (count($this->server['services']) + count($this->server['relations']));
        } elseif (isset($this->server['services'])) {
            $this->server['anzahl_monitor'] = count($this->server['services']);
        } elseif (isset($this->server['relations'])) {
            $this->server['anzahl_monitor'] = count($this->server['relations']);
        } else {
            $this->server['anzahl_monitor'] = 0;
        }

        // Falls sich das System im Wartungsmodus befindet
        if ($this->server['wartung'] == 1) {
            $this->server['status'] = 'blue';
            $this->server['status_title'] = 'System befindet sich in Wartung';
        }

        $_SESSION['live_dns'] = $this->server['live_dns'];

        if ($this->server['HomeStatusServiceError'] > 0) {
            $this->server['progress'] = round((100 - ($this->server['HomeStatusServiceError'] * (100 / $this->server['anzahl_monitor']))), 0);
        } else {
            $this->server['progress'] = 100;
        }

        $this->server['aktive_monitor_service'] = ($this->server['anzahl_monitor'] - $this->server['HomeStatusServiceError']);

        if ($return === True) {
            return $this->server;
        }
    }

    /**
     * Methode zum auslesen der selbstkonfigurierten Detailfelder
     * @param type $systemid
     * @return type
     */
    public function getSystemDetails($systemid)
    {
        $db = new Database('SMT-ADMIN');
        $db->getQuery("SELECT * FROM wos_system_details WHERE systemid=:systemid", array(':systemid' => $systemid));

        return $db->getValue();
    }

    /**
     * Getter der Ports zu einer IP Adresse
     * @param type $ip
     */
    public function getPorts($ip)
    {
        $db = new Database('SMT-ADMIN');
        $db->getQuery("SELECT * FROM wos_server_ports WHERE ipadresse=:ipadresse", array(':ipadresse' => $ip));

        return $db->getValue();
    }

    /**
     * Neues System speichern
     * @param type $post
     * @return type
     */
    public function saveSystem($post)
    {
        $db = new Database('SMT-ADMIN');

        $query = "INSERT INTO wos_server (bezeichnung,serverart) VALUE (:bezeichnung, :serverart)";
        $value = array(':bezeichnung' => $post['bezeichnung'], 'serverart' => $this->serverart);

        $db->getQuery($query, $value);
        $id = $db->getLastID();

        $this->updateSystem($id, $post);
        return $id;
    }

    /**
     * Methode zum updaten eines Systems
     * @param type $serverid
     * @param type $post
     */
    public function updateSystem($serverid, $post)
    {
        $db = new Database('SMT-ADMIN');

        foreach ($post as $key => $value) {
            if (!preg_match('/detail_/', $key)) {
                $query = "UPDATE wos_server SET $key=:value WHERE id=:id";
                $value = array(':value' => $value, ':id' => $serverid);

                $db->getQuery($query, $value);
            }
        }

        if (isset($post['detail_name'])) {
            // Vorhandene Werte löschen und dann neu schreiben
            $db->getQuery("DELETE FROM wos_system_details WHERE systemid=:id", array(':id' => $serverid));

            $detail_name = $post['detail_name'];
            $detail_value = $post['detail_value'];

            for ($i = 0; $i < count($detail_name); $i++) {
                $query = "INSERT INTO wos_system_details (systemid, form_name, form_value) VALUE (:id, :name, :value)";
                $value = array(':name' => $detail_name[$i], ':value' => $detail_value[$i], ':id' => $serverid);

                if (!empty($detail_name[$i]) && !empty($detail_value[$i])) {
                    $db->getQuery($query, $value);
                }
            }
        }
    }

    /**
     * Methode zum updaten eines Systems
     * @param type $serverid
     * @param type $post
     */
    public function updateRelationSystem($post)
    {
        $db = new Database('SMT-ADMIN');
        $id = $post['home_system'];
        $rel = implode(",", $post['service_relations']);

        if (!empty($rel)) {
            // Vorhandene Relationen auselesen und zwischenspeichern
            $relations = $db->getQuery("SELECT service_relations FROM wos_server WHERE id=:id", array(':id' => $id), True);
            $relations = $relations['0']['service_relations'];

            // Relationen erweitern
            if (!empty($relations)) {
                $relations .= ',' . $rel;
            } else {
                $relations .= $rel;
            }

            $query = "UPDATE wos_server SET service_relations=:value WHERE id=:id";
            $value = array(':value' => $relations, ':id' => $id);

            $db->getQuery($query, $value);
        }
        return $id;
    }

    /**
     * Eine einzelne Relation löschen
     * @param type $sid
     * @param type $rid
     */
    public function deleteSingleRelation($sid, $rid)
    {
        $db = new Database('SMT-ADMIN');

        $query = "SELECT service_relations FROM wos_server WHERE id=:id";
        $db->getQuery($query, array(':id' => $sid));
        $relationen = explode(',', $db->getValue('service_relations', 0));

        for ($i = 0; $i < count($relationen); $i++) {
            if ($relationen[$i] == $rid) {
                unset($relationen[$i]);
            }
        }

        $relationen = implode(",", array_values($relationen));
        $query = "UPDATE wos_server SET service_relations=:service_relations WHERE id=:id";

        $db->getQuery($query, array(':id' => $sid, ':service_relations' => $relationen));
    }

    /**
     * Funktion zum vollständigen löschen eines
     * Systems mit allen Logs / Services etc
     * @param type $iId
     */
    public function deleteSystem($iId)
    {
        $db = new Database('SMT-MONITOR');

        // Server ID auslesen
        $query = "SELECT * FROM psm_servers WHERE home_system=:id";
        $db->getQuery($query, array(':id' => $iId));

        for ($i = 0; $i < $db->getNumrows(); $i++) {
            parent::deleteAllServices($db->getValue('server_id', $i));
        }

        $db = new Database('SMT-ADMIN');
        $query = "DELETE FROM wos_server WHERE id=:id";
        $db->getQuery($query, array(':id' => $iId));

        $query = "DELETE FROM wos_system_details WHERE id=:id";
        $db->getQuery($query, array(':id' => $iId));

        $db = new Database('SMT-USER');
        $query = "DELETE FROM db_user_favorite WHERE server_id=:id";
        $db->getQuery($query, array(':id' => $iId));
    }

    /**
     * Methode CheckDNS
     * Funktion zum prüfen des DNS im Unternehmen, trägt falsche Daten in die DB ein
     * @param type $ip
     * @param type $system
     * @param type $cron
     */
    public function checkDNS($ip, $system, $cron = False)
    {
        $db = new Database('SMT-ADMIN');

        $system['hostname'] = strtolower($system['hostname']);
        $system['alias'] = explode(',', $system['aliase']);
        $result['ip'] = $ip;
        $result['fehler'] = False;
        $result['meldung'] = '';
        $ipliste = $ip;
        $hostip = gethostbynamel($system['hostname']);

        if (!is_array($hostip)) {
            $result['fehler'] = True;
            $result['meldung'] = 'ERR: Kein System mit dem Namen <b class="text-red">"' . $system['hostname'] . '"</b> im DNS gefunden';
        }

        if (is_array($hostip) && count($hostip) > 0) {#
            $ipliste = implode(' oder ', $hostip);
            if (!in_array($ip, $hostip)) {
                $result['fehler'] = True;
                $result['meldung'] = 'ERR: Kein System mit dem Namen <b class="text-red">"' . $system['hostname'] . '"</b> im DNS gefunden';
            }
        }

        if (!empty($system['aliase']) && is_array($system['alias']) && count($system['alias']) > 0) {
            for ($i = 0; $i < count($system['alias']); $i++) {
                $aliasip = gethostbynamel(trim($system['alias'][$i]));
                if (!is_array($aliasip) || !in_array($ip, $aliasip)) {
                    $result['fehler'] = True;
                    $result['meldung'] = 'ERR: Der Alias <b class="text-red">"' . $system['alias'][$i] . '"</b> passt nicht zur IP Adresse ' . $ipliste . ' (Automatisch ermittelt)';
                }
            }
        }

        if ($cron === False) {
            $db->getQuery("DELETE FROM wos_dns_cron WHERE ipadresse=:ipadresse", array(':ipadresse' => $ip));
        }

        if ($result['fehler'] === True) {
            $query = "INSERT INTO wos_dns_cron (sid, ipadresse, hostname, serverart, meldung, fehler) VALUE (:sid, :ipadresse, :hostname, :serverart, :meldung, :fehler)";
            $value = array(':sid' => $system['id'], ':ipadresse' => $ip, ':hostname' => $system['hostname'], ':serverart' => $system['serverart'], ':meldung' => $result['meldung'], ':fehler' => $result['fehler']);
            $db->getQuery($query, $value);
        }

        if ($cron === False) {
            return $result;
        }
    }

    /**
     * Getter der DNS Fehler
     */
    public function getCronIPs()
    {
        $db = new Database('SMT-ADMIN');
        $db->getQuery("SELECT * FROM wos_dns_cron ORDER BY INET_ATON(ipadresse)", array());

        $result = $db->getValue();
        return $result;
    }

    /**
     * Methode zum setzen des Wartungsmodus
     * @param type $id
     * @param type $status
     */
    public function updateWartung($id, $status)
    {
        $db = new Database('SMT-ADMIN');

        if ($status == 'on') {
            $ns = 1;
        }
        if ($status == 'off') {
            $ns = 0;
        }

        $query = "UPDATE wos_server SET wartung=:wartung WHERE id=:id";
        $db->getQuery($query, array(':id' => $id, ':wartung' => $ns));
    }

    /**
     * Methode zum setzen des Monitors
     * @param type $id
     * @param type $status
     */
    public function updateMonitor($id, $status)
    {
        $db = new Database('SMT-ADMIN');

        if ($status == 'on') {
            $ns = 1;
        }
        if ($status == 'off') {
            $ns = 0;
        }

        $query = "UPDATE wos_server SET monitor=:monitor WHERE id=:id";
        $db->getQuery($query, array(':id' => $id, ':monitor' => $ns));
    }


    public function saveMultipleServices($post, $sys)  {
        $db = new Database('SMT-ADMIN');
        $service = $post['service'];

        $value['user'] = $_SESSION['username'];
        $value['home_system'] = $sys;
        $value['type'] = 'service';

        for($i=0; $i<count($service); $i++) {
            $db->getQuery("SELECT * FROM wos_server_ports WHERE id=:id", array(':id' => $service[$i]));
            $value['ip'] = $db->getValue('ipadresse');
            $value['port'] = $db->getValue('port');
            $value['label'] = $db->getValue('bezeichnung');

            parent::saveService($value);
        }
    }

}

?>
