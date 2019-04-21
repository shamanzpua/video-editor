<?php

namespace App\Services\VideoEditor\VideoEditCommands;

use App\Services\VideoEditor\Contracts\ICommand;
use App\Services\VideoEditor\Contracts\ICommandChain;
use App\Services\VideoEditor\Exceptions\CommandExecutionException;

/**
 * Class ConcatVideo
 * @package App\Services\VideoEditor\FFmpegCommands
 */
class ConcatVideo extends AbstractCommand implements ICommand, ICommandChain
{
    /**
     * @var array $requiredFields
     */
    protected $requiredFields = [
        'finalVideo',
        'firstPart',
        'secondPart'
    ];

    /**
     * @inheritdoc
     */
    protected function generate()
    {
        $finalVideo = $this->outputDirPath($this->params['finalVideo']);
        $firstPart = $this->workDirPath($this->params['firstPart']);
        $secondPart = $this->workDirPath($this->params['secondPart']);

        $this->body = "
        ffmpeg -i $firstPart -i $secondPart -y -filter_complex \"[0:v:0] [0:a:0] [1:v:0] [1:a:0] concat=unsafe=1:n=2:v=1:a=1 [v] [a]\" -map \"[v]\" -map \"[a]\" -strict -2 $finalVideo";
    }
}