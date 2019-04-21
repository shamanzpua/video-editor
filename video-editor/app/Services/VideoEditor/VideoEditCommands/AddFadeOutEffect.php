<?php

namespace App\Services\VideoEditor\VideoEditCommands;

use App\Services\VideoEditor\Contracts\ICommand;
use App\Services\VideoEditor\Contracts\ICommandChain;
use App\Services\VideoEditor\Exceptions\CommandExecutionException;

/**
 * Class AddFadeEffect
 * @package App\Services\VideoEditor\FFmpegCommands
 */
class AddFadeOutEffect extends AbstractCommand implements ICommand, ICommandChain
{
    /**
     * @var array $requiredFields
     */
    protected $requiredFields = [
        'inputVideo',
        'output',
        'duration',
    ];

    /**
     * @inheritdoc
     */
    protected function generate()
    {
        $inputVideo = $this->workDirPath($this->params['inputVideo']);
        $duration = $this->params['duration'];
        $outputVideo = $this->workDirPath($this->params['output']);

        $fadeSecond = ($duration - 1);

        $this->body = "ffmpeg -i $inputVideo -filter_complex \"[0:v]fade=type=in:duration=1,fade=type=out:duration=1:start_time=$fadeSecond [v];[0:a]afade=type=in:duration=1,afade=type=out:duration=1:start_time=$fadeSecond [a]\" -map \"[v]\" -map \"[a]\" -strict -2 $outputVideo";
    }
}