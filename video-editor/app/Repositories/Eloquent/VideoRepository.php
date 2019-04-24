<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\IVideoRepository;
use App\Video;

/**
 * Class VideoRepository
 * @package App\Repositories\Eloquent
 */
class VideoRepository implements IVideoRepository
{

    /**
     * @param $data
     * @return mixed|Video
     */
    public function store($data)
    {
        return Video::create($data);
    }

    /**
     * @param $id
     * @return mixed|Video
     */
    public function findById($id)
    {
        return Video::find($id);
    }

    /**
     * @return mixed
     */
    public function getAllReady()
    {
        return Video::where('status', Video::STATUS_READY)->orderBy('id', 'desc')->get()->all();
    }
}