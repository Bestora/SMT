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
 * @author      Werner Pallentin <werner.pallentin@outlook.de>
 * @copyright   Copyright (c) Werner Pallentin <werner.pallentin@outlook.de>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: v2.1
 * @link        http://palle.zapto.org/
 **/

class HistoryGraph
{

  /**
   * Prepare the HTML for the graph
   * @return string
   */
  public function createHTML($server_id)
  {
    $now = new DateTime();
    $last_week = new DateTime('-1 week 0:0:0');
    $last_year = new DateTime('-1 year -1 week 0:0:0');

    $graphs = array(
      0 => $this->generateGraphUptime($server_id, $last_week, $now),
      1 => $this->generateGraphHistory($server_id, $last_year, $last_week),
    );
    $info_fields = array(
      'latency_avg' => '%01.4f',
      'uptime' => '%01.3f%%',
    );

    foreach ($graphs as $i => &$graph) {
      $graph['info'] = array();

      foreach ($info_fields as $field => $format) {
        if (!isset($graph[$field])) {
          continue;
        }
        $graph['info'][] = array(
          'label' => 'Online',
          'value' => sprintf($format, $graph[$field]),
        );
      }
    }

    $tpl_data = array(
      'graphs' => $graphs,
      'label_server' => 'Server',
      'day_format' => '%d.%m.%Y',
      'long_date_format' => '%d.%m.%Y %H:%M:%S Uhr',
      'short_date_format' => '%d.%m %H:%M Uhr',
      'short_time_format' => '%H:%M Uhr',
    );

    return $tpl_data;
  }

  /**
   * Generate data for uptime graph
   * @param int $server_id
   * @param \DateTime $start_time Lowest DateTime of the graph
   * @param \DateTime $end_time Highest DateTime of the graph
   * @return array
   */
  public function generateGraphUptime($server_id, $start_time, $end_time)
  {
    $lines = array(
      'latency' => array(),
    );
    $cb_if_up = function ($uptime_record) {
      return ($uptime_record['status'] == 1);
    };
    $records = $this->getRecords('uptime', $server_id, $start_time, $end_time);

    $data = $this->generateGraphLines($records, $lines, $cb_if_up, 'latency', $start_time, $end_time, true);

    $data['title'] = 'Vergangene Woche';
    $data['plotmode'] = 'hour';
    $data['buttons'] = array();
    $data['buttons'][] = array('mode' => 'hour', 'label' => 'Stunde', 'class_active' => 'btn-info');
    $data['buttons'][] = array('mode' => 'day', 'label' => 'Tag');
    $data['buttons'][] = array('mode' => 'week', 'label' => 'Woche');
    $data['chart_id'] = $server_id . '_uptime';

    return $data;
  }

  /**
   * Generate data for history graph
   * @param int $server_id
   * @param \DateTime $start_time Lowest DateTime of the graph
   * @param \DateTime $end_time Highest DateTime of the graph
   * @return array
   */
  public function generateGraphHistory($server_id, $start_time, $end_time)
  {
    $db = new Database('SMT-MONITOR');

    $lines = array(
      'latency_avg' => array(),
      'latency_max' => array(),
      'latency_min' => array(),
    );
    $server = $db->selectRow('psm_servers', array('server_id' => $server_id), array('warning_threshold'));

    $cb_if_up = function ($uptime_record) use ($server) {
      return ($uptime_record['checks_failed'] < $server['warning_threshold']);
    };
    $records = $this->getRecords('history', $server_id, $start_time, $end_time);
    $data = $this->generateGraphLines($records, $lines, $cb_if_up, 'latency_avg', $start_time, $end_time, false);

    $data['title'] = 'Historie';
    $data['plotmode'] = 'month';
    $data['buttons'] = array();
    $data['buttons'][] = array('mode' => 'week2', 'label' => 'Woche');
    $data['buttons'][] = array('mode' => 'month', 'label' => 'Monat', 'class_active' => 'btn-info');
    $data['buttons'][] = array('mode' => 'year', 'label' => 'Jahr');
    $data['chart_id'] = $server_id . '_history';

    return $data;
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

  /**
   * Generate data arrays for graphs
   * @param array $records all uptime records to parse, MUST BE SORTED BY DATE IN ASCENDING ORDER
   * @param array $lines array with keys as line ids to prepare (key must be available in uptime records)
   * @param callable $cb_if_up function to check if the server is up or down
   * @param string $latency_avg_key which key from uptime records to use for calculating averages
   * @param \DateTime $start_time Lowest DateTime of the graph
   * @param \DateTime $end_time Highest DateTime of the graph
   * @param boolean $add_uptime add uptime calculation?
   * @return array
   */
  protected function generateGraphLines($records, $lines, $cb_if_up, $latency_avg_key, $start_time, $end_time, $add_uptime = false)
  {
    $data = array();

    $last_date = 0;
    $latency_avg = 0;
    $series = array();
    $time_down = 0;

    $down = array();

    foreach ($records as $uptime) {
      $time = strtotime($uptime['date']) * 1000;
      $latency_avg += (float)$uptime[$latency_avg_key];

      if ($cb_if_up($uptime)) {
        foreach ($lines as $key => $value) {
          if (isset($uptime[$key])) {
            $lines[$key][] = '[' . $time . ',' . round((float)$uptime[$key], 4) . ']';
          }
        }
        if ($last_date) {
          $down[] = '[' . $last_date . ',' . $time . ']';
          $time_down += ($time - $last_date);
          $last_date = 0;
        }
      } else {
        if (!$last_date) {
          $last_date = $time;
        }
      }
    }
    $lines_merged = array();

    foreach ($lines as $line_key => $line_value) {
      if (empty($line_value)) {
        continue;
      }
      $lines_merged[] = '[' . implode(',', $line_value) . ']';
      $series[] = "{label: 'Service'}";
    }
    if ($last_date) {
      $down[] = '[' . $last_date . ',0]';
      $time_down += (($end_time->getTimestamp() * 1000) - $last_date);
    }

    if ($add_uptime) {
      $data['uptime'] = 100 - (($time_down / ($end_time->getTimestamp() - $start_time->getTimestamp())) / 10);
    }

    $data['latency_avg'] = count($records) > 0 ? ($latency_avg / count($records)) : 0;
    $data['server_lines'] = sizeof($lines_merged) ? '[' . implode(',', $lines_merged) . ']' : '';
    $data['server_down'] = sizeof($down) ? '[' . implode(',', $down) . ']' : '';
    $data['series'] = sizeof($series) ? '[' . implode(',', $series) . ']' : '';
    $data['end_timestamp'] = $end_time->getTimestamp() * 1000;

    return $data;
  }

}

?>
