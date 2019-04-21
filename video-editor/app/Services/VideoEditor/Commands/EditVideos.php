<?php

namespace App\Services\VideoEditor\Commands;

use App\Jobs\CreateVideo;
use App\Services\VideoEditor\Contracts\IManager;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class EditVideos extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video:edit';

    protected $description = 'Detect transactions with deleted orders';

    public function handle(IManager $manager)
    {

        $manager->create([
            'workDirPath' => storage_path('video/workdir/'),
            'outputDirPath' => storage_path('video/output/'),
            'uniqueKey' => 435,
            'firstVideo' => 'first.mp4',
            'firstVideoUrl' => 'https://www.youtube.com/watch?v=kJQP7kiw5Fk',
            'firstScaledVideo' => '1scaled.mp4',
            'cutFirstVideo' => '1cut.mp4',
            'firstVideoCutStart' => '00:00:33',
            'firstVideoDuration' => '5',

            'secondVideo' => 'second.mp4',
            'secondVideoUrl' => 'https://www.youtube.com/watch?v=U-JofUEsbD0',
            'secondScaledVideo' => '2scaled.mp4',
            'cutSecondVideo' => '2cut.mp4',
            'secondVideoCutStart' => '00:01:21',
            'secondVideoDuration' => '5',

            'firstVideoWithFade' => 'f1.mp4',
            'secondVideoWithFade' => 'f2.mp4',
            'finalVideo' => 'final.mp4',
        ]);
    }
}