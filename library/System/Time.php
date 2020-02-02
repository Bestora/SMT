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

class Time
{

    /**
     * Anzeige der letzten Updateaktion
     * @param <string> $datetime
     */
    public function ago($datetime)
    {
        $interval = date_create('now')->diff($datetime);
        $suffix = ($interval->invert ? texte::getText('time_ago_vor') . ' ' : '');

        if ($interval->y >= 1)
            return $suffix . $this->pluralize($interval->y, texte::getText('time_ago_jahr'));
        if ($interval->m >= 1)
            return $suffix . $this->pluralize($interval->m, texte::getText('time_ago_monat'));
        if ($interval->d >= 1)
            return $suffix . $this->pluralize($interval->d, texte::getText('time_ago_tag'));
        if ($interval->h >= 1)
            return $suffix . $this->pluralize($interval->h, texte::getText('time_ago_stunde'));
        if ($interval->i >= 1)
            return $suffix . $this->pluralize($interval->i, texte::getText('time_ago_minute'));

        return $suffix . $this->pluralize($interval->s, texte::getText('time_ago_sekunde'));
    }

    /**
     * pluralize
     *
     * @param <string> $count
     * @param <beliebig> $text
     */
    public function pluralize($count, $text)
    {
        $v = $count . (($count == 1) ? (" $text") : (" ${text}en"));
        return str_replace("een", "en", $v);
    }

}

?>
