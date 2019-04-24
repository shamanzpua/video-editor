<?php

namespace App\Http\Controllers\Rest;

use App\Http\Controllers\Controller;
use App\Jobs\CreateVideo;
use App\Repositories\Contracts\IVideoRepository;
use App\Repositories\Eloquent\VideoRepository;
use App\Video;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

/**
 * Class VideoController
 * @package App\Http\Controllers
 */
class VideoController extends Controller
{
    use DispatchesJobs;

    /**
     * @param Request $request
     * @param Response $response
     * @param IVideoRepository $videoRepository
     * @return mixed
     */
    public function store(
        Request $request,
        Response $response,
        VideoRepository $videoRepository
    ) {
        $input = $request->only([
            'first_url',
            'first_start',
            'first_duration',
            'second_url',
            'second_start',
            'second_duration',
        ]);

        $validator = Validator::make($input, [
            'first_url' => 'required',
            'first_start' => 'required',
            'first_duration' => 'required',
            'second_url' => 'required',
            'second_start' => 'required',
            'second_duration' => 'required',
        ]);

        if ($validator->fails()) {
            return $response
                ->setContent($validator->errors())
                ->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $video = $videoRepository->store($input);
        $job = new CreateVideo($video->id);
        $this->dispatch($job);

        return $response->setStatusCode(Response::HTTP_CREATED);
    }

}