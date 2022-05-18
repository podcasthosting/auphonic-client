<?php
namespace podcasthosting\Auphonic\Client {

    use podcasthosting\Auphonic\Client;
    use podcasthosting\Auphonic\Exception;

    class Production
    {
        const APIURL_RESOURCE = "productions.json";
        const APIURL_START = "production/{uuid}/start.json";
        // Details about a Production
        // curl https://auphonic.com/api/production/{uuid}.json -u username:password
        const APIURL_DETAILS = "production/{uuid}.json";

        /**
         * HTTP client dependency
         *
         * @var Client
         */
        protected $client;

        /**
         * Dependency injection
         *
         * @param Client $client
         */
        public function setClient($client)
        {
            $this->client = $client;
        }

        /**
         * @param \podcasthosting\Auphonic\Resource\Production $production
         * @return \podcasthosting\Auphonic\Resource\Production
         * @throws Exception
         */
        public function create(\podcasthosting\Auphonic\Resource\Production $production, $preset = null, $webhook = null)
        {
            // create Url object.
            $url = $this->client->createApiUrl(self::APIURL_RESOURCE);
            // get request instance
            $request = $this->client->createRequest('POST', $url);

            $aData = [
                'metadata' => $production->getMetadata()
            ];

            if ($preset && !is_null($preset)) {
                $aData['preset'] = $preset;
            }

            if ($webhook && !is_null($webhook)) {
                $aData['webhook'] = $webhook;
            }

            $request = array_merge($request, $aData);

            $result = $this->client->process($request);

            $production = $this->client->decode($result, 'production');

            if (!($production instanceof \podcasthosting\Auphonic\Resource\Production)) {
                throw new Exception(sprintf("Production expected but %s given",
                    get_class($production)));
            }

            return $production;
        }

        public function start($uuid)
        {
            // create Url object.
            $url = $this->client->createApiUrl(str_replace('{uuid}', $uuid, self::APIURL_START));
            // get request instance
            $request = $this->client->createRequest('POST', $url);

            $result = $this->client->process($request);

            $production = $this->client->decode($result, 'production');

            if (!($production instanceof \podcasthosting\Auphonic\Resource\Production)) {
                throw new Exception(sprintf("Production expected but %s given",
                    get_class($production)));
            }

            return $production;
        }

        public function get($uuid)
        {
            // create Url object.
            $url = $this->client->createApiUrl(str_replace('{uuid}', $uuid, self::APIURL_DETAILS));
            // get request instance
            $request = $this->client->createRequest('GET', $url);

            $result = $this->client->process($request);

            $production = $this->client->decode($result, 'production');

            if (!($production instanceof \podcasthosting\Auphonic\Resource\Production)) {
                throw new Exception(sprintf("Production expected but %s given",
                    get_class($production)));
            }

            return $production;
        }

        /**
         * Returns a list with all productions received from auphonic.
         *
         * @return \podcasthosting\Auphonic\Resource\Production[]
         */
        public function getList()
        {
            $url = $this->client->createApiUrl(self::APIURL_RESOURCE);

            $request = $this->client->createRequest('GET', $url);

            $result = json_decode($this->client->process($request));

            $productions = [];

            if($result->data && is_array($result->data)) {
                foreach($result->data as $production) {
                    $productions[] = $this->client->convert($production, 'production');
                }
            }

            return $productions;
        }

        public function download($url)
        {
            // get request instance
            $request = $this->client->createRequest('GET', $url);

            return $this->client->process($request);
        }
    }
}
