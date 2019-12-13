<?php
/**
 * ContactsScheme
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
 * ContactsScheme Class Doc Comment
 *
 * @category Class
 * @description The schema for the addressbook that is configured at the server. Describing the structure of Contact-Objects and the values of ContactSummary-Objects.
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class ContactsScheme implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'ContactsScheme';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'summary_block' => '\Swagger\Client\Model\Block',
        'phone_numbers_block' => '\Swagger\Client\Model\Block',
        'detail_blocks' => '\Swagger\Client\Model\Block[]'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'summary_block' => null,
        'phone_numbers_block' => null,
        'detail_blocks' => null
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
        'summary_block' => 'summaryBlock',
        'phone_numbers_block' => 'phoneNumbersBlock',
        'detail_blocks' => 'detailBlocks'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'summary_block' => 'setSummaryBlock',
        'phone_numbers_block' => 'setPhoneNumbersBlock',
        'detail_blocks' => 'setDetailBlocks'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'summary_block' => 'getSummaryBlock',
        'phone_numbers_block' => 'getPhoneNumbersBlock',
        'detail_blocks' => 'getDetailBlocks'
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
        $this->container['summary_block'] = isset($data['summary_block']) ? $data['summary_block'] : null;
        $this->container['phone_numbers_block'] = isset($data['phone_numbers_block']) ? $data['phone_numbers_block'] : null;
        $this->container['detail_blocks'] = isset($data['detail_blocks']) ? $data['detail_blocks'] : null;
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
     * Gets summary_block
     *
     * @return \Swagger\Client\Model\Block
     */
    public function getSummaryBlock()
    {
        return $this->container['summary_block'];
    }

    /**
     * Sets summary_block
     *
     * @param \Swagger\Client\Model\Block $summary_block A Block describing the structure of the summaryValue-Field of a ContactSummary-Object
     *
     * @return $this
     */
    public function setSummaryBlock($summary_block)
    {
        $this->container['summary_block'] = $summary_block;

        return $this;
    }

    /**
     * Gets phone_numbers_block
     *
     * @return \Swagger\Client\Model\Block
     */
    public function getPhoneNumbersBlock()
    {
        return $this->container['phone_numbers_block'];
    }

    /**
     * Sets phone_numbers_block
     *
     * @param \Swagger\Client\Model\Block $phone_numbers_block A Block describing the structure of the phoneNumberValues-Field of a ContactSummary-Object
     *
     * @return $this
     */
    public function setPhoneNumbersBlock($phone_numbers_block)
    {
        $this->container['phone_numbers_block'] = $phone_numbers_block;

        return $this;
    }

    /**
     * Gets detail_blocks
     *
     * @return \Swagger\Client\Model\Block[]
     */
    public function getDetailBlocks()
    {
        return $this->container['detail_blocks'];
    }

    /**
     * Sets detail_blocks
     *
     * @param \Swagger\Client\Model\Block[] $detail_blocks A Block describing the structure of values of a Contact-Object
     *
     * @return $this
     */
    public function setDetailBlocks($detail_blocks)
    {
        $this->container['detail_blocks'] = $detail_blocks;

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


