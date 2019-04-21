<?php

namespace App\Services\VideoEditor;

use App\Services\VideoEditor\Contracts\IVideoProvider;
use App\Services\VideoEditor\DTOs\VideoResolutionDTO;
use \GetId3\GetId3Core as GetId3;

/**
 * Class YouTubeVideoProvider
 * @package App\Services\VideoEditor
 */
class YouTubeVideoProvider implements IVideoProvider
{

    /**
     * YouTubeVideoProvider constructor.
     */
    public function __construct()
    {
        $this->videoResolution = new VideoResolutionDTO();
    }

    /**
     * @var VideoResolutionDTO
     */
    private $videoResolution;
    /**
     * @var string
     */
    private $output;

    /**
     * @param $url
     * @param $outputPath
     * @param $outputFile
     * @param null $prefix
     * @return mixed
     */
    public function getVideo($url, $outputPath, $outputFile, $prefix = null)
    {
        $this->output = $outputPath;
        if ($prefix) {
            $this->output .= '/'. $prefix . '/';
        }

        exec("mkdir -p {$this->output} ");

        $this->output .= $outputFile;


        exec("youtube-dl -f 'bestvideo[ext=mp4]+bestaudio[ext=m4a]' -o {$this->output} {$url}");
//        exec("youtube-dl -o {$this->output} {$url}");

        $getId3 = new GetId3();
        $file = $getId3->analyze($this->output);

        if ($this->videoResolution->width < $file['video']['resolution_x']) {
            $this->videoResolution->width = $file['video']['resolution_x'];
        }

        if ($this->videoResolution->height < $file['video']['resolution_y']) {
            $this->videoResolution->height = $file['video']['resolution_y'];
        }
    }

    /**
     * @param $url
     * @return mixed
     */
    public function checkIsVideoAvailable($url)
    {
        // TODO: Implement checkIsVideoAvailable() method.
    }

    /**
     * @return mixed
     */
    public function getResolution()
    {
        return $this->videoResolution;
    }
}