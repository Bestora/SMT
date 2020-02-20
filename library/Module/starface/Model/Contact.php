<?php
/**
 * Contact
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
 * Contact Class Doc Comment
 *
 * @category Class
 * @description Contact detail information
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class Contact implements ModelInterface, ArrayAccess
{
  const DISCRIMINATOR = null;
  
  /**
   * The original name of the model.
   *
   * @var string
   */
  protected static $swaggerModelName = 'Contact';
  
  /**
   * Array of property to type mappings. Used for (de)serialization
   *
   * @var string[]
   */
  protected static $swaggerTypes = [
    'id' => 'string',
    'jabber_id' => 'string',
    'account_id' => 'int',
    'primary_external_number' => 'string',
    'primary_internal_number' => 'string',
    'editable' => 'bool',
    'tags' => '\Swagger\Client\Model\Tag[]',
    'blocks' => '\Swagger\Client\Model\Block[]'
  ];
  
  /**
   * Array of property to format mappings. Used for (de)serialization
   *
   * @var string[]
   */
  protected static $swaggerFormats = [
    'id' => null,
    'jabber_id' => null,
    'account_id' => 'int32',
    'primary_external_number' => null,
    'primary_internal_number' => null,
    'editable' => null,
    'tags' => null,
    'blocks' => null
  ];
  /**
   * Array of attributes where the key is the local name,
   * and the value is the original name
   *
   * @var string[]
   */
  protected static $attributeMap = [
    'id' => 'id',
    'jabber_id' => 'jabberId',
    'account_id' => 'accountId',
    'primary_external_number' => 'primaryExternalNumber',
    'primary_internal_number' => 'primaryInternalNumber',
    'editable' => 'editable',
    'tags' => 'tags',
    'blocks' => 'blocks'
  ];
  /**
   * Array of attributes to setter functions (for deserialization of responses)
   *
   * @var string[]
   */
  protected static $setters = [
    'id' => 'setId',
    'jabber_id' => 'setJabberId',
    'account_id' => 'setAccountId',
    'primary_external_number' => 'setPrimaryExternalNumber',
    'primary_internal_number' => 'setPrimaryInternalNumber',
    'editable' => 'setEditable',
    'tags' => 'setTags',
    'blocks' => 'setBlocks'
  ];
  /**
   * Array of attributes to getter functions (for serialization of requests)
   *
   * @var string[]
   */
  protected static $getters = [
    'id' => 'getId',
    'jabber_id' => 'getJabberId',
    'account_id' => 'getAccountId',
    'primary_external_number' => 'getPrimaryExternalNumber',
    'primary_internal_number' => 'getPrimaryInternalNumber',
    'editable' => 'getEditable',
    'tags' => 'getTags',
    'blocks' => 'getBlocks'
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
    $this->container['jabber_id'] = isset($data['jabber_id']) ? $data['jabber_id'] : null;
    $this->container['account_id'] = isset($data['account_id']) ? $data['account_id'] : null;
    $this->container['primary_external_number'] = isset($data['primary_external_number']) ? $data['primary_external_number'] : null;
    $this->container['primary_internal_number'] = isset($data['primary_internal_number']) ? $data['primary_internal_number'] : null;
    $this->container['editable'] = isset($data['editable']) ? $data['editable'] : null;
    $this->container['tags'] = isset($data['tags']) ? $data['tags'] : null;
    $this->container['blocks'] = isset($data['blocks']) ? $data['blocks'] : null;
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
    
    return $invalidProperties;
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
   * @param string $id the Id of a contact
   *
   * @return $this
   */
  public function setId($id)
  {
    $this->container['id'] = $id;
    
    return $this;
  }
  
  /**
   * Gets jabber_id
   *
   * @return string
   */
  public function getJabberId()
  {
    return $this->container['jabber_id'];
  }
  
  /**
   * Sets jabber_id
   *
   * @param string $jabber_id if this contact is representing a user then the user's jabberId, otherwise empty
   *
   * @return $this
   */
  public function setJabberId($jabber_id)
  {
    $this->container['jabber_id'] = $jabber_id;
    
    return $this;
  }
  
  /**
   * Gets account_id
   *
   * @return int
   */
  public function getAccountId()
  {
    return $this->container['account_id'];
  }
  
  /**
   * Sets account_id
   *
   * @param int $account_id if this contact is representing a user then the user's accountId, otherwise empty
   *
   * @return $this
   */
  public function setAccountId($account_id)
  {
    $this->container['account_id'] = $account_id;
    
    return $this;
  }
  
  /**
   * Gets primary_external_number
   *
   * @return string
   */
  public function getPrimaryExternalNumber()
  {
    return $this->container['primary_external_number'];
  }
  
  /**
   * Sets primary_external_number
   *
   * @param string $primary_external_number if this contact is representing a user then the user's primary external
   *   phone number, otherwise empty
   *
   * @return $this
   */
  public function setPrimaryExternalNumber($primary_external_number)
  {
    $this->container['primary_external_number'] = $primary_external_number;
    
    return $this;
  }
  
  /**
   * Gets primary_internal_number
   *
   * @return string
   */
  public function getPrimaryInternalNumber()
  {
    return $this->container['primary_internal_number'];
  }
  
  /**
   * Sets primary_internal_number
   *
   * @param string $primary_internal_number if this contact is representing a user then the user's primary internal
   *   phone number, otherwise empty
   *
   * @return $this
   */
  public function setPrimaryInternalNumber($primary_internal_number)
  {
    $this->container['primary_internal_number'] = $primary_internal_number;
    
    return $this;
  }
  
  /**
   * Gets editable
   *
   * @return bool
   */
  public function getEditable()
  {
    return $this->container['editable'];
  }
  
  /**
   * Sets editable
   *
   * @param bool $editable flag whether this contact can be edited
   *
   * @return $this
   */
  public function setEditable($editable)
  {
    $this->container['editable'] = $editable;
    
    return $this;
  }
  
  /**
   * Gets tags
   *
   * @return Tag[]
   */
  public function getTags()
  {
    return $this->container['tags'];
  }
  
  /**
   * Sets tags
   *
   * @param Tag[] $tags List of Tags this contact can be found under
   *
   * @return $this
   */
  public function setTags($tags)
  {
    $this->container['tags'] = $tags;
    
    return $this;
  }
  
  /**
   * Gets blocks
   *
   * @return Block[]
   */
  public function getBlocks()
  {
    return $this->container['blocks'];
  }
  
  /**
   * Sets blocks
   *
   * @param Block[] $blocks List of Blocks holding the detail information
   *
   * @return $this
   */
  public function setBlocks($blocks)
  {
    $this->container['blocks'] = $blocks;
    
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


