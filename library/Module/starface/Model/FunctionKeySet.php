<?php
/**
 * FunctionKeySet
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
 * FunctionKeySet Class Doc Comment
 *
 * @category Class
 * @description An ordered set of FunctionKeys that can be used for changing the order of FunctionKeys
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class FunctionKeySet implements ModelInterface, ArrayAccess
{
  const DISCRIMINATOR = null;
  
  /**
   * The original name of the model.
   *
   * @var string
   */
  protected static $swaggerModelName = 'FunctionKeySet';
  
  /**
   * Array of property to type mappings. Used for (de)serialization
   *
   * @var string[]
   */
  protected static $swaggerTypes = [
    'id' => 'string',
    'name' => 'string',
    'key_order' => 'string[]'
  ];
  
  /**
   * Array of property to format mappings. Used for (de)serialization
   *
   * @var string[]
   */
  protected static $swaggerFormats = [
    'id' => null,
    'name' => null,
    'key_order' => null
  ];
  /**
   * Array of attributes where the key is the local name,
   * and the value is the original name
   *
   * @var string[]
   */
  protected static $attributeMap = [
    'id' => 'id',
    'name' => 'name',
    'key_order' => 'keyOrder'
  ];
  /**
   * Array of attributes to setter functions (for deserialization of responses)
   *
   * @var string[]
   */
  protected static $setters = [
    'id' => 'setId',
    'name' => 'setName',
    'key_order' => 'setKeyOrder'
  ];
  /**
   * Array of attributes to getter functions (for serialization of requests)
   *
   * @var string[]
   */
  protected static $getters = [
    'id' => 'getId',
    'name' => 'getName',
    'key_order' => 'getKeyOrder'
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
    $this->container['name'] = isset($data['name']) ? $data['name'] : null;
    $this->container['key_order'] = isset($data['key_order']) ? $data['key_order'] : null;
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
    
    if ($this->container['id'] === null) {
      $invalidProperties[] = "'id' can't be null";
    }
    if ($this->container['name'] === null) {
      $invalidProperties[] = "'name' can't be null";
    }
    if ($this->container['key_order'] === null) {
      $invalidProperties[] = "'key_order' can't be null";
    }
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
   * @param string $id the Id of the FunctionKeySet
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
   * @param string $name the name of the FunctionKeySet
   *
   * @return $this
   */
  public function setName($name)
  {
    $this->container['name'] = $name;
    
    return $this;
  }
  
  /**
   * Gets key_order
   *
   * @return string[]
   */
  public function getKeyOrder()
  {
    return $this->container['key_order'];
  }
  
  /**
   * Sets key_order
   *
   * @param string[] $key_order List of Ids of contained FunctionKeys. The ordering of this List defines the
   *   positioning of the FunctionKeys.
   *
   * @return $this
   */
  public function setKeyOrder($key_order)
  {
    $this->container['key_order'] = $key_order;
    
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


