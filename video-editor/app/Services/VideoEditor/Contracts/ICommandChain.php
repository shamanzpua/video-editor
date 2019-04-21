<?php

namespace App\Services\VideoEditor\Contracts;

/**
 * Interface ICommandChain
 * @package App\Services\VideoEditor\Contracts
 */
interface ICommandChain
{
    /**
     * @param ICommandChain $command
     * @return ICommandChain
     */
    public function setNextCommand(ICommandChain $command): ICommandChain;

    /**
     * @param IBuffer $buffer
     * @return ICommandChain
     */
    public function setBuffer(IBuffer $buffer) : ICommandChain;
}