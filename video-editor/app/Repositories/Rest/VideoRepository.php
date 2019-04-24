<?php

namespace App\Repositories\Rest;

use App\Repositories\Contracts\IVideoRepository;
use GuzzleHttp\Client;

/**
 * Class VideoRepository
 * @package App\Repositories\Rest
 */
class VideoRepository implements IVideoRepository
{

    private $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'http://web']);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function store($data)
    {
        return $this->client->post('/api/video', ['form_params' => $data])->getBody()->getContents();
    }


    /**
     * @return mixed
     */
    public function getAllReady()
    {
        return $this->client->get('/api/video')->getBody()->getContents();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        // TODO: Implement findById() method.
    }
}