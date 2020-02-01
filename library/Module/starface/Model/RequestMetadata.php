<?php
/**
 * RequestMetadata
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
 * RequestMetadata Class Doc Comment
 *
 * @category Class
 * @description Metadata for a request that returns data for multiple entities. This includes pageing and sorting properties.
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class RequestMetadata implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;
    const SORTDIRECTION_ASC = 'ASC';
    const SORTDIRECTION_DESC = 'DESC';
    /**
     * The original name of the model.
     *
     * @var string
     */
    protected static $swaggerModelName = 'RequestMetadata';
    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @var string[]
     */
    protected static $swaggerTypes = [
        'page' => 'int',
        'pagesize' => 'int',
        'sort' => 'string',
        'sortdirection' => 'string',
        'total_pages' => 'int'
    ];
    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @var string[]
     */
    protected static $swaggerFormats = [
        'page' => 'int32',
        'pagesize' => 'int32',
        'sort' => null,
        'sortdirection' => null,
        'total_pages' => 'int32'
    ];
    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'page' => 'page',
        'pagesize' => 'pagesize',
        'sort' => 'sort',
        'sortdirection' => 'sortdirection',
        'total_pages' => 'totalPages'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'page' => 'setPage',
        'pagesize' => 'setPagesize',
        'sort' => 'setSort',
        'sortdirection' => 'setSortdirection',
        'total_pages' => 'setTotalPages'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'page' => 'getPage',
        'pagesize' => 'getPagesize',
        'sort' => 'getSort',
        'sortdirection' => 'getSortdirection',
        'total_pages' => 'getTotalPages'
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
        $this->container['page'] = isset($data['page']) ? $data['page'] : null;
        $this->container['pagesize'] = isset($data['pagesize']) ? $data['pagesize'] : null;
        $this->container['sort'] = isset($data['sort']) ? $data['sort'] : null;
        $this->container['sortdirection'] = isset($data['sortdirection']) ? $data['sortdirection'] : null;
        $this->container['total_pages'] = isset($data['total_pages']) ? $data['total_pages'] : null;
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

        $allowedValues = $this->getSortdirectionAllowableValues();
        if (!is_null($this->container['sortdirection']) && !in_array($this->container['sortdirection'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'sortdirection', must be one of '%s'",
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
    public function getSortdirectionAllowableValues()
    {
        return [
            self::SORTDIRECTION_ASC,
            self::SORTDIRECTION_DESC,
        ];
    }

    /**
     * Gets page
     *
     * @return int
     */
    public function getPage()
    {
        return $this->container['page'];
    }

    /**
     * Sets page
     *
     * @param int $page The 0-indexed page number.
     *
     * @return $this
     */
    public function setPage($page)
    {
        $this->container['page'] = $page;

        return $this;
    }

    /**
     * Gets pagesize
     *
     * @return int
     */
    public function getPagesize()
    {
        return $this->container['pagesize'];
    }

    /**
     * Sets pagesize
     *
     * @param int $pagesize The pagesize used for the request. Indicates the row count of data that has just been returned.
     *
     * @return $this
     */
    public function setPagesize($pagesize)
    {
        $this->container['pagesize'] = $pagesize;

        return $this;
    }

    /**
     * Gets sort
     *
     * @return string
     */
    public function getSort()
    {
        return $this->container['sort'];
    }

    /**
     * Sets sort
     *
     * @param string $sort The fieldname that has been used sort the entities.
     *
     * @return $this
     */
    public function setSort($sort)
    {
        $this->container['sort'] = $sort;

        return $this;
    }

    /**
     * Gets sortdirection
     *
     * @return string
     */
    public function getSortdirection()
    {
        return $this->container['sortdirection'];
    }

    /**
     * Sets sortdirection
     *
     * @param string $sortdirection The sort direction that has been used. Either ASC for ascending or DESC for descending.
     *
     * @return $this
     */
    public function setSortdirection($sortdirection)
    {
        $allowedValues = $this->getSortdirectionAllowableValues();
        if (!is_null($sortdirection) && !in_array($sortdirection, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'sortdirection', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['sortdirection'] = $sortdirection;

        return $this;
    }

    /**
     * Gets total_pages
     *
     * @return int
     */
    public function getTotalPages()
    {
        return $this->container['total_pages'];
    }

    /**
     * Sets total_pages
     *
     * @param int $total_pages The total number of pages that are available.
     *
     * @return $this
     */
    public function setTotalPages($total_pages)
    {
        $this->container['total_pages'] = $total_pages;

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


