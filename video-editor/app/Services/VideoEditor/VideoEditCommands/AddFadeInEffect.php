<?php

namespace App\Services\VideoEditor\VideoEditCommands;

use App\Services\VideoEditor\Contracts\ICommand;
use App\Services\VideoEditor\Contracts\ICommandChain;
use App\Services\VideoEditor\Exceptions\CommandExecutionException;

/**
 * Class AddFadeInEffect
 * @package App\Services\VideoEditor\VideoEditCommands
 */
class AddFadeInEffect extends AbstractCommand implements ICommand, ICommandChain
{

    protected $requiredFields = [
        'inputVideo',
        'output',
    ];

    /**
     * @throws CommandExecutionException
     * @return mixed
     */
    protected function generate()
    {
        $inputVideo = $this->workDirPath($this->params['inputVideo']);
        $outputVideo = $this->workDirPath($this->params['output']);

        $this->body = "ffmpeg -i $inputVideo -filter_complex \"[0:v]fade=type=in:duration=2:start_time=1[v];[0:a]afade=type=in:duration=2:start_time=1[a]\" -map \"[v]\" -map \"[a]\" -strict -2 $outputVideo";

    }
}