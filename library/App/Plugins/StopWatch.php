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


/**
 * Klasse zum debuggen bei Geschwindigkeitsproblemen
 */
class StopWatch
{
  private static $fTimeStart = 0.00;
  private static $fTotal = 0.00;

  /**
   * Methode zum starten der Stopuhr
   */
  public static function start()
  {
    self::$fTimeStart = microtime(true);
    self::$fTotal = 0.00;
  }

  /**
   * Methode zum stoppen der Stopuhr
   * @param string $message
   * @return string $value
   */
  public static function stop($message = '')
  {
    $fTimeEnd = (microtime(true) - self::$fTimeStart);
    $value = $message . "s\nZeit: " . number_format($fTimeEnd, 15);

    return $value;
  }
}
