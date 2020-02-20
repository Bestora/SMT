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
 * @version     Release: v2.0
 * @link        http://palle.zapto.org/
 **/

define('project_path', dirname(__FILE__));
define('project_vendor', project_path . '/vendor');
define('project_base', filter_input(INPUT_SERVER, 'HTTP_HOST'));
define('smt_cookie_runtime', 604800);
define('smt_cookie_domain', project_base);
define('smt_cookie_secret', 'kivg75cdaqg4iafaa9pd918t76Hdi48s');

if (!file_exists(project_path . '/assets/config/' . $_SERVER['SERVER_NAME'] . '.ini')) {
  include_once 'install/install.php';
} else include_once 'library/App.php';

