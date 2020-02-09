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

class HistoryGraph
{
    /**
     * Prepare the HTML for the graph
     * @return string
     * @throws Exception
     */
    public function createHTML($server_id)
    {
        $now = new DateTime();
        $last_day = new DateTime('-1 day 0:0:0');
        $last_week = new DateTime('-1 week 0:0:0');
        $last_month = new DateTime('-1 month 0:0:0');

        $graphs = array(
            0 => $this->getRecords('uptime', $server_id, $last_day, $now),
            1 => $this->getRecords('uptime', $server_id, $last_week, $now),
            2 => $this->getRecords('history', $server_id, $last_month, $now)
        );

        return $graphs;
    }


    /**
     * Get all uptime/history records for a server
     * @param string $type
     * @param int $server_id
     * @param \DateTime $start_time Lowest DateTime of the graph
     * @param \DateTime $end_time Highest DateTime of the graph
     * @return array
     */
    protected function getRecords($type, $server_id, $start_time, $end_time)
    {
        $db = new Database('SMT-MONITOR');

        if (!in_array($type, array('history', 'uptime'))) {
            return array();
        }

        $records = $db->getQuery(
            "SELECT *
				FROM `psm_servers_$type`
				WHERE `server_id` = :server_id 
        AND `date` BETWEEN :start_time AND :end_time 
        ORDER BY `date` ASC", array(
            'server_id' => $server_id,
            'start_time' => $start_time->format('Y-m-d H:i:s'),
            'end_time' => $end_time->format('Y-m-d H:i:s'),
        ), True);

        return $records;
    }

}