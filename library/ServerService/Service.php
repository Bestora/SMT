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

class Service
{

    /**
     * Methode zum auslesen eines Services / Dienstes
     * @param type $server_id
     * @return type
     * @throws Exception
     */
    public function getService($server_id)
    {

        $db = new Database('SMT-MONITOR');
        $time = new Time();

        $result = $db->getQuery("SELECT * FROM psm_servers WHERE server_id=:server_id", array(':server_id' => $server_id), True);

        if ($db->getNumrows() == 1) {
            $result['0']['last_online'] = $time->ago(new DateTime(date($result['0']['last_online'])));
            $result['0']['last_check'] = $time->ago(new DateTime(date($result['0']['last_check'])));

            return $result['0'];
        }
    }

    public function getLogDate($start, $end)
    {
        $db = new Database('SMT-MONITOR');

        $query = "SELECT * FROM psm_log WHERE datetime BETWEEN :start AND :ende AND user_id=:user_id";
        $value = array(':start' => $start . ' 00:00:00', ':ende' => $end . ' 23:59:59', ':user_id' => 'sys');

        $data['result'] = $db->getQuery($query, $value, True);
        $data['number'] = $db->getNumrows();

        return $data;
    }

    /**
     * Methode zum auslesen aller Services eines bestimmten Systems
     *
     * @param $prio
     * @return array
     */
    public function getAllUpdateService($prio)
    {
        $db = new Database('SMT-ADMIN');

        $newprio = ($prio + 1);
        $server = $db->getQuery("SELECT id,prio,wartung FROM wos_server WHERE prio=:prio && monitor=:monitor", array(':prio' => 3, ':monitor' => 1), True);

        if ($prio == 5) {
            $server = $db->getQuery("SELECT id,prio,wartung FROM wos_server WHERE prio=:prio_3 && monitor=:monitor || prio=:prio_2 && monitor=:monitor", array(':prio_3' => 3, ':prio_2' => 2, ':monitor' => 1), True);
        }

        if ($prio == 10) {
            $server = $db->getQuery("SELECT id,prio,wartung FROM wos_server WHERE prio=:prio_3 && monitor=:monitor || prio=:prio_2 && monitor=:monitor || prio=:prio_1 && monitor=:monitor", array(':prio_3' => 3, ':prio_2' => 2, ':prio_1' => 1, ':monitor' => 1), True);
        }

        if ($prio == 15) {
            $server = $db->getQuery("SELECT id,prio,wartung,monitor FROM wos_server WHERE monitor=:monitor", array(':monitor' => 1), True);
            $newprio = 0;
        }

        $db = new Database('SMT-MONITOR');
        for ($i = 0; $i < count($server); $i++) {
            if ($server[$i]['wartung'] == 0) {
                $result[] = $db->getQuery("SELECT server_id, type, home_system FROM psm_servers WHERE active=:active && home_system=:home_system", array(':active' => 'yes', ':home_system' => $server[$i]['id']), True);
            }
        }

        $db = new Database('SMT-MONITOR');

        if ($newprio == 0) {
            $db->getQuery("TRUNCATE TABLE `psm_last_update`", array());
        }

        $db->getQuery("INSERT INTO psm_last_update (last_update,counter,updatet) VALUES (:last_update,:counter,:updatet)", array(':last_update' => date('Y-m-d H:i:s'), ':counter' => $newprio, ':updatet' => count($result)));

        return $result;
    }

    /**
     * Methode zum auslesen aller Services eines bestimmten Systems
     *
     * @param type $iId
     * @return Exception
     * @throws Exception
     */
    public function getAllSystemService($iId)
    {
        $db = new Database('SMT-MONITOR');
        $result = $db->getQuery("SELECT server_id FROM psm_servers WHERE home_system=:iId ORDER BY label", array(':iId' => $iId), True);

        for ($i = 0; $i < count($result); $i++) {
            $result[$i] = $this->getServiceDetail($result[$i]['server_id']);
        }

        return $result;
    }

    /**
     * Alle Details zu einem Service auslesen
     * @param type $server_id
     * @param bool $wLog
     * @param bool $wUptime
     * @return type
     * @throws Exception
     */
    public function getServiceDetail($server_id, $wLog = False, $wUptime = False)
    {

        $db = new Database('SMT-MONITOR');
        $time = new Time();

        $result = $db->getQuery("SELECT * FROM psm_servers WHERE server_id=:server_id", array(':server_id' => $server_id), True);
        $result = $result['0'];

        $result['last_online'] = $time->ago(new DateTime(date($result['last_online'])));
        $result['last_check'] = $time->ago(new DateTime(date($result['last_check'])));

        if ($wLog === True) {
            $result['log'] = $this->getLog($server_id);
        }

        if ($wUptime === True) {
            $result['uptime'] = $this->getUptime($server_id);
        }

        return $result;
    }

    /**
     * Alle Logfiles zu einem Service auslesen
     * @param string $server_id
     * @return Exception
     */
    public function getLog($server_id = '')
    {
        $db = new Database('SMT-MONITOR');

        if (!empty($server_id)) {
            $result = $db->getQuery("SELECT *,DATE_FORMAT(datetime,'%d.%m.%Y %H:%i') AS niceDatum FROM psm_log WHERE server_id=:server_id && user_id=:user_id ORDER BY datetime DESC", array(':server_id' => $server_id, ':user_id' => 'sys'), True, False);
        } else {
            $result = $db->getQuery("SELECT *,DATE_FORMAT(datetime,'%d.%m.%Y %H:%i') AS niceDatum FROM psm_log WHERE user_id=:user_id ORDER BY datetime DESC", array(':user_id' => 'sys'), True, False);
        }

        for ($i = 0; $i < count($result); $i++) {
            $d = explode('<br/>', $result[$i]['message']);
            $result[$i]['message'] = $d['0'];
            $result[$i]['message'] = str_replace("seite '", 'seite \'<a href="/monitor/detail/' . $result[$i]['server_id'] . '">', $result[$i]['message']);
            $result[$i]['message'] = str_replace("' ist", "</a>' ist", $result[$i]['message']);
        }

        return $result;
    }

    /**
     * Alle Uptime Daten zu einem Service auslesen
     * @param type $server_id
     * @return Exception
     */
    public function getUptime($server_id)
    {
        $db = new Database('SMT-MONITOR');
        return $db->getQuery("SELECT * FROM psm_servers_uptime WHERE server_id=:server_id", array(':server_id' => $server_id), True);
    }

    /**
     * Methode zum auslesen aller Services eines bestimmten Systems
     *
     * @return type
     */
    public function getAllService()
    {
        $db = new Database('SMT-MONITOR');
        $db->getQuery("SELECT *,DATE_FORMAT(last_online,'%d.%m.%Y %H:%i') AS niceDatum FROM psm_servers ORDER BY label", array());


        return $db->getValue();
    }

    /**
     * Methode zum prüfen ob es Services mit einem bestimmten Status gibt
     *
     * @param type $iId
     * @param string $sStatus
     * @return type
     */
    public function getHomeStatusService($iId, $sStatus = '')
    {
        $db = new Database('SMT-MONITOR');

        if (!empty($sStatus)) {
            $db->getQuery("SELECT * FROM psm_servers WHERE home_system=:iId && status=:status && active=:active", array(':iId' => $iId, ':status' => $sStatus, ':active' => 'yes'));
        } else {
            $db->getQuery("SELECT * FROM psm_servers WHERE home_system=:iId && active=:active", array(':iId' => $iId, ':active' => 'yes'));
        }

        return $db->getNumrows();
    }

    /**
     * Methode zum prüfen ob es Services mit einem bestimmten Status gibt
     *
     * @param type $iId
     * @return type
     */
    public function getHomeMonitorService($iId)
    {
        $db = new Database('SMT-MONITOR');

        $query = "SELECT * FROM psm_servers WHERE home_system=:iId && active=:active && status=:status && email=:email && pushover=:pushover";
        $value = array(':iId' => $iId, ':active' => 'yes', ':status' => 'off', ':email' => 'no', ':pushover' => 'no');

        $db->getQuery($query, $value);

        return $db->getNumrows();
    }

    /**
     * Methode zum prüfen ob es Services mit einem bestimmten Status gibt
     *
     * @param type $iId
     * @param $sStatus
     * @return type
     */
    public function getRelationStatusService($iId, $sStatus)
    {
        $db = new Database('SMT-MONITOR');
        $db->getQuery("SELECT * FROM psm_servers WHERE server_id=:iId && status=:status", array(':iId' => $iId, ':status' => $sStatus));

        return $db->getNumrows();
    }

    /**
     * Löschen eines Services
     * @param type $server_id
     */
    public function deleteAllServices($server_id)
    {
        $db = new Database('SMT-MONITOR');

        $query = "DELETE FROM psm_servers WHERE server_id=:server_id";
        $db->getQuery($query, array(':server_id' => $server_id));

        $query = "DELETE FROM psm_servers_uptime WHERE server_id=:server_id";
        $db->getQuery($query, array(':server_id' => $server_id));

        $query = "DELETE FROM psm_log WHERE server_id=:server_id";
        $db->getQuery($query, array(':server_id' => $server_id));

        $query = "DELETE FROM psm_servers_history WHERE server_id=:server_id";
        $db->getQuery($query, array(':server_id' => $server_id));
    }

    /**
     * Methode zum speichern von Services
     * @param type $post
     * @return type
     */
    public function saveService($post)
    {
        $error = False;
        $db = new Database('SMT-MONITOR');
        $up = new Updater();
        $post['user'] = implode(',', $post['user']);
        /**
         * Prüfung auf System und Port
         */
        $db->getQuery("SELECT * FROM psm_servers WHERE home_system=:home_system && port=:port", array(':home_system' => $post['home_system'], ':port' => $post['port']));
        if ($db->getNumrows() > 0) {
            $error = True;
        }

        if (isset($post['home_system']) && $error === False) {
            $return = $post['home_system'];

            $query = "INSERT INTO psm_servers (home_system) VALUE (:home_system)";
            $value = array(':home_system' => $post['home_system']);

            $db->getQuery($query, $value);
            $id = $db->getLastID();
        } else {
            $return = $post['return'];
            $id = $post['server_id'];
        }

        if ($error === False) {
            $this->updateService($id, $post);
            $up->update($id);
        }

        return $return;
    }

    public function updateService($id, $post)
    {
        $db = new Database('SMT-MONITOR');

        foreach ($post as $key => $value) {
            if ($key != 'home_system') {
                $query = "UPDATE psm_servers SET $key=:value WHERE server_id=:id";
                $value = array(':value' => $value, ':id' => $id);

                $db->getQuery($query, $value);
            }
        }

        if ($post['type'] == 'reminder') {
            $db->getQuery("UPDATE psm_servers SET status=:status, isWarning=:isWarning WHERE server_id=:server_id", array(':status' => 'on', ':isWarning' => NULL, ':server_id' => $id));
        }
    }

    public function clearLogfile()
    {
        $db = new Database('SMT-MONITOR');
        $db->getQuery("TRUNCATE psm_log", array(), True);
    }

}