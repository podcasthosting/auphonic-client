<?php

namespace de\podcaster\Auphonic\Token;

use de\podcaster\Auphonic\Exception;

/**
 * Class Token
 * Representation of an auphonic API token.
 *
 * @package de\podcaster\Token
 */
class Token implements \Serializable {

    const ID_TOKEN      = "token";
    const ID_EXPIRE     = "expire";
    const ID_TYPE       = "type";
    const ID_SCOPE      = "scope";

    /**
     * The token string.
     *
     * @var string
     */
    protected $token;

    /**
     * Timestamp of the expiration date.
     *
     * @var int
     */
    protected $expire;

    /**
     * Token type.
     * Should be "bearer" as said in the API documentation.
     *
     * @var string
     */
    protected $type;

    /**
     * Token scope.
     * Should be empty but this field is provided by the API anyway and may be used sometime in the future.
     *
     * @var string
     */
    protected $scope;

    /**
     * Constructor.
     * Create a new token object by providing at least the token string and the expiration date.
     * Type and scope are optional.
     *
     * @param string $token
     * @param int $expire
     * @param string $type [optional]
     * @param string $scope [optional]
     */
    public function __construct($token, $expire, $type = "bearer", $scope = "")
    {
        $this->token = $token;
        $this->expire = $expire;

        if(isset($type)) {
            $this->type = $type;
        }

        if(isset($scope)) {
            $this->scope = $scope;
        }
    }

    /**
     * Set expire date.
     *
     * @param int $expire
     */
    public function setExpire($expire)
    {
        $this->expire = $expire;
    }

    /**
     * Get expire date.
     *
     * @return int
     */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     * Set token scope.
     *
     * @param string $scope
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
    }

    /**
     * Get token scope.
     *
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Set token string.
     *
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Get token string.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set token type.
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get token type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns true if the token is already expired.
     * Returns false otherwise.
     * If no expire date is set an exception is thrown.
     *
     * @throws Exception
     *
     * @return bool
     */
    public function isExpired() {
        if(!$this->getExpire()) {
            throw new Exception("No expire date set for this token.");
        }
        return $this->getExpire() <= time();
    }

    /**
     * String representation of object.
     *
     * @link http://php.net/manual/en/serializable.serialize.php
     *
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return json_encode(
            array(
                self::ID_TOKEN  => $this->getToken(),
                self::ID_EXPIRE => $this->getExpire(),
                self::ID_TYPE   => $this->getType(),
                self::ID_SCOPE  => $this->getScope(),
            )
        );
    }

    /**
     * Constructs the object.
     * This method will never throw an exception. If the string is corrupted or the token cannot be constructed
     * the properties wont be changed/filled.
     *
     * @link http://php.net/manual/en/serializable.unserialize.php
     *
     * @param string $serialized The string representation of the object.
     *
     * @return void
     */
    public function unserialize($serialized)
    {
        $data = json_decode($serialized);

        // check if data is an array
        if(is_array($data)) {
            // set token
            if(array_key_exists(self::ID_TOKEN, $data)) {
                $this->setToken($data[self::ID_TOKEN]);
            }
            // set expiration date
            if(array_key_exists(self::ID_EXPIRE, $data)) {
                $this->setExpire($data[self::ID_EXPIRE]);
            }
            // set token type
            if(array_key_exists(self::ID_TYPE, $data)) {
                $this->setType($data[self::ID_TYPE]);
            }
            // set token scope
            if(array_key_exists(self::ID_SCOPE, $data)) {
                $this->setScope($data[self::ID_SCOPE]);
            }
        }
    }
}