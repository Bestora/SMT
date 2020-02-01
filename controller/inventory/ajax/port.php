<?php

$ajxData = $_POST;
echo main($ajxData);

/**
 * Funcktion für den Portscanner
 * @param array $ajxData
 * @return string
 */
function main($ajxData)
{
    $dir_root = dirname(__FILE__);
    define('project_path', str_replace('controller' . DIRECTORY_SEPARATOR . 'inventory' . DIRECTORY_SEPARATOR . 'ajax', '', $dir_root));
    define('project_base', filter_input(INPUT_SERVER, 'HTTP_HOST'));
    $return_content = '';

    include(project_path . 'library/System/Database.php');

    $ip = $ajxData['ip'];
    $db = new Database('SMT-ADMIN');
    $fp = @fsockopen($ip, $ajxData['port'], $errno, $errstr, 0.1);

    if (!$fp) {
        $content = '';
    } else {

        $service_tcp = getservbyport($ajxData['port'], 'tcp');
        if (empty($service_tcp)) {
            $service_tcp = '<i>unbekannt</i>';
        }
        $service_udp = getservbyport($ajxData['port'], 'udp');
        if (empty($service_udp)) {
            $service_udp = '<i>unbekannt</i>';
        }

        $return_content = '<table style="margin-bottom:0"; class="table table-hover"><tr>';
        $return_content .= '<td style="width:15%;">Port: <b>' . $ajxData['port'] . '</b></td>';
        $return_content .= '<td style="width:35%;">TCP: ' . $service_tcp . '</td>';
        $return_content .= '<td style="width:30%;">UDP: ' . $service_udp . '</td>';
        $return_content .= '</tr></table>';

        $db->getQuery("DELETE FROM wos_server_ports WHERE ipadresse=:ipadresse && port=:port", array(':ipadresse' => $ip, ':port' => $ajxData['port']));
        $db->getQuery("INSERT INTO wos_server_ports (lastcheck,ipadresse,port,bezeichnung) VALUE (:lastcheck,:ipadresse,:port,:bezeichnung)", array(':lastcheck' => date('Y-m-d H:i:s'), ':ipadresse' => $ip, ':port' => $ajxData['port'], ':bezeichnung' => $service_tcp . '/' . $service_udp));

        fclose($fp);
    }

    return $return_content;
}

?>
