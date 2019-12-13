<?php
/**
 * FmcPhone
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

use \ArrayAccess;
use \Swagger\Client\ObjectSerializer;

/**
 * FmcPhone Class Doc Comment
 *
 * @category Class
 * @description A representation of an FmcPhone
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class FmcPhone implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'FmcPhone';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'id' => 'string',
        'telephone_id' => 'string',
        'number' => 'string',
        'delay' => 'int',
        'active' => 'bool',
        'confirm' => 'bool',
        'fmc_schedule' => '\Swagger\Client\Model\TimeFrame[]'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'id' => null,
        'telephone_id' => null,
        'number' => null,
        'delay' => null,
        'active' => null,
        'confirm' => null,
        'fmc_schedule' => null
    ];

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
     * @var string[]
     */
    protected static $attributeMap = [
        'id' => 'id',
        'telephone_id' => 'telephoneId',
        'number' => 'number',
        'delay' => 'delay',
        'active' => 'active',
        'confirm' => 'confirm',
        'fmc_schedule' => 'fmcSchedule'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'id' => 'setId',
        'telephone_id' => 'setTelephoneId',
        'number' => 'setNumber',
        'delay' => 'setDelay',
        'active' => 'setActive',
        'confirm' => 'setConfirm',
        'fmc_schedule' => 'setFmcSchedule'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'id' => 'getId',
        'telephone_id' => 'getTelephoneId',
        'number' => 'getNumber',
        'delay' => 'getDelay',
        'active' => 'getActive',
        'confirm' => 'getConfirm',
        'fmc_schedule' => 'getFmcSchedule'
    ];

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
        $this->container['telephone_id'] = isset($data['telephone_id']) ? $data['telephone_id'] : null;
        $this->container['number'] = isset($data['number']) ? $data['number'] : null;
        $this->container['delay'] = isset($data['delay']) ? $data['delay'] : null;
        $this->container['active'] = isset($data['active']) ? $data['active'] : null;
        $this->container['confirm'] = isset($data['confirm']) ? $data['confirm'] : null;
        $this->container['fmc_schedule'] = isset($data['fmc_schedule']) ? $data['fmc_schedule'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['id'] === null) {
            $invalidProperties[] = "'id' can't be null";
        }
        if ($this->container['number'] === null) {
            $invalidProperties[] = "'number' can't be null";
        }
        if ($this->container['delay'] === null) {
            $invalidProperties[] = "'delay' can't be null";
        }
        if ($this->container['confirm'] === null) {
            $invalidProperties[] = "'confirm' can't be null";
        }
        return $invalidProperties;
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
     * @param string $id the Id of the FmcPhone
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->container['id'] = $id;

        return $this;
    }

    /**
     * Gets telephone_id
     *
     * @return string
     */
    public function getTelephoneId()
    {
        return $this->container['telephone_id'];
    }

    /**
     * Sets telephone_id
     *
     * @param string $telephone_id the Id of the corresponding telephone
     *
     * @return $this
     */
    public function setTelephoneId($telephone_id)
    {
        $this->container['telephone_id'] = $telephone_id;

        return $this;
    }

    /**
     * Gets number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->container['number'];
    }

    /**
     * Sets number
     *
     * @param string $number the number that will be called
     *
     * @return $this
     */
    public function setNumber($number)
    {
        $this->container['number'] = $number;

        return $this;
    }

    /**
     * Gets delay
     *
     * @return int
     */
    public function getDelay()
    {
        return $this->container['delay'];
    }

    /**
     * Sets delay
     *
     * @param int $delay defines the delay before the FmcPhone is called
     *
     * @return $this
     */
    public function setDelay($delay)
    {
        $this->container['delay'] = $delay;

        return $this;
    }

    /**
     * Gets active
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->container['active'];
    }

    /**
     * Sets active
     *
     * @param bool $active whether this FmcPhone is activated or deactivated
     *
     * @return $this
     */
    public function setActive($active)
    {
        $this->container['active'] = $active;

        return $this;
    }

    /**
     * Gets confirm
     *
     * @return bool
     */
    public function getConfirm()
    {
        return $this->container['confirm'];
    }

    /**
     * Sets confirm
     *
     * @param bool $confirm whether the user must confirm a call with the FmcPhone
     *
     * @return $this
     */
    public function setConfirm($confirm)
    {
        $this->container['confirm'] = $confirm;

        return $this;
    }

    /**
     * Gets fmc_schedule
     *
     * @return \Swagger\Client\Model\TimeFrame[]
     */
    public function getFmcSchedule()
    {
        return $this->container['fmc_schedule'];
    }

    /**
     * Sets fmc_schedule
     *
     * @param \Swagger\Client\Model\TimeFrame[] $fmc_schedule List of TimeFrames that define when this FmcPhone is called
     *
     * @return $this
     */
    public function setFmcSchedule($fmc_schedule)
    {
        $this->container['fmc_schedule'] = $fmc_schedule;

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
     * @param mixed   $value  Value to be set
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


