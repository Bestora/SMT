<?php
/**
 * User
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
 * User Class Doc Comment
 *
 * @category Class
 * @description A representation of a STARFACE user
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class User implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
     * The original name of the model.
     *
     * @var string
     */
    protected static $swaggerModelName = 'User';

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @var string[]
     */
    protected static $swaggerTypes = [
        'id' => 'int',
        'person_id' => 'string',
        'language' => 'string',
        'email' => 'string',
        'password' => 'string',
        'login' => 'string',
        'namespace' => 'string',
        'family_name' => 'string',
        'first_name' => 'string',
        'missed_call_report' => 'bool',
        'fax_caller_id' => 'string',
        'fax_header' => 'string',
        'fax_cover_page' => 'bool',
        'fax_email_journal' => 'bool'
    ];

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @var string[]
     */
    protected static $swaggerFormats = [
        'id' => 'int32',
        'person_id' => null,
        'language' => null,
        'email' => null,
        'password' => null,
        'login' => null,
        'namespace' => null,
        'family_name' => null,
        'first_name' => null,
        'missed_call_report' => null,
        'fax_caller_id' => null,
        'fax_header' => null,
        'fax_cover_page' => null,
        'fax_email_journal' => null
    ];
    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'id' => 'id',
        'person_id' => 'personId',
        'language' => 'language',
        'email' => 'email',
        'password' => 'password',
        'login' => 'login',
        'namespace' => 'namespace',
        'family_name' => 'familyName',
        'first_name' => 'firstName',
        'missed_call_report' => 'missedCallReport',
        'fax_caller_id' => 'faxCallerId',
        'fax_header' => 'faxHeader',
        'fax_cover_page' => 'faxCoverPage',
        'fax_email_journal' => 'faxEmailJournal'
    ];
    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'id' => 'setId',
        'person_id' => 'setPersonId',
        'language' => 'setLanguage',
        'email' => 'setEmail',
        'password' => 'setPassword',
        'login' => 'setLogin',
        'namespace' => 'setNamespace',
        'family_name' => 'setFamilyName',
        'first_name' => 'setFirstName',
        'missed_call_report' => 'setMissedCallReport',
        'fax_caller_id' => 'setFaxCallerId',
        'fax_header' => 'setFaxHeader',
        'fax_cover_page' => 'setFaxCoverPage',
        'fax_email_journal' => 'setFaxEmailJournal'
    ];
    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'id' => 'getId',
        'person_id' => 'getPersonId',
        'language' => 'getLanguage',
        'email' => 'getEmail',
        'password' => 'getPassword',
        'login' => 'getLogin',
        'namespace' => 'getNamespace',
        'family_name' => 'getFamilyName',
        'first_name' => 'getFirstName',
        'missed_call_report' => 'getMissedCallReport',
        'fax_caller_id' => 'getFaxCallerId',
        'fax_header' => 'getFaxHeader',
        'fax_cover_page' => 'getFaxCoverPage',
        'fax_email_journal' => 'getFaxEmailJournal'
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
        $this->container['id'] = isset($data['id']) ? $data['id'] : null;
        $this->container['person_id'] = isset($data['person_id']) ? $data['person_id'] : null;
        $this->container['language'] = isset($data['language']) ? $data['language'] : null;
        $this->container['email'] = isset($data['email']) ? $data['email'] : null;
        $this->container['password'] = isset($data['password']) ? $data['password'] : null;
        $this->container['login'] = isset($data['login']) ? $data['login'] : null;
        $this->container['namespace'] = isset($data['namespace']) ? $data['namespace'] : null;
        $this->container['family_name'] = isset($data['family_name']) ? $data['family_name'] : null;
        $this->container['first_name'] = isset($data['first_name']) ? $data['first_name'] : null;
        $this->container['missed_call_report'] = isset($data['missed_call_report']) ? $data['missed_call_report'] : null;
        $this->container['fax_caller_id'] = isset($data['fax_caller_id']) ? $data['fax_caller_id'] : null;
        $this->container['fax_header'] = isset($data['fax_header']) ? $data['fax_header'] : null;
        $this->container['fax_cover_page'] = isset($data['fax_cover_page']) ? $data['fax_cover_page'] : null;
        $this->container['fax_email_journal'] = isset($data['fax_email_journal']) ? $data['fax_email_journal'] : null;
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

        if ($this->container['email'] === null) {
            $invalidProperties[] = "'email' can't be null";
        }
        if ($this->container['login'] === null) {
            $invalidProperties[] = "'login' can't be null";
        }
        if ($this->container['family_name'] === null) {
            $invalidProperties[] = "'family_name' can't be null";
        }
        if ($this->container['first_name'] === null) {
            $invalidProperties[] = "'first_name' can't be null";
        }
        return $invalidProperties;
    }

    /**
     * Gets id
     *
     * @return int
     */
    public function getId()
    {
        return $this->container['id'];
    }

    /**
     * Sets id
     *
     * @param int $id the Id of the user
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->container['id'] = $id;

        return $this;
    }

    /**
     * Gets person_id
     *
     * @return string
     */
    public function getPersonId()
    {
        return $this->container['person_id'];
    }

    /**
     * Sets person_id
     *
     * @param string $person_id the Id of the corresponding person contact object
     *
     * @return $this
     */
    public function setPersonId($person_id)
    {
        $this->container['person_id'] = $person_id;

        return $this;
    }

    /**
     * Gets language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->container['language'];
    }

    /**
     * Sets language
     *
     * @param string $language the language of a user
     *
     * @return $this
     */
    public function setLanguage($language)
    {
        $this->container['language'] = $language;

        return $this;
    }

    /**
     * Gets email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->container['email'];
    }

    /**
     * Sets email
     *
     * @param string $email the email address of the user
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->container['email'] = $email;

        return $this;
    }

    /**
     * Gets password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->container['password'];
    }

    /**
     * Sets password
     *
     * @param string $password defines a new password when a user is created or updated. This field will be empty when a user is fetched.
     *
     * @return $this
     */
    public function setPassword($password)
    {
        $this->container['password'] = $password;

        return $this;
    }

    /**
     * Gets login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->container['login'];
    }

    /**
     * Sets login
     *
     * @param string $login the login number for this user. The login number will be used as Jabber Id
     *
     * @return $this
     */
    public function setLogin($login)
    {
        $this->container['login'] = $login;

        return $this;
    }

    /**
     * Gets namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->container['namespace'];
    }

    /**
     * Sets namespace
     *
     * @param string $namespace the namespace defining the location of an user account
     *
     * @return $this
     */
    public function setNamespace($namespace)
    {
        $this->container['namespace'] = $namespace;

        return $this;
    }

    /**
     * Gets family_name
     *
     * @return string
     */
    public function getFamilyName()
    {
        return $this->container['family_name'];
    }

    /**
     * Sets family_name
     *
     * @param string $family_name the family name of the user
     *
     * @return $this
     */
    public function setFamilyName($family_name)
    {
        $this->container['family_name'] = $family_name;

        return $this;
    }

    /**
     * Gets first_name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->container['first_name'];
    }

    /**
     * Sets first_name
     *
     * @param string $first_name the name of the user
     *
     * @return $this
     */
    public function setFirstName($first_name)
    {
        $this->container['first_name'] = $first_name;

        return $this;
    }

    /**
     * Gets missed_call_report
     *
     * @return bool
     */
    public function getMissedCallReport()
    {
        return $this->container['missed_call_report'];
    }

    /**
     * Sets missed_call_report
     *
     * @param bool $missed_call_report whether the user recieves a report on missed calls
     *
     * @return $this
     */
    public function setMissedCallReport($missed_call_report)
    {
        $this->container['missed_call_report'] = $missed_call_report;

        return $this;
    }

    /**
     * Gets fax_caller_id
     *
     * @return string
     */
    public function getFaxCallerId()
    {
        return $this->container['fax_caller_id'];
    }

    /**
     * Sets fax_caller_id
     *
     * @param string $fax_caller_id the callerId for faxes send by this user
     *
     * @return $this
     */
    public function setFaxCallerId($fax_caller_id)
    {
        $this->container['fax_caller_id'] = $fax_caller_id;

        return $this;
    }

    /**
     * Gets fax_header
     *
     * @return string
     */
    public function getFaxHeader()
    {
        return $this->container['fax_header'];
    }

    /**
     * Sets fax_header
     *
     * @param string $fax_header the header for faxes send by this user
     *
     * @return $this
     */
    public function setFaxHeader($fax_header)
    {
        $this->container['fax_header'] = $fax_header;

        return $this;
    }

    /**
     * Gets fax_cover_page
     *
     * @return bool
     */
    public function getFaxCoverPage()
    {
        return $this->container['fax_cover_page'];
    }

    /**
     * Sets fax_cover_page
     *
     * @param bool $fax_cover_page whether to send a cover page for faxes send by this user
     *
     * @return $this
     */
    public function setFaxCoverPage($fax_cover_page)
    {
        $this->container['fax_cover_page'] = $fax_cover_page;

        return $this;
    }

    /**
     * Gets fax_email_journal
     *
     * @return bool
     */
    public function getFaxEmailJournal()
    {
        return $this->container['fax_email_journal'];
    }

    /**
     * Sets fax_email_journal
     *
     * @param bool $fax_email_journal whether the user recieves a email journal of send faxes
     *
     * @return $this
     */
    public function setFaxEmailJournal($fax_email_journal)
    {
        $this->container['fax_email_journal'] = $fax_email_journal;

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


