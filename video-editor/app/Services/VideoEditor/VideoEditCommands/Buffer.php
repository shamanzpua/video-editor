<?php

namespace App\Services\VideoEditor\VideoEditCommands;

use App\Services\VideoEditor\Contracts\IBuffer;
use App\Services\VideoEditor\Contracts\ICommand;

/**
 * Class Buffer
 * @package App\Services\VideoEditor\VideoEditCommands
 */
class Buffer implements IBuffer
{
    /**
     * @var string $body
     */
    protected $body;

    /**
     * @param ICommand $command
     * @return mixed
     */
    public function renew(ICommand $command)
    {
        $body = $command->getBody();
        $this->body .= " \n$body";
    }

    /**
     * @return mixed
     */
    public function release()
    {
        $this->body = '';
    }

    /**
     * @return string
     */
    public function get()
    {
        return $this->body;
    }
}