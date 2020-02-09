<?php

require_once(__DIR__ . '/../../../vendor/autoload.php');

// Custom Autoloader for loading DefaultApi and all dependencies
spl_autoload_register(function ($class) {
    if (strstr($class, "Swagger")) {
        $filepath_a = explode("\\", $class);
        array_shift($filepath_a);
        array_shift($filepath_a);
        $filepath = __DIR__ . "/" . implode("/", $filepath_a) . ".php";
        require_once($filepath);
    }
});

use Swagger\Client\ApiException;
use Swagger\Client\Model\FmcPhone;
use Swagger\Client\Model\Login;

class StarfaceApi
{
    private $apiInstance;
    private $login;

    private $username = '0024';
    private $password = 'df2014++';
    private $userID = 4592;

    /**
     * StarfaceApi constructor
     * Initialize new Api Client using GuzzleHttp
     * Initialize new Login Object
     */
    public function __construct()
    {

        $this->apiInstance = new Swagger\Client\Api\DefaultApi(
            new GuzzleHttp\Client()
        );
        $this->apiInstance->getConfig()->setUsername($this->username);
        $this->apiInstance->getConfig()->setPassword($this->password);

        $this->login = new Login();
    }

    /**
     * Login to the Starface Api using the given login information
     *
     * @param $username
     * @param $password
     * @param $userID
     * @return string
     * @throws ApiException
     */
    public function login($username, $password, $userID)
    {
        /**
         * Set Login Data
         */
        $this->username = $username;
        $this->password = $password;
        $this->userID = $userID;

        /**
         * Get Nonce
         */
        try {
            $loginResult = $this->apiInstance->getLogin();
        } catch (Exception $e) {
            return 'Exception when calling login->getLogin: ' . $e->getMessage();
        }
        $nonce = $loginResult['nonce'];

        /**
         * Generate Secret
         */
        $loginID = $this->apiInstance->getConfig()->getUsername();
        $password = $this->apiInstance->getConfig()->getPassword();
        $passwordHash = hash('sha512', $password);
        $secret = $loginID . ":" . hash('sha512', $loginID . $nonce . $passwordHash);

        $this->login->setLoginType('Internal');
        $this->login->setNonce($nonce);
        $this->login->setSecret($secret);

        /**
         * Get Token
         */
        $tokenResult = $this->apiInstance->login($this->login);
        $token = $tokenResult['token'];
        $this->apiInstance->getConfig()->setAccessToken($token);

        return $this->login;
    }

    /**
     * Disable all phones, then enable the one with the given number
     *
     * @param $mobileNumber
     * @throws ApiException
     */
    public function switchToNumber($mobileNumber)
    {
        if ($mobileNumber) {
            // Disable all active Phones
            $phones = $this->apiInstance->getFMCPhones();
            foreach ($phones as $phone) {
                if ($phone->getActive()) {
                    $response = $this->toggleFMCPhoneActive($phone->getNumber());

                }
            }

            // Activate given phone by number
            $this->toggleFMCPhoneActive($mobileNumber);
        }
    }

    /**
     * Toggle Active Status for given FMC Phone
     *
     * @param $number
     * @return string|FmcPhone|null
     */
    public function toggleFMCPhoneActive($number)
    {
        $foundPhone = '';
        try {
            /**
             * Get all FMC Phones for given User ID and select the one that matches the given number
             */
            $phones = $this->getFMCPhones();
            foreach ($phones as $phone) {
                if ($phone->getNumber() === $number) {
                    if ($phone->getActive()) {
                        $phone->setActive(false);
                    } else {
                        $phone->setActive(true);
                    }

                    try {
                        /**
                         * Update found FMC Phone
                         */
                        $this->apiInstance->putFmcPhone($phone->getId(), $phone, $this->userID);
                    } catch (Exception $e) {
                        print_r("<pre>");
                        print_r($e);
                        print_r("</pre>");
                    }
                }

            }
        } catch (Exception $e) {
            print_r("<pre>");
            print_r($e);
            print_r("</pre>");
        }
        return $foundPhone;
    }

    /**
     * Return a list of all FMC Phones for that specified User
     *
     * @return string|FmcPhone[]
     */
    public function getFMCPhones()
    {
        try {
            return $this->apiInstance->getFmcPhones($this->userID);
        } catch (Exception $e) {
            return 'Exception when calling getFMCPhones: ' . $e->getMessage();
        }
    }
}
