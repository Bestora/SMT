<?php
/**
 * Login
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
use InvalidArgumentException;
use Swagger\Client\ObjectSerializer;

/**
 * Login Class Doc Comment
 *
 * @category Class
 * @description A JSON-Object used for the authentification process. The Server can be asked for a
 *   Template-Login-Object holding a valid nonce and the loginType but no secret. The Template-Login-Object can then be
 *   used to login by filling in the secret of a user.
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class Login implements ModelInterface, ArrayAccess
{
  const DISCRIMINATOR = null;
  const LOGIN_TYPE_INTERNAL = 'Internal';
  const LOGIN_TYPE_ACTIVE_DIRECTORY = 'ActiveDirectory';
  /**
   * The original name of the model.
   *
   * @var string
   */
  protected static $swaggerModelName = 'Login';
  /**
   * Array of property to type mappings. Used for (de)serialization
   *
   * @var string[]
   */
  protected static $swaggerTypes = [
    'login_type' => 'string',
    'nonce' => 'string',
    'secret' => 'string'
  ];
  /**
   * Array of property to format mappings. Used for (de)serialization
   *
   * @var string[]
   */
  protected static $swaggerFormats = [
    'login_type' => null,
    'nonce' => null,
    'secret' => null
  ];
  /**
   * Array of attributes where the key is the local name,
   * and the value is the original name
   *
   * @var string[]
   */
  protected static $attributeMap = [
    'login_type' => 'loginType',
    'nonce' => 'nonce',
    'secret' => 'secret'
  ];
  
  /**
   * Array of attributes to setter functions (for deserialization of responses)
   *
   * @var string[]
   */
  protected static $setters = [
    'login_type' => 'setLoginType',
    'nonce' => 'setNonce',
    'secret' => 'setSecret'
  ];
  
  /**
   * Array of attributes to getter functions (for serialization of requests)
   *
   * @var string[]
   */
  protected static $getters = [
    'login_type' => 'getLoginType',
    'nonce' => 'getNonce',
    'secret' => 'getSecret'
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
    $this->container['login_type'] = isset($data['login_type']) ? $data['login_type'] : null;
    $this->container['nonce'] = isset($data['nonce']) ? $data['nonce'] : null;
    $this->container['secret'] = isset($data['secret']) ? $data['secret'] : null;
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
    
    $allowedValues = $this->getLoginTypeAllowableValues();
    if (!is_null($this->container['login_type']) && !in_array($this->container['login_type'], $allowedValues, true)) {
      $invalidProperties[] = sprintf(
        "invalid value for 'login_type', must be one of '%s'",
        implode("', '", $allowedValues)
      );
    }
    
    if ($this->container['nonce'] === null) {
      $invalidProperties[] = "'nonce' can't be null";
    }
    return $invalidProperties;
  }
  
  /**
   * Gets allowable values of the enum
   *
   * @return string[]
   */
  public function getLoginTypeAllowableValues()
  {
    return [
      self::LOGIN_TYPE_INTERNAL,
      self::LOGIN_TYPE_ACTIVE_DIRECTORY,
    ];
  }
  
  /**
   * Gets login_type
   *
   * @return string
   */
  public function getLoginType()
  {
    return $this->container['login_type'];
  }
  
  /**
   * Sets login_type
   *
   * @param string $login_type The loginType that is configured at the server. Determines the function used to obtain
   *   the user's secret.
   *
   * @return $this
   */
  public function setLoginType($login_type)
  {
    $allowedValues = $this->getLoginTypeAllowableValues();
    if (!is_null($login_type) && !in_array($login_type, $allowedValues, true)) {
      throw new InvalidArgumentException(
        sprintf(
          "Invalid value for 'login_type', must be one of '%s'",
          implode("', '", $allowedValues)
        )
      );
    }
    $this->container['login_type'] = $login_type;
    
    return $this;
  }
  
  /**
   * Gets nonce
   *
   * @return string
   */
  public function getNonce()
  {
    return $this->container['nonce'];
  }
  
  /**
   * Sets nonce
   *
   * @param string $nonce A string provided by the server that can be used to login only once. Only server generated
   *   nonces are valid.
   *
   * @return $this
   */
  public function setNonce($nonce)
  {
    $this->container['nonce'] = $nonce;
    
    return $this;
  }
  
  /**
   * Gets secret
   *
   * @return string
   */
  public function getSecret()
  {
    return $this->container['secret'];
  }
  
  /**
   * Sets secret
   *
   * @param string $secret The secret of a user that is valid for the provided nonce.
   *
   * @return $this
   */
  public function setSecret($secret)
  {
    $this->container['secret'] = $secret;
    
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


