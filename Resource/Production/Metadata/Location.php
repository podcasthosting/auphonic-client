<?php

namespace de\podcaster\Auphonic\Resource\Production\Metadata {

    use de\podcaster\Auphonic\ParseTrait;

    /**
     * Class Location
     * Subset of the production metadata.
     *
     * @package de\podcaster\Resource\Production\Metadata
     */
    class Location
    {
        use ParseTrait;

        /**
         * Latitude
         *
         * @var float
         */
        protected $latitude;

        /**
         * Longitude
         *
         * @var float
         */
        protected $longitude;

        /**
         * @param float $latitude
         */
        public function setLatitude($latitude)
        {
            $this->latitude = $latitude;
        }

        /**
         * @return float
         */
        public function getLatitude()
        {
            return $this->latitude;
        }

        /**
         * @param float $longitude
         */
        public function setLongitude($longitude)
        {
            $this->longitude = $longitude;
        }

        /**
         * @return float
         */
        public function getLongitude()
        {
            return $this->longitude;
        }
    }
}