<?php
/**
 * User: fabio
 * Date: 08.05.24
 * Time: 10:35
 */

namespace podcasthosting\Auphonic\OAuth;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class Client extends AbstractProvider
{
    const AUPHONIC_URL = 'https://auphonic.com';

    /**
     * @inheritDoc
     */
    public function getBaseAuthorizationUrl()
    {
        return self::AUPHONIC_URL . '/oauth2/authorize/';
    }

    /**
     * @inheritDoc
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return self::AUPHONIC_URL . '/oauth2/token/';
    }

    /**
     * @inheritDoc
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return self::AUPHONIC_URL . '/api/user.json?bearer_token=' . $token->getToken();
    }

    /**
     * @inheritDoc
     */
    protected function getDefaultScopes()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ($response->getStatusCode() >= 400) {
            throw new IdentityProviderException(
                $data['message'] ?? $response->getReasonPhrase(),
                $response->getStatusCode(),
                $response
            );
        }
    }

    /**
     * @inheritDoc
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return (new AuphonicResourceOwner($response))->setDomain(self::AUPHONIC_URL);
    }
}
