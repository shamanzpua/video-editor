<?php

namespace App\Services\VideoEditor\VideoEditCommands;

use App\Services\VideoEditor\Contracts\ICommand;
use App\Services\VideoEditor\Contracts\ICommandChain;

class DeleteTemporaryFiles extends AbstractCommand implements ICommand, ICommandChain
{

    /**
     * @inheritdoc
     */
    protected function generate()
    {
        $this->body = "rm -rf " . $this->params['workDirPath'] . $this->params['uniqueKey'];
    }
}