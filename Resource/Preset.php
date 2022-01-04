<?php
namespace de\podcaster\Auphonic\Resource {

    class Preset extends Production
    {
        /**
         * Name of the preset
         *
         * @var string
         */
        protected $preset_name;

        /**
         * @param string $preset_name
         */
        public function setPresetName($preset_name)
        {
            $this->preset_name = $preset_name;
        }

        /**
         * @return string
         */
        public function getPresetName()
        {
            return $this->preset_name;
        }
    }
}