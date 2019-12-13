<?php

$today = date('Y-m-d');
$db = new Database('SMT-MONITOR');
$results = $db->getQuery("SELECT username, mobile FROM wos_standby JOIN db_user_contact USING(username) WHERE date = :date", ['date'=>$today], true);
$mobileNumber = $db->getValue('mobile');

$loginID = base::get('Handler')->config['starface_login_id'];
$loginPW = base::get('Handler')->config['starface_login_pw'];
$userID = base::get('Handler')->config['starface_user_id'];

if($mobileNumber){
    $starface = new StarfaceApi();
    $starface->login($loginID, $loginPW, $userID);

    // Disable all active Phones
    $phones = $starface->getFMCPhones();
    foreach ($phones as $phone){
        if($phone->getActive()){
            $response = $starface->toggleFMCPhoneActive($phone->getNumber());

        }
    }

    // Activate given phone by number
    $starface->toggleFMCPhoneActive($mobileNumber);
}
