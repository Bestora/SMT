<?php
/**
 * FunctionKeyUserInfo
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
 * FunctionKeyUserInfo Class Doc Comment
 *
 * @category Class
 * @description Defines additional user information that are provided for FunctionKeys of type BUSYLAMPFIELD
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class FunctionKeyUserInfo implements ModelInterface, ArrayAccess
{
  const DISCRIMINATOR = null;
  
  /**
   * The original name of the model.
   *
   * @var string
   */
  protected static $swaggerModelName = 'FunctionKeyUserInfo';
  
  /**
   * Array of property to type mappings. Used for (de)serialization
   *
   * @var string[]
   */
  protected static $swaggerTypes = [
    'chat_id' => 'string',
    'email' => 'string',
    'phone_number' => 'string',
    'phonenumber2' => 'string',
    'mobile_phone_number' => 'string',
    'home_phone_number' => 'string',
    'internal_phone_number' => 'string',
    'fax' => 'string'
  ];
  
  /**
   * Array of property to format mappings. Used for (de)serialization
   *
   * @var string[]
   */
  protected static $swaggerFormats = [
    'chat_id' => null,
    'email' => null,
    'phone_number' => null,
    'phonenumber2' => null,
    'mobile_phone_number' => null,
    'home_phone_number' => null,
    'internal_phone_number' => null,
    'fax' => null
  ];
  /**
   * Array of attributes where the key is the local name,
   * and the value is the original name
   *
   * @var string[]
   */
  protected static $attributeMap = [
    'chat_id' => 'chatId',
    'email' => 'email',
    'phone_number' => 'phoneNumber',
    'phonenumber2' => 'phonenumber2',
    'mobile_phone_number' => 'mobilePhoneNumber',
    'home_phone_number' => 'homePhoneNumber',
    'internal_phone_number' => 'internalPhoneNumber',
    'fax' => 'fax'
  ];
  /**
   * Array of attributes to setter functions (for deserialization of responses)
   *
   * @var string[]
   */
  protected static $setters = [
    'chat_id' => 'setChatId',
    'email' => 'setEmail',
    'phone_number' => 'setPhoneNumber',
    'phonenumber2' => 'setPhonenumber2',
    'mobile_phone_number' => 'setMobilePhoneNumber',
    'home_phone_number' => 'setHomePhoneNumber',
    'internal_phone_number' => 'setInternalPhoneNumber',
    'fax' => 'setFax'
  ];
  /**
   * Array of attributes to getter functions (for serialization of requests)
   *
   * @var string[]
   */
  protected static $getters = [
    'chat_id' => 'getChatId',
    'email' => 'getEmail',
    'phone_number' => 'getPhoneNumber',
    'phonenumber2' => 'getPhonenumber2',
    'mobile_phone_number' => 'getMobilePhoneNumber',
    'home_phone_number' => 'getHomePhoneNumber',
    'internal_phone_number' => 'getInternalPhoneNumber',
    'fax' => 'getFax'
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
    $this->container['chat_id'] = isset($data['chat_id']) ? $data['chat_id'] : null;
    $this->container['email'] = isset($data['email']) ? $data['email'] : null;
    $this->container['phone_number'] = isset($data['phone_number']) ? $data['phone_number'] : null;
    $this->container['phonenumber2'] = isset($data['phonenumber2']) ? $data['phonenumber2'] : null;
    $this->container['mobile_phone_number'] = isset($data['mobile_phone_number']) ? $data['mobile_phone_number'] : null;
    $this->container['home_phone_number'] = isset($data['home_phone_number']) ? $data['home_phone_number'] : null;
    $this->container['internal_phone_number'] = isset($data['internal_phone_number']) ? $data['internal_phone_number'] : null;
    $this->container['fax'] = isset($data['fax']) ? $data['fax'] : null;
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
   * Gets chat_id
   *
   * @return string
   */
  public function getChatId()
  {
    return $this->container['chat_id'];
  }
  
  /**
   * Sets chat_id
   *
   * @param string $chat_id chat_id
   *
   * @return $this
   */
  public function setChatId($chat_id)
  {
    $this->container['chat_id'] = $chat_id;
    
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
   * @param string $email email
   *
   * @return $this
   */
  public function setEmail($email)
  {
    $this->container['email'] = $email;
    
    return $this;
  }
  
  /**
   * Gets phone_number
   *
   * @return string
   */
  public function getPhoneNumber()
  {
    return $this->container['phone_number'];
  }
  
  /**
   * Sets phone_number
   *
   * @param string $phone_number phone_number
   *
   * @return $this
   */
  public function setPhoneNumber($phone_number)
  {
    $this->container['phone_number'] = $phone_number;
    
    return $this;
  }
  
  /**
   * Gets phonenumber2
   *
   * @return string
   */
  public function getPhonenumber2()
  {
    return $this->container['phonenumber2'];
  }
  
  /**
   * Sets phonenumber2
   *
   * @param string $phonenumber2 phonenumber2
   *
   * @return $this
   */
  public function setPhonenumber2($phonenumber2)
  {
    $this->container['phonenumber2'] = $phonenumber2;
    
    return $this;
  }
  
  /**
   * Gets mobile_phone_number
   *
   * @return string
   */
  public function getMobilePhoneNumber()
  {
    return $this->container['mobile_phone_number'];
  }
  
  /**
   * Sets mobile_phone_number
   *
   * @param string $mobile_phone_number mobile_phone_number
   *
   * @return $this
   */
  public function setMobilePhoneNumber($mobile_phone_number)
  {
    $this->container['mobile_phone_number'] = $mobile_phone_number;
    
    return $this;
  }
  
  /**
   * Gets home_phone_number
   *
   * @return string
   */
  public function getHomePhoneNumber()
  {
    return $this->container['home_phone_number'];
  }
  
  /**
   * Sets home_phone_number
   *
   * @param string $home_phone_number home_phone_number
   *
   * @return $this
   */
  public function setHomePhoneNumber($home_phone_number)
  {
    $this->container['home_phone_number'] = $home_phone_number;
    
    return $this;
  }
  
  /**
   * Gets internal_phone_number
   *
   * @return string
   */
  public function getInternalPhoneNumber()
  {
    return $this->container['internal_phone_number'];
  }
  
  /**
   * Sets internal_phone_number
   *
   * @param string $internal_phone_number internal_phone_number
   *
   * @return $this
   */
  public function setInternalPhoneNumber($internal_phone_number)
  {
    $this->container['internal_phone_number'] = $internal_phone_number;
    
    return $this;
  }
  
  /**
   * Gets fax
   *
   * @return string
   */
  public function getFax()
  {
    return $this->container['fax'];
  }
  
  /**
   * Sets fax
   *
   * @param string $fax fax
   *
   * @return $this
   */
  public function setFax($fax)
  {
    $this->container['fax'] = $fax;
    
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


