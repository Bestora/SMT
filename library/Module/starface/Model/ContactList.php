<?php
/**
 * ContactList
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
 * ContactList Class Doc Comment
 *
 * @category Class
 * @description bandwidth-saving JSON-Object for a list of contacts. Contains schema information that can be used to interpret the summary and phoneNumber values of a contact and the ContactSummary-Objects.
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class ContactList implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'ContactList';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'metadata' => '\Swagger\Client\Model\RequestMetadata',
        'summary_block_schema' => '\Swagger\Client\Model\Block',
        'phone_numbers_block_schema' => '\Swagger\Client\Model\Block',
        'contacts' => '\Swagger\Client\Model\ContactSummary[]'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'metadata' => null,
        'summary_block_schema' => null,
        'phone_numbers_block_schema' => null,
        'contacts' => null
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
        'metadata' => 'metadata',
        'summary_block_schema' => 'summaryBlockSchema',
        'phone_numbers_block_schema' => 'phoneNumbersBlockSchema',
        'contacts' => 'contacts'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'metadata' => 'setMetadata',
        'summary_block_schema' => 'setSummaryBlockSchema',
        'phone_numbers_block_schema' => 'setPhoneNumbersBlockSchema',
        'contacts' => 'setContacts'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'metadata' => 'getMetadata',
        'summary_block_schema' => 'getSummaryBlockSchema',
        'phone_numbers_block_schema' => 'getPhoneNumbersBlockSchema',
        'contacts' => 'getContacts'
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
        $this->container['metadata'] = isset($data['metadata']) ? $data['metadata'] : null;
        $this->container['summary_block_schema'] = isset($data['summary_block_schema']) ? $data['summary_block_schema'] : null;
        $this->container['phone_numbers_block_schema'] = isset($data['phone_numbers_block_schema']) ? $data['phone_numbers_block_schema'] : null;
        $this->container['contacts'] = isset($data['contacts']) ? $data['contacts'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

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
     * Gets metadata
     *
     * @return \Swagger\Client\Model\RequestMetadata
     */
    public function getMetadata()
    {
        return $this->container['metadata'];
    }

    /**
     * Sets metadata
     *
     * @param \Swagger\Client\Model\RequestMetadata $metadata metadata
     *
     * @return $this
     */
    public function setMetadata($metadata)
    {
        $this->container['metadata'] = $metadata;

        return $this;
    }

    /**
     * Gets summary_block_schema
     *
     * @return \Swagger\Client\Model\Block
     */
    public function getSummaryBlockSchema()
    {
        return $this->container['summary_block_schema'];
    }

    /**
     * Sets summary_block_schema
     *
     * @param \Swagger\Client\Model\Block $summary_block_schema summary_block_schema
     *
     * @return $this
     */
    public function setSummaryBlockSchema($summary_block_schema)
    {
        $this->container['summary_block_schema'] = $summary_block_schema;

        return $this;
    }

    /**
     * Gets phone_numbers_block_schema
     *
     * @return \Swagger\Client\Model\Block
     */
    public function getPhoneNumbersBlockSchema()
    {
        return $this->container['phone_numbers_block_schema'];
    }

    /**
     * Sets phone_numbers_block_schema
     *
     * @param \Swagger\Client\Model\Block $phone_numbers_block_schema phone_numbers_block_schema
     *
     * @return $this
     */
    public function setPhoneNumbersBlockSchema($phone_numbers_block_schema)
    {
        $this->container['phone_numbers_block_schema'] = $phone_numbers_block_schema;

        return $this;
    }

    /**
     * Gets contacts
     *
     * @return \Swagger\Client\Model\ContactSummary[]
     */
    public function getContacts()
    {
        return $this->container['contacts'];
    }

    /**
     * Sets contacts
     *
     * @param \Swagger\Client\Model\ContactSummary[] $contacts List of ContactSummary
     *
     * @return $this
     */
    public function setContacts($contacts)
    {
        $this->container['contacts'] = $contacts;

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

