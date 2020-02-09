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

class Infrastruktur
{

    /**
     * Methode zum generieren der Statistik
     * @return array
     */
    public function getStatistik()
    {
        $sys = array();

        $sys['systeme'] = $this->getServer();
        $sys['service'] = $this->getService();
        $sys['ticket'] = $this->getTicket();
        $sys['license'] = $this->getLizenz();
        $sys['hardware'] = $this->getHardware();

        return $sys;
    }

    /**
     * Serverdaten sammeln unzurückgeben
     */
    public function getServer()
    {
        $sys = array();
        $db = new Database('SMT-ADMIN');

        $tmp = $db->getQuery("SELECT count(id) FROM wos_server", array(), True, False);
        $sys['all'] = $tmp['0']['count(id)'];

        $tmp = $db->getQuery("SELECT count(id) FROM wos_server WHERE serverart=:serverart", array(':serverart' => 'server'), True, False);
        $sys['server'] = $tmp['0']['count(id)'];

        if ($tmp['0']['count(id)'] > 0) {
            $sys['server_prozent'] = round(($tmp['0']['count(id)'] * (100 / $sys['all'])), 2);
        } else {
            $sys['server_prozenz'] = 0;
        }

        $tmp = $db->getQuery("SELECT count(id) FROM wos_server WHERE serverart=:serverart", array(':serverart' => 'vmware'), True, False);
        $sys['vmware'] = $tmp['0']['count(id)'];

        if ($tmp['0']['count(id)'] > 0) {
            $sys['vmware_prozent'] = round(($tmp['0']['count(id)'] * (100 / $sys['all'])), 2);
        } else {
            $sys['vmware_prozent'] = 0;
        }

        $tmp = $db->getQuery("SELECT count(id) FROM wos_server WHERE wartung=:wartung", array(':wartung' => 1), True, False);
        $sys['wartung'] = $tmp['0']['count(id)'];

        if ($tmp['0']['count(id)'] > 0) {
            $sys['wartung_prozent'] = round(($tmp['0']['count(id)'] * (100 / $sys['all'])), 2);
        } else {
            $sys['wartung_prozent'] = 0;
        }

        return $sys;
    }

    /**
     * Servicedaten sammeln unzurückgeben
     */
    public function getService()
    {
        $sys = array();
        $db = new Database('SMT-MONITOR');

        $tmp = $db->getQuery("SELECT count(server_id) FROM psm_servers", array(), True, False);
        $sys['all'] = $tmp['0']['count(server_id)'];

        $tmp = $db->getQuery("SELECT count(server_id) FROM psm_servers WHERE status=:status", array(':status' => 'on'), True, False);
        $sys['on'] = $tmp['0']['count(server_id)'];

        if ($tmp['0']['count(server_id)'] > 0) {
            $sys['on_prozent'] = round(($sys['on'] * (100 / $sys['all'])), 2);
        } else {
            $sys['on_prozent'] = 0;
        }

        $tmp = $db->getQuery("SELECT count(server_id) FROM psm_servers WHERE status=:status", array(':status' => 'off'), True, False);
        $sys['off'] = $tmp['0']['count(server_id)'];

        if ($tmp['0']['count(server_id)'] > 0) {
            $sys['off_prozent'] = round(($sys['off'] * (100 / $sys['all'])), 2);
        } else {
            $sys['off_prozent'] = 0;
        }

        $tmp = $db->getQuery("SELECT count(server_id) FROM psm_servers WHERE type=:type", array(':type' => 'service'), True, False);
        $sys['service'] = $tmp['0']['count(server_id)'];

        if ($tmp['0']['count(server_id)'] > 0) {
            $sys['service_prozent'] = round(($sys['service'] * (100 / $sys['all'])), 2);
        } else {
            $sys['service_prozent'] = 0;
        }

        $tmp = $db->getQuery("SELECT count(server_id) FROM psm_servers WHERE type=:type", array(':type' => 'website'), True, False);
        $sys['website'] = $tmp['0']['count(server_id)'];

        if ($tmp['0']['count(server_id)'] > 0) {
            $sys['website_prozent'] = round(($sys['website'] * (100 / $sys['all'])), 2);
        } else {
            $sys['website_prozent'] = 0;
        }

        $tmp = $db->getQuery("SELECT count(server_id) FROM psm_servers WHERE type=:type", array(':type' => 'reminder'), True, False);
        $sys['reminder'] = $tmp['0']['count(server_id)'];

        if ($tmp['0']['count(server_id)'] > 0) {
            $sys['reminder_prozent'] = round(($sys['reminder'] * (100 / $sys['all'])), 2);
        } else {
            $sys['reminder_prozent'] = 0;
        }
        return $sys;
    }


    /**
     * Ticketdaten sammeln unzurückgeben
     */
    public function getTicket()
    {
        $sys = array();
        $db = new Database('SMT-ADMIN');

        $tmp = $db->getQuery("SELECT count(id) FROM wos_ticket", array(), True, False);
        $sys['all'] = $tmp['0']['count(id)'];

        $tmp = $db->getQuery("SELECT count(id) FROM wos_ticket WHERE user=:user", array(':user' => Session::get('username')), True, False);
        $sys['user'] = $tmp['0']['count(id)'];

        if ($tmp['0']['count(id)'] > 0) {
            $sys['user_prozent'] = round(($tmp['0']['count(id)'] * (100 / $sys['all'])), 2);
        } else {
            $sys['user_prozent'] = 0;
        }

        $tmp = $db->getQuery("SELECT count(id) FROM wos_ticket WHERE zuordnung=:zuordnung", array(':zuordnung' => Session::get('username')), True, False);
        $sys['zuordnung'] = $tmp['0']['count(id)'];

        if ($tmp['0']['count(id)'] > 0) {
            $sys['zuordnung_prozent'] = round(($tmp['0']['count(id)'] * (100 / $sys['all'])), 2);
        } else {
            $sys['zuordnung_prozent'] = 0;
        }

        return $sys;
    }


    /**
     * Lizenzdaten sammeln unzurückgeben
     */
    public function getLizenz()
    {
        $sys = array();
        $db = new Database('SMT-ADMIN');

        $tmp = $db->getQuery("SELECT count(id) FROM wos_license", array(), True, False);
        $sys['all'] = $tmp['0']['count(id)'];

        $tmp = $db->getQuery("SELECT count(id) FROM wos_license WHERE zuordnung=:zuordnung|| zuordnung=:frei", array(':zuordnung' => 'frei', ':frei' => ''), True, False);
        $sys['frei'] = $tmp['0']['count(id)'];

        if ($tmp['0']['count(id)'] > 0) {
            $sys['frei_prozent'] = round(($tmp['0']['count(id)'] * (100 / $sys['all'])), 2);
        } else {
            $sys['frei_prozent'] = 0;
        }

        $tmp = $db->getQuery("SELECT id,hersteller,produkt,version,count(id) FROM `wos_license` WHERE zuordnung=:zuordnung || zuordnung=:frei GROUP BY hersteller,produkt,version", array(':zuordnung' => 'frei', ':frei' => ''), True, False);
        $sys['liste'] = $tmp;

        return $sys;
    }


    /**
     * Hardware sammeln unzurückgeben
     */
    public function getHardware()
    {
        $sys = array();
        $db = new Database('SMT-ADMIN');

        $tmp = $db->getQuery("SELECT count(id) FROM wos_hardware", array(), True, False);
        $sys['all'] = $tmp['0']['count(id)'];

        $tmp = $db->getQuery("SELECT count(id) FROM wos_hardware WHERE zuordnung=:zuordnung|| zuordnung=:frei", array(':zuordnung' => 'frei', ':frei' => ''), True, False);
        $sys['frei'] = $tmp['0']['count(id)'];

        if ($tmp['0']['count(id)'] > 0) {
            $sys['frei_prozent'] = round(($tmp['0']['count(id)'] * (100 / $sys['all'])), 2);
        } else {
            $sys['frei_prozent'] = 0;
        }

        $tmp = $db->getQuery("SELECT id,hersteller,modell,count(id) FROM wos_hardware WHERE zuordnung=:zuordnung|| zuordnung=:frei GROUP BY hersteller,modell", array(':zuordnung' => 'frei', ':frei' => ''), True, False);
        $sys['liste'] = $tmp;

        $tmp = $db->getQuery("SELECT kategorie FROM wos_hardware GROUP BY kategorie", array(), True, False);
        for ($i = 0; $i < count($tmp); $i++) {
            $ha = $db->getQuery("SELECT kategorie,count(id) FROM wos_hardware WHERE kategorie=:kategorie", array(':kategorie' => $tmp[$i]['kategorie']), True, False);
            $sys['kategorie'][$i]['kategorie_bezeichnung'] = texte::getText($ha['0']['kategorie']);
            $sys['kategorie'][$i]['kategorie_anzahl'] = $ha['0']['count(id)'];

            if ($ha['0']['count(id)'] > 0) {
                $sys['kategorie'][$i]['prozent'] = round(($ha['0']['count(id)'] * (100 / $sys['all'])), 2);
            } else {
                $sys['kategorie'][$i]['prozent'] = 0;
            }
        }
        return $sys;
    }
}