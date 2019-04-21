<?php

namespace App\Services\VideoEditor\Contracts;

/**
 * Interface ICommandSequenceManager
 * @package App\Services\VideoEditor\Contracts
 */
interface ICommandSequenceBuilder
{
    /**
     * @return mixed
     */
    public function build($data) : ICommand;

}