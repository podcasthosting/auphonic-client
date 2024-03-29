<?php
namespace podcasthosting\Auphonic\Client;

use podcasthosting\Auphonic\Exception;
use podcasthosting\Auphonic\Client;

class Preset
{
    const APIURL_RESOURCE   = "presets.json";
    const APIURL_DETAIL     = "preset/%s.json";

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
     * @param \podcasthosting\Auphonic\Resource\Preset $preset
     * @return void
     * @throws Exception
     */
    public function create(\podcasthosting\Auphonic\Resource\Preset $preset)
    {
        // create Url object.
        //$url = $this->client->createApiUrl(self::APIURL_RESOURCE);
        $url = self::APIURL_RESOURCE;

        // TODO: Auphonic read data from $preset and create post body

        // get request instance
        $request = $this->client->createRequest('POST', $url);

        $this->client->process($request);
    }

    /**
     * Load a single preset.
     *
     * @param $uuid
     *
     * @return \podcasthosting\Auphonic\Resource\Preset
     */
    public function load($uuid)
    {
        // create Url object.
        $path = sprintf(self::APIURL_DETAIL, $uuid);
        $url = $this->client->createApiUrl($path);

        // create request
        $request = $this->client->createRequest('GET', $url);
        // process request
        $result = $this->client->process($request);

        $preset = $this->client->decode($result, $type = "Preset");

        if(!($preset instanceof \podcasthosting\Auphonic\Resource\Preset)) {
            throw new Exception(sprintf("Preset expected but %s given", get_class($preset)));
        }

        return $preset;
    }

    /**
     * Returns a list with all productions received from auphonic.
     *
     * @return \podcasthosting\Auphonic\Resource\Preset[]
     */
    public function getList()
    {
        $url = $this->client->createApiUrl(self::APIURL_RESOURCE);

        $request = $this->client->createRequest('GET', $url);

        $result = $this->client->process($request);

        $oData = $this->client->decode($result);

        $presets = [];
        if($oData->data && is_array($oData->data)) {
            foreach($oData->data as $presetInformation) {
                $presets[] = $this->load($presetInformation->uuid);
            }
        }

        return $presets;
    }
}
