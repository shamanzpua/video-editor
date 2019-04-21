<?php

namespace App\Services\VideoEditor\VideoEditCommands;

use App\Services\VideoEditor\Contracts\ICommand;
use App\Services\VideoEditor\Contracts\ICommandChain;
use App\Services\VideoEditor\DTOs\VideoResolutionDTO;
use App\Services\VideoEditor\Exceptions\CommandExecutionException;

/**
 * Class AddWatermark
 * @package App\Services\VideoEditor\VideoEditCommands
 */
class AddWatermark extends AbstractCommand implements ICommand, ICommandChain
{

    protected $requiredFields = [
        'inputVideo',
        'output',
        'waterMarkPath',
        'waterMarkFile',
    ];

    /**
     * @param $name
     * @return string
     */
    private function waterMarkPath($name) : string
    {
        return $this->params['waterMarkPath'] . $name;
    }

    /**
     * @throws CommandExecutionException
     * @return mixed
     */
    protected function generate()
    {
        $inputVideo = $this->workDirPath($this->params['inputVideo']);
        $outputVideo = $this->workDirPath($this->params['output']);
        $waterMark = $this->waterMarkPath($this->params['waterMarkFile']);

        $this->body = "ffmpeg -y -i {$inputVideo} -i $waterMark -filter_complex \"overlay=25:15\" -strict -2 $outputVideo";
    }
}