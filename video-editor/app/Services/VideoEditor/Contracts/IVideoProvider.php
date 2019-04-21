<?php

namespace App\Services\VideoEditor\Contracts;

/**
 * Interface IVideoProvider
 * @package App\Services\VideoEditor\Contracts
 */
interface IVideoProvider
{
    /**
     * @param $url
     * @param $outputPath
     * @param $outputFile
     * @param null $prefix
     * @return mixed
     */
    public function getVideo($url, $outputPath, $outputFile, $prefix = null);

    /**
     * @param $url
     * @return mixed
     */
    public function checkIsVideoAvailable($url);
}