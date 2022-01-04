<?php

namespace de\podcaster\Auphonic\Resource\Production {

    use de\podcaster\Auphonic\ParseTrait;

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