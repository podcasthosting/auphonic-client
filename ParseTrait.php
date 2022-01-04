<?php
/**
 * User: Fabio Bacigalupo <f.bacigalupo@open-haus.de>
 * Date: 24.02.16
 * Time: 11:26
 */

namespace de\podcaster\Auphonic {

    trait ParseTrait {
        public function __set($name, $value)
        {
            if (property_exists($this, $name)) {
                $this->{$name} = $value;
            }
        }

        public function __get($name)
        {
            if (property_exists($this, $name)) {
                return $this->{$name};
            }

            return null;
        }

        protected static function cast(&$destination, \stdClass $source)
        {
            $sourceReflection = new \ReflectionObject($source);
            $sourceProperties = $sourceReflection->getProperties();

            foreach ($sourceProperties as $sourceProperty) {
                $name = $sourceProperty->getName();
                if (gettype($destination->{$name}) == "object") {
                    self::cast($destination->{$name}, $source->$name);
                } else {
                    $destination->{$name} = $source->$name;
                }
            }
        }

        /**
         * (PHP 5 &gt;= 5.4.0)<br/>
         * Specify data which should be serialized to JSON
         * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
         * @return mixed data which can be serialized by <b>json_encode</b>,
         * which is a value of any type other than a resource.
         */
        public function jsonSerialize()
        {
            return get_object_vars($this);
        }
    }
}