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
 * @link        https://smt.palle.dev
 **/

class Notifier
{
  protected $send_emails = true;
  protected $send_pushover = true;
  protected $save_logs = true;
  protected $server_id;
  protected $server;
  protected $status_old;
  protected $status_new;
  protected $GLOBALS;

  /**
   * This function initializes the sending (text msg & email) and logging
   *
   * @param int $server_id
   * @param boolean $status_old
   * @param boolean $status_new
   * @return boolean
   */
  public function notify($server_id, $status_old, $status_new)
  {
    $db = new Database('SMT-MONITOR');
    $server = new Server('SMT-ADMIN');
    $session = Session::getInstance();

    $this->server_id = $server_id;
    $this->status_old = $status_old;
    $this->status_new = $status_new;

    $query = "SELECT * FROM psm_servers WHERE server_id=:server_id";
    $db->getQuery($query, array(':server_id' => $this->server_id));

    $value = $db->getValue();
    $this->server = $value['0'];

    $server_data = $server->getSystem($value['0']['home_system'], False, True);
    $this->server['system'] = $server_data['bezeichnung'];

    $notify = True;

    if (empty($this->server['user'])) {
      return $notify;
    }

    if ($this->server['email'] == 'yes') {
      $this->notifyByEmail($this->server['user']);
    }

    if ($this->server['pushover'] == 'yes' && !empty($session->get('pushover_api_token'))) {
     $this->notifyByPushover($this->server['user']);
    }

    if ($this->server['messagebird'] == 'yes' && $status_new == 'off' && !empty($session->get('messsagebird_flowtoken'))) {
      $query_standby = "SELECT * FROM wos_standby WHERE date = :date";
      $db->getQuery($query_standby, array(':date' => date('Y-m-d')));

      $value_standby = $db->getValue();
      $value_standby = $value_standby[0];

      if($db->getNumrows() == 1 && !empty($value_standby['username'])) {
        $this->server['user'] = $value_standby['username'];
        $this->notifyByMessageBird($this->server['user']);
      }
    }

    if($this->server['telegram'] == 'yes' && $status_new == 'off' && $session->get('telegram_api_key') != '') {
      $error_message = "SMT Meldung: {$value['0']['label']} -> {$value['0']['ip']}:{$value['0']['port']} - - {$this->server['system']} hat Probleme";
      urlencode($error_message);
      $val = explode(',',$session->get('telegram_chat_id'));
      for ($i = 0; $i < count($val); $i++) {
        file_get_contents("https://api.telegram.org/".$session->get('telegram_bot').":".$session->get('telegram_api_key')."/sendMessage?chat_id=".$val[$i]."&text=$error_message");
      }
    }

    return $notify;
  }

  /**
   * This functions performs the messagebird notifications
   *
   * @param $user
   */
  protected function notifyByMessageBird($user)
  {
    $session = Session::getInstance();
    $db = new Database('SMT-USER');
    $subject = $this->parse_msg($this->status_new, 'email_subject', $this->server);

    $db->getQuery("SELECT * FROM db_user_private JOIN db_user_contact USING(username) WHERE username=:username", array(':username' => $user));
    $data = array("mitarbeiter" => $db->getValue('displayName'), 'mobilenumber' => $db->getValue('mobile'));
    $data_string = json_encode($data);

    $ch = curl_init('https://flows.messagebird.com/flows/'.$session->get('messsagebird_flowtoken').'/invoke');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_exec($ch);
    curl_close($ch);

    $this->add_log($this->server_id, 'sms', $subject, $user);
  }

  /**
   * This functions performs the email notifications
   *
   * @param array $users
   * @return boolean
   */
  protected function notifyByEmail($users)
  {
    $mail = new Mail();
    $db = new Database('SMT-USER');
    $user = explode(',', $users);
    $session = Session::getInstance();

    $subject = $this->parse_msg($this->status_new, 'email_subject', $this->server);
    $utf8Html = $this->parse_msg($this->status_new, 'email_body', $this->server);

    // go through empl
    for ($i = 0; $i < count($user); $i++) {
      $db->getQuery("SELECT * FROM db_user_contact WHERE username=:username", array(':username' => $user[$i]));
      $mail->sendMail($db->getValue('email'), $session->get('monitor_email_address'), $subject, $utf8Html);
    }

    $this->add_log($this->server_id, 'email', $subject, $users);
  }

  /**
   * This functions performs the pushover notifications
   *
   * @param array $users
   * @return boolean
   */
  protected function notifyByPushover($users)
  {
    $db = new Database('SMT-USER');
    $user = explode(',', $users);
    $pushover = $this->build_pushover();
    $pushover->setPriority(0);
    $message = $this->parse_msg($this->status_new, 'pushover_message', $this->server);

    $pushover->setTitle($this->parse_msg($this->status_new, 'pushover_title', $this->server));
    $pushover->setMessage(str_replace('<br/>', "\n", $message));
    $pushover->setUrl($this->build_url());

    for ($i = 0; $i < count($user); $i++) {
      $db->getQuery("SELECT * FROM db_user_contact WHERE username=:username", array(':username' => $user[$i]));
      $pushover->setUser($db->getValue('pushover'));
      $pushover->send();
    }

    $this->add_log($this->server_id, 'pushover', $message, $users);
  }

  /**
   * Prepare a new Pushover util.
   *
   * @return \Pushover
   */
  public function build_pushover()
  {
    require project_vendor . '/php-pushover/php-pushover/Pushover.php';
    $session = Session::getInstance();
    $pushover = new Pushover();
    $pushover->setToken($session->get('pushover_api_token'));

    return $pushover;
  }

  /**
   * Get a setting from the config.
   *
   * @param string $key
   * @param mixed $alt if not set, return this alternative
   * @return string
   * @see psm_load_conf()
   */
  public function get_conf($key, $alt = null)
  {
    if (!isset($this->GLOBALS['sm_config'])) {
      $this->load_conf();
    }
    $result = (isset($this->GLOBALS['sm_config'][$key])) ? $this->GLOBALS['sm_config'][$key] : $alt;
    return $result;
  }

  /**
   * Load config from the database to the $GLOBALS['sm_config'] variable
   *
   * @return boolean
   * @global object $db
   * @see psm_get_conf()
   */
  public function load_conf()
  {
    $session = Session::getInstance();
    $tabelle = "wos_language_" . $session->get('language');

    $db = new Database('SMT-ADMIN');
    $this->GLOBALS['sm_config'] = array();

    $query = "SELECT * FROM $tabelle WHERE art=:art";
    $value = array(':art' => 'not');

    $e = $db->getQuery($query, $value, True);

    for ($i = 0; $i < $db->getNumrows(); $i++) {
      $this->GLOBALS['sm_config'][$e[$i]['text_name']] = $e[$i]['text_value'];
    }
  }

  /**
   * This function merely adds the message to the log table. It does not perform any checks,
   * everything should have been handled when calling this function
   *
   * @param string $server_id
   * @param string $message
   */
  public function add_log($server_id, $type, $message, $user)
  {
    $db = new Database('SMT-MONITOR');

    $query = "INSERT INTO psm_log (server_id, type, message, user_id) VALUES (:server_id, :type, :message, :user_id)";
    $value = array(':server_id' => $server_id, ':type' => $type, ':message' => $message, ':user_id' => $user);
    $db->getQuery($query, $value);
  }

  /**
   * Parses a string from the language file with the correct variables replaced in the message
   *
   * @param boolean $status
   * @param string $type is either 'sms' or 'email'
   * @param array $server information about the server which may be placed in a message: %KEY% will be replaced by your value
   * @return string parsed message
   */
  function parse_msg($status, $type, $vars)
  {
    $message = $this->get_conf($status . '_' . $type);

    if (!$message) {
      return $message;
    }
    $vars['date'] = date('Y-m-d H:i:s');

    foreach ($vars as $k => $v) {
      $message = str_replace('%' . strtoupper($k) . '%', $v, $message);
    }

    return $message;
  }

  /**
   * Generate a new link to the current monitor
   * @param array|string $params key value pairs or pre-formatted string
   * @param boolean $urlencode urlencode all params?
   * @param boolean $htmlentities use entities in url?
   * @return string
   */
  public function build_url($params = array(), $urlencode = true, $htmlentities = true)
  {
    if (defined('PSM_BASE_URL') && BASE_URL !== null) {
      $url = BASE_URL;
    } else {
      $url = (filter_input(INPUT_SERVER, 'SERVER_PORT') == 443 ? 'https' : 'http') . '://' . filter_input(INPUT_SERVER, 'HTTP_HOST');
      $url .= dirname(filter_input(INPUT_SERVER, 'SCRIPT_NAME')) . '/';
      $url = str_replace('\\', '', $url);
    }

    if ($params !== null) {
      $url .= '?';
      if (is_array($params)) {
        $delim = ($htmlentities) ? '&amp;' : '&';
        foreach ($params as $k => $v) {
          if ($urlencode) {
            $v = urlencode($v);
          }
          $url .= $delim . $k . '=' . $v;
        }
      } else {
        $url .= $params;
      }
    }
    return $url;
  }

}

?>
