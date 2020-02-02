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

class SMTError extends Exception
{

    public $ERROR_FILE = 'error.log';

    public function __construct($logfile = '', $message)
    {
        if (!empty($logfile)) {
            $this->ERROR_FILE = $logfile;
        }
        $this->setError($message);

        if (preg_match('/dev./', $_SERVER['SERVER_NAME'])) {
            die($this->getError());
        }
    }

    /**
     * Methode zum schreiben eines Fehlers in die LogDatei
     *
     * @param <string> $message
     */
    public function setError($message)
    {
        $error_date = date("d.m.Y") . ' - ' . date("H:i") . 'Uhr: ';
        $error_url = filter_input(INPUT_SERVER, 'REQUEST_URI');
        $message = $error_url . chr(10) . $message . chr(10) . $error_date;
        $message .= "\r\n\r\n\r\n\r\n";

        $file = 'assets/logfile/' . $this->ERROR_FILE;
        $current = file_get_contents($file) . $message;
        file_put_contents($file, $current);
    }


    public function getError()
    {
        $file = 'assets/logfile/' . $this->ERROR_FILE;
        echo '<pre>' . file_get_contents($file) . '</pre>';
    }

}

?>
