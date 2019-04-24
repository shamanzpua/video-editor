<?php

namespace App\Http\Controllers;

use App\Jobs\CreateVideo;
use App\Repositories\Contracts\IVideoRepository;
use App\Repositories\Rest\VideoRepository as VideoApi;
use App\Repositories\Eloquent\VideoRepository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;

/**
 * Class IndexController
 * @package App\Http\Controllers
 */
class IndexController extends Controller
{
    use DispatchesJobs;

    /**
     * @param Request $request
     * @param VideoApi $videoApi
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function taskCreate(
        Request $request,
        VideoApi $videoApi
    ) {
        if ($request->get('createVideo')) {
            $input = $request->only([
                'first_url',
                'first_start',
                'first_duration',
                'second_url',
                'second_start',
                'second_duration',
            ]);
            $videoApi->store($input);
            return redirect('/videos');
        }

        $data = ['input' => $input ?? []];
        return view('welcome', $data);
    }

    /**
     * @param Request $request
     * @param VideoApi $videoApi
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function multitaskCreate(
        Request $request,
        VideoApi $videoApi
    ) {


        if ($request->get('createVideo')) {
//            dd($request->all());
            $urls = $request->only(['first_url', 'second_url']);

            $videos = [];
            foreach ($urls['first_url'] as $key => $url) {
                $videos[$key]['first_url'] = $url;
            }
            foreach ($urls['second_url'] as $key => $url) {
                $videos[$key]['second_url'] = $url;
            }

            foreach ($videos as $video) {
                $videoApi->store([
                    'first_url' => $video['first_url'],
                    'first_start' => "00:00:55",
                    'first_duration' => "15",
                    'second_url' => $video['second_url'],
                    'second_start' => "00:01:30",
                    'second_duration' => "15",
                ]);
            }
            return redirect('/videos');
        }

        $data = [];
        return view('multicreate', $data);
    }

    public function videoList(VideoRepository $videoRepository)
    {

        return view(
            'list',
            [
                'videos' => $videoRepository->getAllReady()
            ]
        );
    }
}