<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PersonRepository::class, \App\Repositories\PersonRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\WorkshopRepository::class, \App\Repositories\WorkshopRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RolesRepository::class, \App\Repositories\RolesRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\VehicleRepository::class, \App\Repositories\VehicleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CarRepository::class, \App\Repositories\CarRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ProductRepository::class, \App\Repositories\ProductRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CategoryRepository::class, \App\Repositories\CategoryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ServiceRepository::class, \App\Repositories\ServiceRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\DiagnosisRepository::class, \App\Repositories\DiagnosisRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ChecklistRepository::class, \App\Repositories\ChecklistRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\StatesRepository::class, \App\Repositories\StatesRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FuelRepository::class, \App\Repositories\FuelRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ColorsRepository::class, \App\Repositories\ColorsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CarBrandsRepository::class, \App\Repositories\CarBrandsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OrderRepository::class, \App\Repositories\OrderRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ConfigRepository::class, \App\Repositories\ConfigRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PartsRepository::class, \App\Repositories\PartsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PartsNameRepository::class, \App\Repositories\PartsNameRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PartsBrandsRepository::class, \App\Repositories\PartsBrandsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SystemRepository::class, \App\Repositories\SystemRepositoryEloquent::class);
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
