<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\{
    Common\QueueJob,
    Users\Contact\UserContactEmail,
    Soundblock\Collections\Collection as CollectionModel
};
use App\Observers\{
    Common\QueueJob as QueueJobObservers,
    Common\Email,
    Soundblock\Collection as CollectionObserver
};

class OberserService extends ServiceProvider {
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        QueueJob::observe(QueueJobObservers::class);
        UserContactEmail::observe(Email::class);
        CollectionModel::observe(CollectionObserver::class);
    }
}
