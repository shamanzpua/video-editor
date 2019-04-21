<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Jobs\CreateVideo;
use App\Video;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;

/**
 * Class VideoController
 * @package App\Http\Controllers
 */
class VideoController extends Controller
{
    use DispatchesJobs;

    public function index()
    {
        return $_SERVER;
    }

    public function store(Request $request)
    {

        if ($request->get('createVideo')) {
            $input = $request->only([
                'first_url',
                'first_start',
                'first_duration',
                'second_url',
                'second_start',
                'second_duration',
            ]);
            $video = Video::create($input);
            $job = new CreateVideo($video->id);
            $this->dispatch($job);
        }

        $data = ['input' => $input ?? []];
        return view('welcome', $data);
    }

}