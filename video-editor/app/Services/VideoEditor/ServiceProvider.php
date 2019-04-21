<?php

namespace App\Service\VideoEditor;
use App\Services\VideoEditor\Commands\EditVideos;
use App\Services\VideoEditor\Contracts\ICommandSequenceBuilder;
use App\Services\VideoEditor\Contracts\IConverter;
use App\Services\VideoEditor\Contracts\IManager;
use App\Services\VideoEditor\Contracts\IVideoProvider;
use App\Services\VideoEditor\FFmpegConverter;
use App\Services\VideoEditor\Manager;
use App\Services\VideoEditor\MergingWithFadeSequenceBuilder;
use App\Services\VideoEditor\YouTubeVideoProvider;

/**
 * Class TransactionServiceProvider
 * @package App\Service\Transaction
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * @var array
     */
    private $commands = [
        EditVideos::class
    ];


    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->bind(IManager::class, Manager::class);
        $this->app->bind(IVideoProvider::class, YouTubeVideoProvider::class);
        $this->app->bind(IConverter::class, FFmpegConverter::class);
        $this->app->bind(ICommandSequenceBuilder::class, MergingWithFadeSequenceBuilder::class);
        $this->app->bind(IConverter::class, FFmpegConverter::class);

        $this->commands($this->commands);
    }
}
