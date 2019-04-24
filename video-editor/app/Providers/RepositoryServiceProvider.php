<?php

namespace App\Providers;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\Rest\VideoController;
use App\Jobs\CreateVideo;
use App\Repositories\Contracts\IVideoRepository;
use App\Repositories\Eloquent\VideoRepository as EloquentVideoRepository;
use App\Repositories\Rest\VideoRepository as RestVideoRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 * @package App\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when([IndexController::class])
            ->needs(IVideoRepository::class)
            ->give(RestVideoRepository::class);


        $this->app->when([VideoController::class, CreateVideo::class])
            ->needs(IVideoRepository::class)
            ->give(EloquentVideoRepository::class);
    }
}
