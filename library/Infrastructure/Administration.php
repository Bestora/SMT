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

class Administration
{
  
  /**
   * Methode zum eintragen der Kalenderdaten wenn noch nicht vorhanden
   *
   * @param $year
   * @param $userListe
   *
   * @return array
   * @throws Exception
   */
  public function UpdateTableForStandby($year, $userListe)
  {
    $db = new Database('SMT-MONITOR');
    $db->getQuery("SELECT * FROM wos_standby WHERE year(date) = :year", array(':year' => $year));
    
    if ($db->getNumrows() == 0) {
      $begin = new DateTime($year . '-01-01');
      $end = (new DateTime($year . '-12-31'))->add(new DateInterval('P1D'));
      
      $interval = DateInterval::createFromDateString('1 day');
      $period = new DatePeriod($begin, $interval, $end);
      
      /**
       * Get Public Holidays
       */
      $country_code = "DE";
      $county_code = "SH";
      $publicHolidays = json_decode(file_get_contents('https://date.nager.at/api/v2/PublicHolidays/' . $year . '/' . $country_code));
      
      /** @var DateTime $dt */
      foreach ($period as $dt) {
        $year = $dt->format("Y");
        $week = $dt->format("W") == 1 && $dt->format("m") == 12 ? 53 : $dt->format("W");
        $date = $dt->format("Y-m-d");
        $isPublicHoliday = $this->isPublicHoliday($publicHolidays, $country_code, $county_code, $date);
        $db->getQuery("INSERT INTO wos_standby (date, kw, is_public_holiday) VALUE (:date, :kw, :isPublicHoliday)", array(':date' => $date, ':kw' => $week, ':isPublicHoliday' => $isPublicHoliday));
      }
    }
    $standbyData = $db->getQuery("SELECT * FROM wos_standby WHERE year(date) = :year", array(':year' => $year), True);
    $data = $this->formatTableDataForStandby($standbyData, $year, $userListe);
    return $data;
  }
  
  /**
   * Uses an API to check if a given Date is a public holiday.
   * Requires the Date to be in Y-m-d
   *
   * @param $publicHolidays
   * @param $country_code
   * @param $county_code
   * @param $date
   *
   * @return bool
   */
  function isPublicHoliday($publicHolidays, $country_code, $county_code, $date)
  {
    $year = date('Y', strtotime($date));
    $isPublicHoliday = false;
    foreach ($publicHolidays as $holiday) {
      if ($holiday->global == "1" || in_array($country_code . "-" . $county_code, $holiday->counties)) {
        if ($holiday->date == $date) {
          $isPublicHoliday = true;
        }
      }
    }
    return $isPublicHoliday;
  }
  
  /**
   * Formatting the received Standby Data
   *
   * @param $data
   * @param $year
   * @param $userListe
   *
   * @return array
   */
  public function formatTableDataForStandby($data, $year, $userListe)
  {
    $wos = new Service();
    $result = [];
    foreach ($data as $obj) {
      $result[$obj['kw']]['start'] = isset($result[$obj['kw']]['start']) && $result[$obj['kw']]['start'] != "" ? $result[$obj['kw']]['start'] : $obj['date'];
      $result[$obj['kw']]['start'] = date('d.m.Y', strtotime($result[$obj['kw']]['start']));
      $result[$obj['kw']]['ende'] = isset($result[$obj['kw']]['ende']) && $obj['date'] < $result[$obj['kw']]['ende'] ? $obj['date'] : $obj['date'];
      $result[$obj['kw']]['ende'] = date('d.m.Y', strtotime($result[$obj['kw']]['ende']));
      $result[$obj['kw']]['kw'] = $obj['kw'];
      $result[$obj['kw']]['year'] = $year;
      if (!isset($result[$obj['kw']]['reports']) || $result[$obj['kw']]['reports'] == "") $result[$obj['kw']]['reports'] = 0;
      if ($obj['report'] != "") {
        $result[$obj['kw']]['reports'] += 1;
      }
      if ($obj['username']) {
        foreach ($userListe as $user) {
          if ($user['username'] == $obj['username']) {
            $result[$obj['kw']]['users'][$obj['username']] = $user;
            $obj['user'] = $obj['username'];
          }
        }
      }
      $result[$obj['kw']]['days'][] = $obj;
    }
    
    foreach ($result as $week) {
      // Get logs/reports
      $result[$week['kw']]['logs'] = $wos->getLogDate(date('Y-m-d', strtotime($week['start'])) . ' 00:00:00', date('Y-m-d', strtotime($week['ende'])) . ' 23:59:59');
      
      // Make day strings to display on hover
      if (isset($week['users'])) {
        foreach ($week['users'] as $user) {
          $dayString = "";
          foreach ($week['days'] as $day) {
            if (isset($day['user']) && $day['user'] === $user['username']) {
              $date = $this->replaceEnglishMonthNamesWithGerman(date('l - d. F', strtotime($day['date'])));
              $date = $this->replaceEnglishDayNamesWithGerman($date);
              $dayString .= $date . "<br>";
            }
          }
          $result[$week['kw']]['users'][$user['username']]['dayString'] = $dayString;
        }
      }
    }
    return $result;
  }
  
  /**
   * Replace English month names with german month names
   *
   * @param $string
   *
   * @return mixed
   */
  public function replaceEnglishMonthNamesWithGerman($string)
  {
    $english = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    $german = ['Januar', 'Februar', 'Märts', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];
    return str_ireplace($english, $german, $string);
  }
  
  /**
   * Replace English day names with german day names
   *
   * @param $string
   *
   * @return mixed
   */
  public function replaceEnglishDayNamesWithGerman($string)
  {
    $english = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    $german = ['Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag'];
    return str_ireplace($english, $german, $string);
  }
  
  /**
   * Get Month Name by Number
   *
   * @param $month
   * @param string $locale
   *
   * @return mixed
   */
  function getMonthName($month, $locale = 'de')
  {
    $english = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    $german = ['Januar', 'Februar', 'Märts', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];
    if ($locale === "de") {
      $monthNames = $german;
    } else {
      $monthNames = $english;
    }
    return $monthNames[$month - 1];
  }
  
  /**
   * Get Day Name by Number
   *
   * @param $day
   * @param string $locale
   *
   * @return mixed
   */
  function getDayName($day, $locale = 'de')
  {
    $english = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    $german = ['Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag'];
    if ($locale === "de") {
      $dayNames = $german;
    } else {
      $dayNames = $english;
    }
    return $dayNames[$day - 1];
  }
  
  /**
   * Methode zum speichern der Benutzer zu einer Kalenderwoche
   *
   * @param $post
   * @param $id
   */
  public function UpdateStandbyWithUsername($post, $id)
  {
    $db = new Database('SMT-MONITOR');
    $db->getQuery("UPDATE wos_standby SET username=:username WHERE id=:id", array(':username' => implode(',', $post['username']), ':id' => $id));
  }
  
  /**
   * Methode zum speichern eines Wochenberichtes
   *
   * @param $post
   * @param $id
   */
  public function UpdateStandbyReport($post, $id)
  {
    $db = new Database('SMT-MONITOR');
    $db->getQuery("UPDATE wos_standby SET report=:report WHERE id=:id", array(':report' => $post['report'], ':id' => $id));
  }
}
