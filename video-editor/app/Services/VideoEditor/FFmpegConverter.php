<?php
namespace App\Services\VideoEditor;

use App\Services\VideoEditor\Contracts\ICommand;
use App\Services\VideoEditor\Contracts\IConverter;

/**
 * Class FFmpegConverter
 * @package App\Services\VideoEditor
 */
class FFmpegConverter implements IConverter
{

    /**
     * @param ICommand $command
     * @return mixed
     */
    public function process(ICommand $command)
    {
        return exec($command->execute());
    }
}