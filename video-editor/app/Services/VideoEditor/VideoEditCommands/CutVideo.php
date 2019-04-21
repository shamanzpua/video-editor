<?php

namespace App\Services\VideoEditor\VideoEditCommands;

use App\Services\VideoEditor\Contracts\ICommand;
use App\Services\VideoEditor\Contracts\ICommandChain;
use App\Services\VideoEditor\Exceptions\CommandExecutionException;

/**
 * Class CutVideo
 * @package App\Services\VideoEditor\Commands
 */
class CutVideo extends AbstractCommand implements ICommand, ICommandChain
{
    /**
     * @var $requiredFields;
     */
    protected $requiredFields = [
        'inputVideo',
        'startTime',
        'duration',
        'output',
    ];

    /**
     * @inheritdoc
     */
    protected function generate()
    {
        $this->checkRequiredFields();
        $inputVideo = $this->workDirPath($this->params['inputVideo']);
        $startTime = $this->params['startTime'];
        $duration = $this->params['duration'];
        $outputVideo = $this->workDirPath($this->params['output']);

        $this->body = "
        ffmpeg -y -i $inputVideo -ss $startTime -t $duration -async 1  -strict -2  $outputVideo";
    }
}