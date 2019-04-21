<?php

namespace App\Services\VideoEditor\VideoEditCommands;

use App\Services\VideoEditor\Contracts\ICommand;
use App\Services\VideoEditor\Contracts\ICommandChain;
use App\Services\VideoEditor\DTOs\VideoResolutionDTO;
use App\Services\VideoEditor\Exceptions\CommandExecutionException;

/**
 * Class AddFadeInEffect
 * @package App\Services\VideoEditor\VideoEditCommands
 */
class ScaleResolution extends AbstractCommand implements ICommand, ICommandChain
{

    protected $requiredFields = [
        'inputVideo',
        'output',
        'resolution',
    ];

    /**
     * @throws CommandExecutionException
     * @return mixed
     */
    protected function generate()
    {
        $inputVideo = $this->workDirPath($this->params['inputVideo']);
        $outputVideo = $this->workDirPath($this->params['output']);

        /**
         * @var VideoResolutionDTO $resolution
         */
        $resolution = $this->params['resolution'];

        if ($resolution instanceof VideoResolutionDTO == false) {
            throw new CommandExecutionException("resolution param should be instance of ". VideoResolutionDTO::class);
        }
        $this->body = "ffmpeg -i $inputVideo -vf scale={$resolution->width}:{$resolution->height} -strict -2 $outputVideo";
    }
}