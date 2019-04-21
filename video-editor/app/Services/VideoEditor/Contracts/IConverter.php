<?php

namespace App\Services\VideoEditor\Contracts;

/**
 * Interface IConverter
 * @package App\Services\VideoEditor\Contracts
 */
interface IConverter
{
    /**
     * @param ICommand $command
     * @return mixed
     */
    public function process(ICommand $command);
}