<?php

namespace App\Repositories\Contracts;

/**
 * Interface IVideoRepository
 * @package App\Repositories\Contracts
 */
interface IVideoRepository
{
    /**
     * @param $data
     * @return mixed
     */
    public function store($data);

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id);
}