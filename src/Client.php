<?php

namespace podcasthosting\Auphonic {

    use Buzz\Browser;
    use GuzzleHttp\Psr7\Request;
    use podcasthosting\Auphonic\Client\Preset;
    use podcasthosting\Auphonic\Client\Production;
    use podcasthosting\Auphonic\Token\Token;
    use Psr\Http\Message\RequestInterface;

    class Client
    {
        use ParseTrait;

        const API_BASEURL = "https://auphonic.com/api/";

        /**
         * HTTP client dependency.
         *
         * @var Browser
         */
        protected $browser;

        /**
         * API authentication token.
         * If none is given the request will be done without any authentification.
         *
         * @var null|string
         */
        protected $token;

        /**
         * Auphonic username to use for authentification.
         * To use user:password authentification you need to allow that explicitly.
         *
         * @see allowUserPasswordAuthentification()
         *
         * @var null|string
         */
        protected $username;

        /**
         * Auphonic password to use for authentification.
         * To use user:password authentification you need to allow that explicitly.
         *
         * @see allowUserPasswordAuthentification()
         *
         * @var null|string
         */
        protected $password;

        /**
         * Flag for username and password authentification.
         * If true a user:password authentification per request is possible.
         *
         * @var boolean
         */
        protected $allowUserPasswordAuthentification = false;

        /**
         * Available resource subsets
         *
         * @var array
         */
        protected $resourceSubsets;

        /**
         * Production API subset dependency
         *
         * @var Production
         */
        protected $production;

        /**
         * Preset API subset dependency
         *
         * @var Preset
         */
        protected $preset;

        /**
         * Setter injection.
         * Set HTTP client.
         *
         * @param Browser $browser
         */
        public function setBrowser(Browser $browser)
        {
            $this->browser = $browser;
        }

        public function getBrowser()
        {
            return $this->browser;
        }

        /**
         * Setter injection.
         * Set api token for authentification.
         *
         * @param string|null $token
         */
        public function setToken($token)
        {
            $this->token = $token;
        }

        /**
         * @param null|string $password
         */
        public function setPassword($password)
        {
            $this->password = $password;
        }

        /**
         * @param null|string $username
         */
        public function setUsername($username)
        {
            $this->username = $username;
        }

        /**
         * Add a resource subset
         *
         * @param string $fieldname
         * @param string $class
         */
        public function addResourceSubset($fieldname, $class)
        {
            $this->resourceSubsets[$fieldname] = $class;
        }

        /**
         * If you need to use the authentication with username and password you need to explicitly allow this option.
         * If a token exists the token is used for authentication.
         *
         * The username and the password are send in plaintext in every request!
         * The connection uses https but this is still unsecure and you should only do this if token usage is impossible.
         *
         * @param bool $enable
         */
        public function allowUserPasswordAuthentification($enable = true)
        {
            $this->allowUserPasswordAuthentification = $enable;
        }

        /**
         * Setter injection.
         * Set production API subset class.
         *
         * @param Production $production
         */
        public function setProduction(Production $production)
        {
            $this->production = $production;
            $this->production->setClient($this);
        }

        /**
         * Setter injection.
         * Set preset API subset class.
         *
         * @param Preset $preset
         */
        public function setPreset(Preset $preset)
        {
            $this->preset = $preset;
            $this->preset->setClient($this);
        }

        /**
         * Processes the request and returns the
         *
         * @param RequestInterface $request
         *
         * @throws Exception
         */
        public function process(array $request)
        {
            $client = new \GuzzleHttp\Client();
            $request = new Request($request['method'], $request['url'], $request['headers']);
            $response = $client->send($request);

            if ($response->getStatusCode() !== 200) {
                throw new Exception(sprintf("Invalid status code '%s'.", $response->getStatusCode()));
            }

            return $response->getBody()->getContents();
        }

        /**
         * Create a new request
         *
         * @param string $method
         * @param string $url
         * @return
         */
        public function createRequest(string $method, $url)
        {
            // create new request
            $request = [
                'method' => $method,
                'url' => $url,
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ];

            // add token if given
            if ($this->token) {
                /**
                 * generate header for OAuth2 bearer token
                 * http://self-issued.info/docs/draft-ietf-oauth-v2-bearer.html
                 */
                $request['headers']['Authorization'] = sprintf("Bearer %s", $this->token);
            } elseif ($this->allowUserPasswordAuthentification) {
                /**
                 * generate header for HTTP basic auth
                 * http://en.wikipedia.org/wiki/Basic_access_authentication
                 */
                // create concat string with username and password
                $usernamepassword = sprintf("%s:%s", $this->username, $this->password);
                // encode with base64
                $base64Encoded = base64_encode($usernamepassword);
                // set header
//                $request = $request->withAddedHeader("Authorization", sprintf("Basic %s", $base64Encoded));
                $request['headers']['Authorization'] = sprintf("Basic %s", $base64Encoded);
            }
            // set content type header
            return $request;
        }

        /**
         * Creates a url object with the auphonic api base url and appends the $path
         *
         * @param string $path
         * @return string
         */
        public function createApiUrl(string $path): string
        {
            return sprintf("%s%s", Client::API_BASEURL, $path);
        }

        /**
         * Return the production api
         *
         * @return Production
         */
        public function production()
        {
            return $this->production;
        }

        public function preset()
        {
            return $this->preset;
        }

        public function decode($content, $type = null)
        {
            $result = json_decode($content);
            $type = strtolower($type);

            switch($type) {
                case "preset":
                case "production":
                    $result = $result->data;
            }

            return $this->convert($result, $type);
        }

        public function convert($result, $type = null)
        {
            $type = strtolower($type);

            switch($type) {
                case "preset":
                    $oPreset = new Resource\Preset();
                    self::cast($oPreset, $result);

                    return $oPreset;
                case "production":
                    $oProduction = new Resource\Production();
                    self::cast($oProduction, $result);

                    return $oProduction;
                default:
                    return $result;
            }
        }
    }
}
