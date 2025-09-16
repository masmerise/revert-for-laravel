<?php declare(strict_types=1);

namespace Masmerise\Revert;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;

/** @internal */
final class ReconcileBootstrapProvidersWithConfigurationProviders extends Action
{
    protected string $description = 'Reconciling providers';

    protected function run(Filesystem $files, Application $laravel): void
    {
        $providers = Collection::make(require $laravel->getBootstrapProvidersPath())
            ->merge(['App\\Providers\\RouteServiceProvider'])
            ->unique()
            ->sort()
            ->values()
            ->map(static fn (string $p) => "{$p}::class,")
            ->join("\n        ");

        $config = $files->get($target = $laravel->basePath('config/app.php'));

        $files->put($target, str_replace('/** {{$providers}} */', $providers, $config));
    }

    protected function wasRun(Filesystem $files, Application $laravel): bool
    {
        $configuration = $files->get($laravel->basePath('config/app.php'));

        return ! str_contains($configuration, '/** {{$providers}} */');
    }
}
