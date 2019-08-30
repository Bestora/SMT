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

class Archive
{

  /**
   * Available archiver utils.
   * @var array $archivers
   */
  protected $archivers = array();

  /*
   * Retention period
   * @var \DateInterval $retention_period
   * @see setRetentionPeriod()
   */
  protected $retention_period;

  public function __construct()
  {

  }

  /**
   * Archive one or more servers.
   * @param int $server_id
   * @return boolean
   */
  public function archive($server_id = null)
  {
    $result = true;
    foreach ($this->archivers as $archiver) {
      if (!$archiver->archive($server_id)) {
        $result = false;
      }
    }
    return $result;
  }

  /**
   * Set retention period for this archive run.
   *
   * Set period to 0 to disable cleanup altogether.
   * @param \DateInterval|int $period \DateInterval object or number of days (int)
   * @return \psm\Util\Server\ArchiveManager
   */
  public function setRetentionPeriod($period)
  {
    if (is_object($period) && $period instanceof \DateInterval) {
      $this->retention_period = $period;
    } elseif (intval($period) == 0) {
      // cleanup disabled
      $this->retention_period = false;
    } else {
      $this->retention_period = new \DateInterval('P' . intval($period) . 'D');
    }
    return $this;
  }

}

?>
