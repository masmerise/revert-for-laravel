<?php declare(strict_types=1);

namespace Masmerise\Revert;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;

final class RemoveBootstrapProviders extends Action
{
    protected string $description = 'Removing bootstrap/providers.php';

    protected string $emoji = '🧹';

    protected function run(Filesystem $files, Application $laravel): void
    {
        $files->delete($laravel->getBootstrapProvidersPath());
    }

    protected function wasRun(Filesystem $files, Application $laravel): bool
    {
        return ! $files->exists($laravel->getBootstrapProvidersPath());
    }
}
