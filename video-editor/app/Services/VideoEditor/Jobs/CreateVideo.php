<?php

namespace App\Jobs;

use App\Services\VideoEditor\Contracts\IManager;
use App\Video;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class CreateVideo
 * @package App\Jobs
 */
class CreateVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels, Queueable;

    private $videoId;

    public function __construct($id)
    {
        $this->videoId = $id;
    }

    /**
     * Execute the job.
     */
    public function handle(IManager $manager)
    {

        $video = Video::find($this->videoId);

        if (!$video) {
            throw new \RuntimeException("{$this->videoId} not found");
        }

        if (file_exists(storage_path('video/output/') . $video->id . "_final.mp4")) {
            return;
        }

        $waterMarks = [
            'edu1.png',
            'wd1.png',
            'ec1.png',
        ];

        $manager->create([
            'workDirPath' => storage_path('video/workdir/'),
            'outputDirPath' => storage_path('video/output/'),
            'uniqueKey' => $video->id,
            'firstVideo' => 'first.mp4',
            'firstVideoUrl' => $video->first_url,
            'firstScaledVideo' => '1scaled.mp4',
            'cutFirstVideo' => '1cut.mp4',
            'firstVideoCutStart' => $video->first_start,
            'firstVideoDuration' => $video->first_duration,

            'secondVideo' => 'second.mp4',
            'secondVideoUrl' => $video->second_url,
            'secondScaledVideo' => '2scaled.mp4',
            'cutSecondVideo' => '2cut.mp4',
            'secondVideoCutStart' => $video->second_start,
            'secondVideoDuration' => $video->second_duration,

            'firstVideoWithWatermark' => '1wm.mp4',
            'secondVideoWithWatermark' => '2wm.mp4',

            'waterMarkPath' => public_path('logo/'),
            'firstWaterMarkFile' => $waterMarks[array_rand($waterMarks)],
            'secondWaterMarkFile' => $waterMarks[array_rand($waterMarks)],
            'firstVideoWithFade' => 'f1.mp4',
            'secondVideoWithFade' => 'f2.mp4',
            'finalVideo' => 'final.mp4',
        ]);

        /**
         * @var Video $video
         */
        $video->updateStatus(Video::STATUS_READY);
    }
}
