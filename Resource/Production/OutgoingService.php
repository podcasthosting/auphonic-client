<?php
namespace de\podcaster\Auphonic\Resource\Production {

    use de\podcaster\Auphonic\ParseTrait;

    class OutgoingService
    {
        use ParseTrait;

        /**
         * Unique ID for this service
         *
         * @var string
         */
        protected $uuid;

        /**
         * Display name of this service
         *
         * @var string
         */
        protected $display_name;

        /**
         * Type of service
         *
         * @var string
         */
        protected $type;

        /**
         * Flag if this service can be used for incoming files
         *
         * @var boolean
         */
        protected $incoming;

        /**
         * Flag if this service can be used for outgoing files
         *
         * @var boolean
         */
        protected $outgoing;
    }
}