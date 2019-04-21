<?php

namespace App\Services\VideoEditor\Contracts;

use App\Services\VideoEditor\Exceptions\CommandExecutionException;

/**
 * Interface ICommand
 * @package App\Services\VideoEditor\Contracts
 */
interface ICommand
{
    /**
     * @throws CommandExecutionException
     * @return mixed
     */
    public function execute();

    /**
     * @param array $params
     * @return ICommand
     */
    public function setParams(array $params) : ICommand;

    /**
     * @return string
     */
    public function getBody() : string;
}