<?php

namespace de\podcaster\Auphonic\Token;

/**
 * Class Owner
 * Interface to implement on a entity that will store the token related to the API user.
 *
 * @package de\podcaster\Token
 */
interface Owner
{
    /**
     * Get the owners token.
     * Returns null if currently no token is connected to this owner.
     *
     * @return Token|null
     */
    public function getToken();

    /**
     * Set new token.
     * Throw Excpetion if token is expired or invalid.
     *
     * @throws \Exception
     *
     * @param Token $token
     */
    public function setToken(Token $token);
}