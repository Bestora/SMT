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

class Administration
{
  /**
   * Methode zum ermitteln der Anzahl der Kalenderwochen zum übergebenen Jahr
   * @param $year
   * @return int
   * @throws Exception
   */
  public function getIsoWeeksInYear($year) {
    $date = new DateTime;
    $date->setISODate($year, 53);
    return ($date->format("W") === "53" ? 53 : 52);
  }

  /**
   * Methode zur Ermittlung des ersten Tages der Kalenderwoche (Montag)
   * @param $year
   * @param $kw
   * @param string $format
   * @return false|string
   */
  public function getStartDayforWeek($year, $kw, $format = '') {
    if($format == "de") {
      $date = date("d.m.Y", strtotime($year . 'W' . str_pad($kw, 2, '0', STR_PAD_LEFT)));
    } else {
      $date = date("Y.m.d", strtotime($year.'W'.str_pad($kw, 2, '0', STR_PAD_LEFT)));
    }
    return $date;
  }

  /**
   * Methode zur Ermittlung des letzten Tages der Kalenderwoche (Sonntag)
   * @param $year
   * @param $kw
   * @param string $format
   * @return false|string
   */
  public function getLastDayforWeek($year, $kw, $format = '') {
    if($format == "de") {
      $date = date("d.m.Y", strtotime($year . 'W' . str_pad($kw, 2, '0', STR_PAD_LEFT) . ' +6days'));
    } else {
      $date = date("Y.m.d", strtotime($year.'W'.str_pad($kw, 2, '0', STR_PAD_LEFT).' +6days'));
    }
    return $date;
  }

  /**
   * Methode zum eintragen der Kalenderdaten wenn noch nicht vorhanden
   * @param $year
   * @return Exception
   * @throws Exception
   */
  public function UpdateTableForStandby($year) {
    $db = new Database('SMT-MONITOR');
    $db->getQuery("SELECT * FROM wos_standby WHERE year=:year", array(':year'=>$year));

    if($db->getNumrows() == 0) {
      for($i=1; $i<=$this->getIsoWeeksInYear($year); $i++) {
        $db->getQuery("INSERT INTO wos_standby (year, kw) VALUE (:year, :kw)", array(':year'=>$year, ':kw'=>$i));
      }
    }
    return $db->getQuery("SELECT * FROM wos_standby WHERE year=:year", array(':year'=>$year), True);
  }

  /**
   * Methode zum speichern der Benutzer zu einer Kalenderwoche
   * @param $post
   * @param $id
   */
  public function UpdateStandbyWithUsername($post, $id) {
    $db = new Database('SMT-MONITOR');
    $db->getQuery("UPDATE wos_standby SET username=:username WHERE id=:id", array(':username'=>implode(',', $post['username']), ':id'=>$id));
  }

  /**
   * Methode zum speichern eines Wochenberichtes
   * @param $post
   * @param $id
   */
  public function UpdateStandbyReport($post, $id) {
    $db = new Database('SMT-MONITOR');
    $db->getQuery("UPDATE wos_standby SET report=:report WHERE id=:id", array(':report'=>$post['report'], ':id'=>$id));
  }

}