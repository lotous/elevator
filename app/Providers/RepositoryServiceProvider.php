<?php

namespace App\Providers;


use App\Repositories\ElevatorRepositoryInterface;
use App\Repositories\Eloquent\ElevatorRepository;
use App\Repositories\Eloquent\FloorRepository;
use App\Repositories\Eloquent\ReportRepository;
use App\Repositories\Eloquent\SequenceRepository;
use App\Repositories\FloorRepositoryInterface;
use App\Repositories\ReportRepositoryInterface;
use App\Repositories\SequenceRepositoryInterface;
use \Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ReportRepositoryInterface::class, ReportRepository::class);
        $this->app->bind(FloorRepositoryInterface::class, FloorRepository::class);
        $this->app->bind(SequenceRepositoryInterface::class, SequenceRepository::class);
        $this->app->bind(ElevatorRepositoryInterface::class, ElevatorRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
