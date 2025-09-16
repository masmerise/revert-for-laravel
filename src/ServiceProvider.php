<?php declare(strict_types=1);

namespace Masmerise\Revert;

use Illuminate\Support\AggregateServiceProvider;

/** @internal */
final class ServiceProvider extends AggregateServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([Revert::class]);
        }
    }
}
