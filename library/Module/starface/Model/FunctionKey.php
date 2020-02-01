<?php
/**
 * FunctionKey
 *
 * PHP version 5
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * STARFACE Rest Api
 *
 * A Rest API for STARFACE
 *
 * OpenAPI spec version: 0.9.2
 *
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 2.4.10
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Swagger\Client\Model;

use ArrayAccess;
use Swagger\Client\ObjectSerializer;

/**
 * FunctionKey Class Doc Comment
 *
 * @category Class
 * @description A representation of a FunctionKey
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class FunctionKey implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;
    const FUNCTION_KEY_TYPE_SIGNALNUMBER = 'SIGNALNUMBER';
    const FUNCTION_KEY_TYPE_SEPARATOR = 'SEPARATOR';
    const FUNCTION_KEY_TYPE_QUICKDIAL = 'QUICKDIAL';
    const FUNCTION_KEY_TYPE_PHONEGENERICURL = 'PHONEGENERICURL';
    const FUNCTION_KEY_TYPE_PHONEDTMF = 'PHONEDTMF';
    const FUNCTION_KEY_TYPE_PHONECONTACTSEARCH = 'PHONECONTACTSEARCH';
    const FUNCTION_KEY_TYPE_PHONECONTACTLIST = 'PHONECONTACTLIST';
    const FUNCTION_KEY_TYPE_PHONECONTACT = 'PHONECONTACT';
    const FUNCTION_KEY_TYPE_PHONECALLLISTOUTGOING = 'PHONECALLLISTOUTGOING';
    const FUNCTION_KEY_TYPE_PHONECALLLISTMISSED = 'PHONECALLLISTMISSED';
    const FUNCTION_KEY_TYPE_PHONECALLLISTINCOMING = 'PHONECALLLISTINCOMING';
    const FUNCTION_KEY_TYPE_PARKANDORBIT = 'PARKANDORBIT';
    const FUNCTION_KEY_TYPE_MODULEACTIVATION = 'MODULEACTIVATION';
    const FUNCTION_KEY_TYPE_GROUPLOGIN = 'GROUPLOGIN';
    const FUNCTION_KEY_TYPE_FORWARDNUMBERUNCONDITIONAL = 'FORWARDNUMBERUNCONDITIONAL';
    const FUNCTION_KEY_TYPE_FORWARDCALLUNCONDITIONAL = 'FORWARDCALLUNCONDITIONAL';
    const FUNCTION_KEY_TYPE_FORWARDCALLNORESPONSE = 'FORWARDCALLNORESPONSE';
    const FUNCTION_KEY_TYPE_FORWARDCALLBUSY = 'FORWARDCALLBUSY';
    const FUNCTION_KEY_TYPE_DONOTDISTURB = 'DONOTDISTURB';
    const FUNCTION_KEY_TYPE_COMPLETIONOFCALLSTOBUSYSUBSCRIBER = 'COMPLETIONOFCALLSTOBUSYSUBSCRIBER';
    const FUNCTION_KEY_TYPE_BUSYLAMPFIELD = 'BUSYLAMPFIELD';
    const STATE_INVALID = 'INVALID';
    const STATE_UNAVAILABLE = 'UNAVAILABLE';
    const STATE_INACTIVE = 'INACTIVE';
    const STATE_FLASHY = 'FLASHY';
    const STATE_ACTIVE = 'ACTIVE';
    const STATE_QUEUE_PAUSE = 'QUEUE_PAUSE';
    /**
     * The original name of the model.
     *
     * @var string
     */
    protected static $swaggerModelName = 'FunctionKey';
    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @var string[]
     */
    protected static $swaggerTypes = [
        'function_key_type' => 'string',
        'id' => 'string',
        'name' => 'string',
        'account_id' => 'string',
        'state' => 'string',
        'position' => 'int',
        'systemkey' => 'bool',
        'subscription' => 'string',
        'address_book_folder_name' => 'string',
        'address_book_folder' => 'string',
        'target_number' => 'string',
        'url' => 'string',
        'dtmf' => 'string',
        'image_hash' => 'string',
        'user_info' => '\Swagger\Client\Model\FunctionKeyUserInfo',
        'user_state' => '\Swagger\Client\Model\FunctionKeyUserState'
    ];
    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @var string[]
     */
    protected static $swaggerFormats = [
        'function_key_type' => null,
        'id' => null,
        'name' => null,
        'account_id' => null,
        'state' => null,
        'position' => 'int32',
        'systemkey' => null,
        'subscription' => null,
        'address_book_folder_name' => null,
        'address_book_folder' => null,
        'target_number' => null,
        'url' => null,
        'dtmf' => null,
        'image_hash' => null,
        'user_info' => null,
        'user_state' => null
    ];
    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'function_key_type' => 'functionKeyType',
        'id' => 'id',
        'name' => 'name',
        'account_id' => 'accountId',
        'state' => 'state',
        'position' => 'position',
        'systemkey' => 'systemkey',
        'subscription' => 'subscription',
        'address_book_folder_name' => 'addressBookFolderName',
        'address_book_folder' => 'addressBookFolder',
        'target_number' => 'targetNumber',
        'url' => 'url',
        'dtmf' => 'dtmf',
        'image_hash' => 'imageHash',
        'user_info' => 'userInfo',
        'user_state' => 'userState'
    ];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'function_key_type' => 'setFunctionKeyType',
        'id' => 'setId',
        'name' => 'setName',
        'account_id' => 'setAccountId',
        'state' => 'setState',
        'position' => 'setPosition',
        'systemkey' => 'setSystemkey',
        'subscription' => 'setSubscription',
        'address_book_folder_name' => 'setAddressBookFolderName',
        'address_book_folder' => 'setAddressBookFolder',
        'target_number' => 'setTargetNumber',
        'url' => 'setUrl',
        'dtmf' => 'setDtmf',
        'image_hash' => 'setImageHash',
        'user_info' => 'setUserInfo',
        'user_state' => 'setUserState'
    ];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'function_key_type' => 'getFunctionKeyType',
        'id' => 'getId',
        'name' => 'getName',
        'account_id' => 'getAccountId',
        'state' => 'getState',
        'position' => 'getPosition',
        'systemkey' => 'getSystemkey',
        'subscription' => 'getSubscription',
        'address_book_folder_name' => 'getAddressBookFolderName',
        'address_book_folder' => 'getAddressBookFolder',
        'target_number' => 'getTargetNumber',
        'url' => 'getUrl',
        'dtmf' => 'getDtmf',
        'image_hash' => 'getImageHash',
        'user_info' => 'getUserInfo',
        'user_state' => 'getUserState'
    ];
    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['function_key_type'] = isset($data['function_key_type']) ? $data['function_key_type'] : null;
        $this->container['id'] = isset($data['id']) ? $data['id'] : null;
        $this->container['name'] = isset($data['name']) ? $data['name'] : null;
        $this->container['account_id'] = isset($data['account_id']) ? $data['account_id'] : null;
        $this->container['state'] = isset($data['state']) ? $data['state'] : null;
        $this->container['position'] = isset($data['position']) ? $data['position'] : null;
        $this->container['systemkey'] = isset($data['systemkey']) ? $data['systemkey'] : null;
        $this->container['subscription'] = isset($data['subscription']) ? $data['subscription'] : null;
        $this->container['address_book_folder_name'] = isset($data['address_book_folder_name']) ? $data['address_book_folder_name'] : null;
        $this->container['address_book_folder'] = isset($data['address_book_folder']) ? $data['address_book_folder'] : null;
        $this->container['target_number'] = isset($data['target_number']) ? $data['target_number'] : null;
        $this->container['url'] = isset($data['url']) ? $data['url'] : null;
        $this->container['dtmf'] = isset($data['dtmf']) ? $data['dtmf'] : null;
        $this->container['image_hash'] = isset($data['image_hash']) ? $data['image_hash'] : null;
        $this->container['user_info'] = isset($data['user_info']) ? $data['user_info'] : null;
        $this->container['user_state'] = isset($data['user_state']) ? $data['user_state'] : null;
    }

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['function_key_type'] === null) {
            $invalidProperties[] = "'function_key_type' can't be null";
        }
        $allowedValues = $this->getFunctionKeyTypeAllowableValues();
        if (!is_null($this->container['function_key_type']) && !in_array($this->container['function_key_type'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'function_key_type', must be one of '%s'",
                implode("', '", $allowedValues)
            );
        }

        if ($this->container['id'] === null) {
            $invalidProperties[] = "'id' can't be null";
        }
        if ($this->container['name'] === null) {
            $invalidProperties[] = "'name' can't be null";
        }
        if ($this->container['account_id'] === null) {
            $invalidProperties[] = "'account_id' can't be null";
        }
        $allowedValues = $this->getStateAllowableValues();
        if (!is_null($this->container['state']) && !in_array($this->container['state'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'state', must be one of '%s'",
                implode("', '", $allowedValues)
            );
        }

        return $invalidProperties;
    }

    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getFunctionKeyTypeAllowableValues()
    {
        return [
            self::FUNCTION_KEY_TYPE_SIGNALNUMBER,
            self::FUNCTION_KEY_TYPE_SEPARATOR,
            self::FUNCTION_KEY_TYPE_QUICKDIAL,
            self::FUNCTION_KEY_TYPE_PHONEGENERICURL,
            self::FUNCTION_KEY_TYPE_PHONEDTMF,
            self::FUNCTION_KEY_TYPE_PHONECONTACTSEARCH,
            self::FUNCTION_KEY_TYPE_PHONECONTACTLIST,
            self::FUNCTION_KEY_TYPE_PHONECONTACT,
            self::FUNCTION_KEY_TYPE_PHONECALLLISTOUTGOING,
            self::FUNCTION_KEY_TYPE_PHONECALLLISTMISSED,
            self::FUNCTION_KEY_TYPE_PHONECALLLISTINCOMING,
            self::FUNCTION_KEY_TYPE_PARKANDORBIT,
            self::FUNCTION_KEY_TYPE_MODULEACTIVATION,
            self::FUNCTION_KEY_TYPE_GROUPLOGIN,
            self::FUNCTION_KEY_TYPE_FORWARDNUMBERUNCONDITIONAL,
            self::FUNCTION_KEY_TYPE_FORWARDCALLUNCONDITIONAL,
            self::FUNCTION_KEY_TYPE_FORWARDCALLNORESPONSE,
            self::FUNCTION_KEY_TYPE_FORWARDCALLBUSY,
            self::FUNCTION_KEY_TYPE_DONOTDISTURB,
            self::FUNCTION_KEY_TYPE_COMPLETIONOFCALLSTOBUSYSUBSCRIBER,
            self::FUNCTION_KEY_TYPE_BUSYLAMPFIELD,
        ];
    }

    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getStateAllowableValues()
    {
        return [
            self::STATE_INVALID,
            self::STATE_UNAVAILABLE,
            self::STATE_INACTIVE,
            self::STATE_FLASHY,
            self::STATE_ACTIVE,
            self::STATE_QUEUE_PAUSE,
        ];
    }

    /**
     * Gets function_key_type
     *
     * @return string
     */
    public function getFunctionKeyType()
    {
        return $this->container['function_key_type'];
    }

    /**
     * Sets function_key_type
     *
     * @param string $function_key_type The type of the FunctionKey determining the concrete FunctionKey implementation.
     *
     * @return $this
     */
    public function setFunctionKeyType($function_key_type)
    {
        $allowedValues = $this->getFunctionKeyTypeAllowableValues();
        if (!in_array($function_key_type, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'function_key_type', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['function_key_type'] = $function_key_type;

        return $this;
    }

    /**
     * Gets id
     *
     * @return string
     */
    public function getId()
    {
        return $this->container['id'];
    }

    /**
     * Sets id
     *
     * @param string $id the Id of the FunctionKey
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->container['id'] = $id;

        return $this;
    }

    /**
     * Gets name
     *
     * @return string
     */
    public function getName()
    {
        return $this->container['name'];
    }

    /**
     * Sets name
     *
     * @param string $name the display name of the FunctionKey
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->container['name'] = $name;

        return $this;
    }

    /**
     * Gets account_id
     *
     * @return string
     */
    public function getAccountId()
    {
        return $this->container['account_id'];
    }

    /**
     * Sets account_id
     *
     * @param string $account_id the accountId of the FunctionKey
     *
     * @return $this
     */
    public function setAccountId($account_id)
    {
        $this->container['account_id'] = $account_id;

        return $this;
    }

    /**
     * Gets state
     *
     * @return string
     */
    public function getState()
    {
        return $this->container['state'];
    }

    /**
     * Sets state
     *
     * @param string $state state of the function key with one of the constants of INVALID, UNAVAILABLE, INACTIVE, FLASHY, ACTIVE, QUEUE_PAUSE
     *
     * @return $this
     */
    public function setState($state)
    {
        $allowedValues = $this->getStateAllowableValues();
        if (!is_null($state) && !in_array($state, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'state', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['state'] = $state;

        return $this;
    }

    /**
     * Gets position
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->container['position'];
    }

    /**
     * Sets position
     *
     * @param int $position the position of the FunctionKey wthin its FunctionKeySet
     *
     * @return $this
     */
    public function setPosition($position)
    {
        $this->container['position'] = $position;

        return $this;
    }

    /**
     * Gets systemkey
     *
     * @return bool
     */
    public function getSystemkey()
    {
        return $this->container['systemkey'];
    }

    /**
     * Sets systemkey
     *
     * @param bool $systemkey Flag for Systemkey: 0 = userkey, 1 = systemkey
     *
     * @return $this
     */
    public function setSystemkey($systemkey)
    {
        $this->container['systemkey'] = $systemkey;

        return $this;
    }

    /**
     * Gets subscription
     *
     * @return string
     */
    public function getSubscription()
    {
        return $this->container['subscription'];
    }

    /**
     * Sets subscription
     *
     * @param string $subscription The subscription. In case of functionKeyType BUSYLAMPFIELD the subscription is build using 'a' + the target accountId
     *
     * @return $this
     */
    public function setSubscription($subscription)
    {
        $this->container['subscription'] = $subscription;

        return $this;
    }

    /**
     * Gets address_book_folder_name
     *
     * @return string
     */
    public function getAddressBookFolderName()
    {
        return $this->container['address_book_folder_name'];
    }

    /**
     * Sets address_book_folder_name
     *
     * @param string $address_book_folder_name address_book_folder_name
     *
     * @return $this
     */
    public function setAddressBookFolderName($address_book_folder_name)
    {
        $this->container['address_book_folder_name'] = $address_book_folder_name;

        return $this;
    }

    /**
     * Gets address_book_folder
     *
     * @return string
     */
    public function getAddressBookFolder()
    {
        return $this->container['address_book_folder'];
    }

    /**
     * Sets address_book_folder
     *
     * @param string $address_book_folder address_book_folder
     *
     * @return $this
     */
    public function setAddressBookFolder($address_book_folder)
    {
        $this->container['address_book_folder'] = $address_book_folder;

        return $this;
    }

    /**
     * Gets target_number
     *
     * @return string
     */
    public function getTargetNumber()
    {
        return $this->container['target_number'];
    }

    /**
     * Sets target_number
     *
     * @param string $target_number target_number
     *
     * @return $this
     */
    public function setTargetNumber($target_number)
    {
        $this->container['target_number'] = $target_number;

        return $this;
    }

    /**
     * Gets url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->container['url'];
    }

    /**
     * Sets url
     *
     * @param string $url url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->container['url'] = $url;

        return $this;
    }

    /**
     * Gets dtmf
     *
     * @return string
     */
    public function getDtmf()
    {
        return $this->container['dtmf'];
    }

    /**
     * Sets dtmf
     *
     * @param string $dtmf dtmf
     *
     * @return $this
     */
    public function setDtmf($dtmf)
    {
        $this->container['dtmf'] = $dtmf;

        return $this;
    }

    /**
     * Gets image_hash
     *
     * @return string
     */
    public function getImageHash()
    {
        return $this->container['image_hash'];
    }

    /**
     * Sets image_hash
     *
     * @param string $image_hash image_hash
     *
     * @return $this
     */
    public function setImageHash($image_hash)
    {
        $this->container['image_hash'] = $image_hash;

        return $this;
    }

    /**
     * Gets user_info
     *
     * @return \Swagger\Client\Model\FunctionKeyUserInfo
     */
    public function getUserInfo()
    {
        return $this->container['user_info'];
    }

    /**
     * Sets user_info
     *
     * @param \Swagger\Client\Model\FunctionKeyUserInfo $user_info user_info
     *
     * @return $this
     */
    public function setUserInfo($user_info)
    {
        $this->container['user_info'] = $user_info;

        return $this;
    }

    /**
     * Gets user_state
     *
     * @return \Swagger\Client\Model\FunctionKeyUserState
     */
    public function getUserState()
    {
        return $this->container['user_state'];
    }

    /**
     * Sets user_state
     *
     * @param \Swagger\Client\Model\FunctionKeyUserState $user_state user_state
     *
     * @return $this
     */
    public function setUserState($user_state)
    {
        $this->container['user_state'] = $user_state;

        return $this;
    }

    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed $value Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}


