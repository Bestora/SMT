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

class Updater
{

    public $error = '';
    public $rtime = 0;
    public $status_new = false;
    public $CURL_TIMEOUT = 10;
    protected $server_id;
    protected $server;

    /**
     * Check the current services
     * @param int $server_id
     * @param int $max_runs
     */
    public function update($server_id, $max_runs = 3)
    {

        $wos = new Service;
        $not = new Notifier();

        $this->server_id = $server_id;
        $this->error = '';
        $this->rtime = '';
        $this->status = '';
        $this->server = $wos->getServiceDetail($this->server_id, False, False);

        if ($this->server['active'] == 'yes') {

            if ($this->server['type'] == 'service') {
                $this->status_new = $this->updateService($max_runs);
            }
            if ($this->server['type'] == 'website') {
                $this->status_new = $this->updateWebsite($max_runs);
            }
            if ($this->server['type'] == 'reminder') {
                $this->status_new = $this->updateReminder($this->server['end_date'], $this->server['warn_date'], $this->server['isWarning']);
            }

            $save = array(
                'last_check' => date('Y-m-d H:i:s'),
                'error' => $this->error,
                'rtime' => $this->rtime,
            );

            $this->log_uptime($this->server_id, (int)$this->status_new, $this->rtime);
            $db = new Database('SMT-MONITOR');

            if ($this->status_new === True && $this->server['status'] == 'off') {
                $status = 'on';

                $query = "UPDATE psm_servers SET status=:status, last_check=:last_check, last_online=:last_online, rtime=:rtime WHERE server_id=:server_id";
                $value = array(':status' => $status, ':last_check' => date('Y-m-d H:i:s'), ':last_online' => date('Y-m-d H:i:s'), ':rtime' => $save['rtime'], ':server_id' => $this->server_id);
            }

            if ($this->server['status'] == 'off' && !isset($status)) {
                $query = "UPDATE psm_servers SET last_check=:last_check WHERE server_id=:server_id";
                $value = array(':last_check' => date('Y-m-d H:i:s'), ':server_id' => $this->server_id);
            }

            if ($this->status_new === False && $this->server['status'] == 'on') {
                $status = 'off';

                $query = "UPDATE psm_servers SET status=:status, last_check=:last_check WHERE server_id=:server_id";
                $value = array(':status' => $status, ':last_check' => date('Y-m-d H:i:s'), ':server_id' => $this->server_id);
            }

            if ($this->server['status'] == 'on' && !isset($status)) {
                $query = "UPDATE psm_servers SET last_check=:last_check, last_online=:last_online, rtime=:rtime WHERE server_id=:server_id";
                $value = array(':last_check' => date('Y-m-d H:i:s'), ':last_online' => date('Y-m-d H:i:s'), ':rtime' => $save['rtime'], ':server_id' => $this->server_id);
            }

            if (isset($status)) {
                $not->notify($this->server_id, $this->server['status'], $status);
                $not->add_log($this->server_id, 'updater', $not->parse_msg($status, 'email_subject', $this->server), 'sys');
            }

            $db->getQuery($query, $value);
        }
    }

    /**
     * Check the current server as a service
     * @param int $max_runs
     * @param int $run
     * @return boolean
     */
    protected function updateService($max_runs, $run = 1)
    {
        $errno = 0;
        $starttime = microtime(true);

        $fp = @fsockopen($this->server['ip'], $this->server['port'], $errno, $this->error, 5);

        $status = ($fp === false) ? false : true;
        $this->rtime = (microtime(true) - $starttime);

        if (is_resource($fp)) {
            fclose($fp);
        }

        if (!$status && $run < $max_runs) {
            return $this->updateService($max_runs, $run + 1);
        }

        return $status;
    }

    /**
     * Check the current server as a website
     * @param int $max_runs
     * @param int $run
     * @return boolean
     */
    protected function updateWebsite($max_runs, $run = 1)
    {
        $starttime = microtime(true);

        $curl_result = $this->curl_get($this->server['ip'], true, ($this->server['pattern'] == '' ? false : true), 20);
        $this->rtime = (microtime(true) - $starttime);

        $status_code = strtok($curl_result, "\r\n");
        $code_matches = array();

        preg_match_all("/[A-Z]{2,5}\/\d\.\d\s(\d{3})\s(.*)/", $status_code, $code_matches);

        if (empty($code_matches[0])) {
            $this->error = 'no response from server';
            $result = false;
        } else {
            $code = $code_matches[1][0];
            $msg = $code_matches[2][0];

            if (substr($code, 0, 1) >= '4') {
                $this->error = $code . ' ' . $msg;
                $result = false;
            } else {
                $result = true;
            }
        }

        if ($this->server['pattern'] != '') {
            if (!preg_match("/{$this->server['pattern']}/i", $curl_result)) {
                $this->error = 'Pattern not found.';
                $result = false;
            }
        }

        if ($run < $max_runs) {
            return $this->updateWebsite($max_runs, $run + 1);
        }

        return $result;
    }

    public function curl_get($href, $header = false, $body = true, $timeout = null)
    {
        $timeout = $timeout === null ? $this->CURL_TIMEOUT : intval($timeout);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, "_SMT_");
        curl_setopt($ch, CURLOPT_HEADER, $header);
        curl_setopt($ch, CURLOPT_NOBODY, (!$body));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_URL, $href);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * Check the current server as a reminder
     * @param int $end_date
     * @param int $warn_date
     * @param int $isWarning
     * @return boolean
     */
    protected function updateReminder($end_date, $warn_date, $isWarning)
    {
        $db = new Database('SMT-MONITOR');
        $notifier = new Notifier();

        if (date('Y-m-d') == $warn_date && $isWarning == NULL) {
            $query = "UPDATE psm_servers SET status=:status, last_check=:last_check, isWarning=:isWarning WHERE server_id=:server_id";
            $db->getQuery($query, array(':status' => 'warn', ':last_check' => date('Y-m-d H:i:s'), ':isWarning' => 1, ':server_id' => $this->server_id));

            $notifier->notify($this->server_id, 'on', 'warn');
        } elseif (date('Y-m-d') == $end_date && $isWarning == '1') {
            $query = "UPDATE psm_servers SET isWarning=:isWarning WHERE server_id=:server_id";
            $db->getQuery($query, array(':isWarning' => 2, ':server_id' => $this->server_id));

            return false;
        } else {
            $query = "UPDATE psm_servers SET last_check=:last_check, last_online=:last_online WHERE server_id=:server_id";
            $db->getQuery($query, array(':last_check' => date('Y-m-d H:i:s'), ':last_online' => date('Y-m-d H:i:s'), ':server_id' => $this->server_id));
        }
    }

    public function log_uptime($server_id, $status, $latency)
    {
        $db = new Database('SMT-MONITOR');

        $query = "INSERT INTO psm_servers_uptime (date, status, latency, server_id) VALUES (:date, :status, :latency, :server_id)";
        $db->getQuery($query, array(':date' => date('Y-m-d H:i:s'), ':status' => $status, ':latency' => $latency, ':server_id' => $server_id));
    }

}
