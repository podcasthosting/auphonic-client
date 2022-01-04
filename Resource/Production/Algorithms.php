<?php

namespace podcasthosting\Auphonic\Resource\Production {

    use podcasthosting\Auphonic\ParseTrait;

    class Algorithms
    {
        use ParseTrait;

        protected $normloudness;

        protected $loudnesstarget;

        protected $denoise;

        protected $denoiseamount;

        protected $hipfilter;

        protected $leveler;
    }
}
