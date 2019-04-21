<?php

namespace App\Services\VideoEditor\Contracts;

/**
 * Interface IManager
 * @package App\Services\VideoEditor\Contracts
 */
interface IManager
{
    /**
     * @param $input
     */
    public function create($input);
}