<?php

namespace podcasthosting\Auphonic\Resource {

    use podcasthosting\Auphonic\ParseTrait;
    use podcasthosting\Auphonic\Resource\Production\Metadata;
    use podcasthosting\Auphonic\Resource\Production\OutputFiles;
    use podcasthosting\Auphonic\Resource\Production\OutgoingService;
    use podcasthosting\Auphonic\Resource\Production\Algorithms;

    class Production implements \JsonSerializable
    {
        use ParseTrait;/* {
        __set as parseset();
    }*/

        /**
         * Unique ID.
         *
         * @var string
         */
        protected $uuid;

        /**
         * Date of creation.
         * e.g "2012-05-14T19:27:34.833"
         *
         * @var string
         */
        protected $creation_time;

        /**
         * Metadata of this production.
         * Including title, year of production
         *
         * @var Metadata
         */
        protected $metadata;

        /**
         * Basename of the output files to be generated.
         *
         * @var string
         */
        protected $output_basename;

        /**
         * List of output files to generate.
         *
         * @var OutputFiles[]
         */
        protected $output_files = [];

        /**
         * @var OutgoingService[]
         */
        protected $outgoing_services = [];

        /**
         * @var Algorithms
         */
        protected $algorithms;

        /**
         * @var
         */
        protected $chapters;

        /**
         * @var
         */
        protected $input_file;

        /**
         * @var
         */
        protected $multi_input_files;

        /**
         * URL of the cover image
         *
         * @var string
         */
        protected $image;

        protected $status;
        protected $status_string;
        protected $status_page;
        protected $is_multitrack;
        protected $edit_page;
        protected $channels;
        protected $cut_start;
        protected $cut_end;
        protected $warning_message;
        protected $warning_status;
        protected $samplerate;
        protected $statistics;
        protected $service;
        protected $has_video;
        protected $error_status;
        protected $error_message;
        protected $length;
        protected $length_timestring;
        protected $bitrate;
        protected $change_time;
        protected $waveform_image;
        protected $start_allowed;
        protected $change_allowed;
        protected $used_credits;
        protected $format;

        /**
         * URL of the thumbnail for the cover image
         *
         * @var string
         */
        protected $thumbnail;

        function __construct()
        {
            $this->metadata = new Metadata();
            $this->algorithms = new Algorithms();
        }

        /**
         * @param string $image
         */
        public function setImage($image)
        {
            $this->image = $image;
        }

        /**
         * @return string
         */
        public function getImage()
        {
            return $this->image;
        }

        /**
         * @return boolean
         */
        public function hasImage()
        {
            return !empty($this->image);
        }

        /**
         * @param string $thumbnail
         */
        public function setThumbnail($thumbnail)
        {
            $this->thumbnail = $thumbnail;
        }

        /**
         * @return string
         */
        public function getThumbnail()
        {
            return $this->thumbnail;
        }

        /**
         * @param mixed $algorithms
         */
        public function setAlgorithms($algorithms)
        {
            $this->algorithms = $algorithms;
        }

        /**
         * @return mixed
         */
        public function getAlgorithms()
        {
            return $this->algorithms;
        }

        /**
         * @param mixed $chapters
         */
        public function setChapters($chapters)
        {
            $this->chapters = $chapters;
        }

        /**
         * @return mixed
         */
        public function getChapters()
        {
            return $this->chapters;
        }

        /**
         * @param mixed $input_file
         */
        public function setInputFile($input_file)
        {
            $this->input_file = $input_file;
        }

        /**
         * @return mixed
         */
        public function getInputFile()
        {
            return $this->input_file;
        }

        /**
         * @param Metadata $metadata
         */
        public function setMetadata(Metadata $metadata)
        {
            $this->metadata = $metadata;
        }

        /**
         * @return Metadata
         */
        public function getMetadata()
        {
            return $this->metadata;
        }

        /**
         * @param mixed $multi_input_files
         */
        public function setMultiInputFiles($multi_input_files)
        {
            $this->multi_input_files = $multi_input_files;
        }

        /**
         * @return mixed
         */
        public function getMultiInputFiles()
        {
            return $this->multi_input_files;
        }

        /**
         * @param \podcasthosting\Auphonic\Resource\Production\OutgoingService[] $outgoing_services
         */
        public function setOutgoingServices($outgoing_services)
        {
            $this->outgoing_services = $outgoing_services;
        }

        /**
         * @return \podcasthosting\Auphonic\Resource\Production\OutgoingService[]
         */
        public function getOutgoingServices()
        {
            return $this->outgoing_services;
        }

        /**
         * @param string $output_basename
         */
        public function setOutputBasename($output_basename)
        {
            $this->output_basename = $output_basename;
        }

        /**
         * @return string
         */
        public function getOutputBasename()
        {
            return $this->output_basename;
        }

        /**
         * @param \podcasthosting\Auphonic\Resource\Production\OutputFiles[] $output_files
         */
        public function setOutputFiles($output_files)
        {
            $this->output_files = $output_files;
        }

        /**
         * @return \podcasthosting\Auphonic\Resource\Production\OutputFiles[]
         */
        public function getOutputFiles()
        {
            return $this->output_files;
        }

        /**
         * @param string $uuid
         */
        public function setUuid($uuid)
        {
            $this->uuid = $uuid;
        }

        /**
         * @return string
         */
        public function getUuid()
        {
            return $this->uuid;
        }

        /**
         * @param string $creation_time
         */
        public function setCreationTime($creation_time)
        {
            $this->creation_time = $creation_time;
        }

        /**
         * @return string
         */
        public function getCreationTime()
        {
            return $this->creation_time;
        }

        public function __set($name, $value)
        {
            if ($name == 'output_files') {
                if (count($value) > 0) {
                    $outputFiles = new OutputFiles();
                    self::cast($outputFiles, $value[0]);
                    $this->{$name}[] = $outputFiles;
                }
            } elseif ($name == 'outgoing_services') {
                if (count($value) > 0) {
                    $outgoingService = new OutgoingService();
                    self::cast($outgoingService, $value[0]);
                    $this->{$name}[] = $outgoingService;
                }
            } elseif (property_exists($this, $name)) {
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
    }
}
