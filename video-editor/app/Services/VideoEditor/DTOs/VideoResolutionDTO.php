<?php

namespace App\Services\VideoEditor\DTOs;

/**
 * Class VideoResolutionDTO
 * @package App\Services\VideoEditor\DTOs
 */
class VideoResolutionDTO
{
    public $width;
    public $height;

    /**
     * VideoResolutionDTO constructor.
     * @param null $width
     * @param null $height
     */
    public function __construct($width = null, $height = null)
    {
        $this->height = $height;
        $this->width = $width;
    }
}