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

define('CLRF', "\n");

class Mail
{
  /**
   * Methode zum versenden von Emails
   *
   * @param $to
   * @param $from
   * @param $subject
   * @param $utf8Html
   *
   * @return bool
   */
  public function sendMail($to, $from, $subject, $utf8Html)
  {
    $mailHeader = 'From: ' . $from . CLRF;
    $mailHeader .= 'Reply-To: ' . $from . CLRF;
    $mailHeader .= 'MIME-Version: 1.0' . CLRF;
    $mailHeader .= 'Content-Type: text/html; charset="UTF-8"' . CLRF;
    $mailHeader .= 'Content-Transfer-Encoding: 8bit' . CLRF;
    return mail($to, "=?utf-8?b?" . base64_encode($subject) . "?=", $utf8Html, $mailHeader);
  }
  
}