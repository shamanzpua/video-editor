<?php

namespace App\Services\VideoEditor\Contracts;

use App\Services\VideoEditor\Exceptions\CommandExecutionException;

/**
 * Interface ICommand
 * @package App\Services\VideoEditor\Contracts
 */
interface IBuffer
{
    /**
     * @param ICommand $command
     * @return mixed
     */
    public function renew(ICommand $command);

    /**
     * @return mixed
     */
    public function release();

    public function get();
}