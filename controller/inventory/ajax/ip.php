<?php

$ajxData = $_POST;
$link = False;
$dns = '<b>ACHTUNG, kein Eintrag</b>';
$dir_root = dirname(__FILE__);
define('project_path', str_replace('controller' . DIRECTORY_SEPARATOR . 'inventory' . DIRECTORY_SEPARATOR . 'ajax', '', $dir_root));
define('project_base', filter_input(INPUT_SERVER, 'HTTP_HOST'));
include(project_path . 'library/System/Database.php');

echo main($ajxData);


/**
 * Funktion für den IP Scanner
 * @param array $ajxData
 * @return string
 */
function main($ajxData)
{
  $db = new Database('SMT-ADMIN');
  $fp = False;
  $up = ping($ajxData['ip'] . '.' . $ajxData['port']);
  $message = 'System ist ' . ($up ? 'vorhanden / eingeschalten' : 'nicht vorhanden / ausgeschalten');
  $dns = gethostbyaddr($ajxData['ip'] . '.' . $ajxData['port']);

  if ($dns == $ajxData['ip'] . '.' . $ajxData['port']) {
    $dnsmessage = '<i class="text-red">Fehlerhaft, kein DNS Eintrag</i>';
  } else {
    $dnsmessage = '<span class="text-green"><b>' . $dns . '</b></span>';
  }

  $s = "22,23,135,515,80,443";
  $m = "Linux,Telnet,Windows,Printer,http,https";
  $p = explode(',', $s);
  $n = explode(',', $m);

  for ($i = 0; $i < count($p); $i++) {
    if (!$fp && $up == 1) {
      $port = "";
      $fp = @fsockopen($ajxData['ip'] . '.' . $ajxData['port'], $p[$i], $errno, $errstr, 0.5);
      if ($fp) {
        $port = getservbyport($p[$i], 'tcp');
        $message .= ' - ' . $n[$i] . ' - <b>Port: ' . $p[$i] . ' (' . $port . ')</b>';
      }
    }
  }

  if ($up == 1) {
    $query = "INSERT INTO wos_server_dnsip (ip,port,hostname) VALUE (:ip,:port,:hostname)";
    $value = array(':ip' => $ajxData['ip'] . '.' . $ajxData['port'], ':port' => $port, ':hostname' => $dns);
    $db->getQuery($query, $value);
  }

  $return_content = '<table style="margin-bottom:0"; class="table table-hover">';
  $return_content .= '<tr class="text-' . ($up ? 'green' : 'red') . '">';
  $return_content .= '<td style="width:10%;">' . $ajxData['ip'] . '.' . $ajxData['port'] . '</td>';
  $return_content .= '<td style="width:65%;">' . $message . '</td>';
  $return_content .= '<td style="width:15%;">' . $dnsmessage . '</td>';
  $return_content .= '<td style="width:10%;"><a href="/inventory/portscan/' . $ajxData['ip'] . '.' . $ajxData['port'] . '">Portscan</a></td>';
  $return_content .= '</tr></table>';

  return $return_content;
  $fp = False;
}

function ping($host)
{
  exec(sprintf('ping -c 1 -W 5 %s', escapeshellarg($host)), $res, $rval);
  return $rval === 0;
}

?>
