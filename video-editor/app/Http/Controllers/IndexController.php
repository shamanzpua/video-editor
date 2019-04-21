<?php

namespace App\Http\Controllers;

use App\Jobs\CreateVideo;
use App\Video;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;

/**
 * Class IndexController
 * @package App\Http\Controllers
 */
class IndexController extends Controller
{
    use DispatchesJobs;

    public function index(Request $request)
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

    public function videoList(Request $request)
    {

        return view(
            'list',
            [
                'videos' => Video::where('status', Video::STATUS_READY)->orderBy('id', 'desc')->get()->all()
            ]
        );
    }
}