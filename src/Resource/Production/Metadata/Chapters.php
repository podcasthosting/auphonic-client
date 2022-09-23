<?php
/**
 * User: fabio
 * Date: 23.09.22
 * Time: 21:36
 */

namespace podcasthosting\Auphonic\Resource\Production\Metadata;

use podcasthosting\Auphonic\ParseTrait;

class Chapters
{
    use ParseTrait;

    /**
     * @string $start
     * @example "00:00:00"
     * @example "00:02:18"
     */
    protected /*string*/ $start;

    /**
     * @string title
     */
    protected /*string*/ $title;

    /**
     * @string $url
     */
    protected /*string*/ $url;
}
