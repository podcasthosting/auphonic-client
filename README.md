# auphonic-client
A PHP library to access the audio service [Auphonic](https://auphonic.com) through its API.

**Usage**

~~~ 
        $token = ''; // Your Auphonic API token
        $client = new \podcasthosting\Auphonic\Client();
        $client->setToken($token);
        $client->setPreset(new \podcasthosting\Auphonic\Client\Preset());
        $presets = $client->preset()->getList();
~~~

Used and created by [Podcast Hosting service podcaster](https://www.podcaster.de)
