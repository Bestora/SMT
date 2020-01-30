<?php
$dir_root = dirname(__FILE__);
define('project_path', str_replace('controller' . DIRECTORY_SEPARATOR . 'administration' . DIRECTORY_SEPARATOR . 'ajax', '', $dir_root));
include(project_path . 'library/System/Database.php');
include(project_path . 'library/System/Mail.php');
include(project_path . 'library/System/File.php');
include(project_path . 'library/ServerService/Service.php');
include(project_path . 'library/Infrastructure/Administration.php');
include(project_path . 'library/Module/starface/StarfaceApi.class.php');

if(isset($_POST)){
    $db = new Database('SMT-ADMIN');
    $adm = new Administration();
    $file = new File();
    $returnData = array();
    if(isset($_POST['remove-user-standby'])){
        // Check if user has standby today
        $today = date('Y-m-d');
        $isToday = false;
        $days = $db->getQuery("SELECT * FROM wos_standby WHERE kw = :kw AND username = :user", ['kw'=>$_POST['kw'], 'user'=>$_POST['username']], true);
        foreach ($days as $day){
            if($day['date'] === $today){
                $isToday = true;
            }
        }

        // Ask the Starface API to deactivate the users number
        if($isToday){
            session_start();
            $loginID = $_SESSION['starface_login_id'];
            $loginPW = $_SESSION['starface_login_pw'];
            $userID = $_SESSION['starface_user_id'];
            $db->getQuery("SELECT mobile FROM db_user_contact WHERE username = :user", ['user'=>$_POST['username']], true);
            $mobileNumber = $db->getValue('mobile');
            if($mobileNumber){
                $starface = new StarfaceApi();
                $starface->login($loginID, $loginPW, $userID);

                // Disable all active Phones
                $phones = $starface->getFMCPhones();
                foreach ($phones as $phone){
                    if($phone->getNumber() === $mobileNumber){
                        $response = $starface->toggleFMCPhoneActive($phone->getNumber());
                    }
                }
            }
        }

        $db->getQuery("UPDATE wos_standby SET username = '' WHERE kw = :kw AND username = :user", ['kw'=>$_POST['kw'], 'user'=>$_POST['username']], true);
        $returnData['success'] = true;
    }elseif(isset($_POST['add-user-standby'])){
        $returnData['success'] = true;
        $returnData['user'] = $_POST['username'];
        $returnData['days'] = $_POST['days'];

        $dayString = "";
        foreach ($_POST['days'] as $day){
            $date = $adm->replaceEnglishMonthNamesWithGerman(date('l - d. F', strtotime($day)));
            $date = $adm->replaceEnglishDayNamesWithGerman($date);
            $dayString .= $date."<br>";
        }
        $returnData['dayString'] = $dayString;

        foreach ($_POST['days'] as $day){
            $db->getQuery("UPDATE wos_standby SET username = :username WHERE date = :date", ['username'=>$_POST['username'], 'date'=>$day], true);
        }

        // If added today, ask Starface API so activate phone
        $today = date('Y-m-d');
        if(in_array($today, $_POST['days'])){
            session_start();
            $loginID = $_SESSION['starface_login_id'];
            $loginPW = $_SESSION['starface_login_pw'];
            $userID = $_SESSION['starface_user_id'];

            // Get number from DB
            $db->getQuery("SELECT mobile FROM db_user_contact WHERE username = :user", ['user'=>$_POST['username']], true);
            $mobileNumber = $db->getValue('mobile');
            if($mobileNumber){
                $starface = new StarfaceApi();
                $starface->login($loginID, $loginPW, $userID);

                // Activate Phone
                $starface->toggleFMCPhoneActive($mobileNumber);
            }
        }
    }elseif(isset($_POST['get-reports'])){
        $data = [];
        $results = $db->getQuery("SELECT date, report FROM wos_standby WHERE year(date) = :year AND kw = :kw", ['year'=>$_POST['year'], 'kw'=>$_POST['kw']], true);
        foreach ($results as $result){
            $data[] = [
                'day' => $adm->replaceEnglishDayNamesWithGerman(date('l', strtotime($result['date']))),
                'date' => date('d.m.Y', strtotime($result['date'])),
                'report' => $result['report']
            ];
        }
        $returnData['success'] = true;
        $returnData['reports'] = $data;
    }elseif(isset($_POST['save-reports'])){
        if(isset($_POST['data'])){
            $reports = $_POST['data'];

            foreach ($reports as $date => $report){
                $date = DateTime::createFromFormat('d.m.Y', $date);
                $date = $date->format('Y-m-d');
                $result = $db->getQuery("UPDATE wos_standby SET report = :report WHERE date = :date", ['report'=>$report, 'date'=>$date], true);
            }
        }
        $returnData['success'] = true;
    }elseif(isset($_POST['send-reports'])){
        $email_addresses = $_POST['email_addresses'];
        if($email_addresses){
            $valid = true;
            foreach ($email_addresses as $email_address){
                if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) $valid = false;
            }
            if($valid){
                // Add email of active user to list
                session_start();
                $username = $_SESSION['username'];
                $db->getQuery("SELECT email FROM db_user_contact WHERE username = :username", ['username'=>$username], true);
                $my_email = $db->getValue('email');
                $email_addresses[] = $my_email;

                // Get month report Data
                $month = $_POST['month'] < 10 ? "0".$_POST['month']: $_POST['month'];
                $year = $_POST['year'];
                $users = $db->getQuery("SELECT date, wos_standby.username, displayName, is_public_holiday, kw FROM wos_standby JOIN db_user_private USING(username) WHERE year(date) = :year AND month(date) = :month ORDER BY date ASC", ['year'=>$year, 'month'=>$month], true);
                $html = file_get_contents($file->getTemplateDir().'/structure/standby_email_template.html');
                $html = str_replace('${month}', $adm->getMonthName($_POST['month']), $html);
                $html = str_replace('${year}', $year, $html);

                // Add days to HTML
                $userHtml = "";
                $kw = 0;
                foreach ($users as $user){
                    if($user['kw'] != $kw){
                        $kw = $user['kw'];
                        $userHtml .= '
                        <tr>
                            <td class="center-on-narrow" style="font-family: sans-serif; font-size: 15px; line-height: 140%; color: #FFFFFF; padding: 0 20px; text-align: left;" width="70%">
                                <p style="margin: 0;font-weight: bold;">KW '.$kw.'</p>
                            </td>
                        </tr>
                        ';
                    }
                    $userHtml .= '
                    <tr>
                        <td class="center-on-narrow" style="font-family: sans-serif; font-size: 15px; line-height: 140%; color: #FFFFFF; padding: 0 20px; text-align: left;" width="70%">
                            <p style="margin: 0;">'.$adm->getDayName(date('N', strtotime($user['date']))).' d. '.date('d.m.Y', strtotime($user['date'])).($user['is_public_holiday'] == 1 ? " (Feiertag)": "").'</p>
                        </td>
                        <td class="center-on-narrow" style="font-family: sans-serif; font-size: 15px; line-height: 140%; color: #FFFFFF; padding: 0 20px; text-align: right;" width="30%">
                            <p style="margin: 0;">'.$user['displayName'].'</p>
                        </td>
                    </tr>
                    ';
                }
                $html = str_replace('${users}', $userHtml, $html);

                // Send Mails
                $mail = new Mail();
                foreach ($email_addresses as $email_address){
                    $mail->sendMail($email_address, $_SESSION['monitor_email_address'], "IT Rufbereitschaft Monatsbericht (".$adm->getMonthName($_POST['month']).")", $html);
                }

                $returnData['success'] = true;
                $returnData['html'] = $html;
            }else{
                $returnData['success'] = false;
            }
        }else{
            $returnData['success'] = false;
        }
    }elseif(isset($_POST['get-logs'])){
        $wos = new Service();
        $start = date('Y-m-d', strtotime($_POST['start']));
        $ende = date('Y-m-d', strtotime($_POST['ende']));
        $logs = $wos->getLogDate($start . ' 00:00:00', $ende . ' 23:59:59');
        $returnData['success'] = true;
        $returnData['logs'] = $logs;
    }elseif(isset($_POST['get-report'])){
        $date = DateTime::createFromFormat('d.m.Y', $_POST['date']);
        $date = $date->format('Y-m-d');

        $db->getQuery("SELECT * FROM `wos_standby` WHERE date = :date", ['date'=>$date], true);
        $report = $db->getValue('report');

        $returnData['success'] = true;
        $returnData['report'] = $report;
    }

    header('Content-Type: application/json');
    echo json_encode($returnData);
    exit();
}
