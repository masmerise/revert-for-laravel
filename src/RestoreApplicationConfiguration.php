<?php declare(strict_types=1);

namespace Masmerise\Revert;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;

final class RestoreApplicationConfiguration extends Action
{
    protected string $description = 'Restoring config/app.php';

    protected string $emoji = '🔄';

    protected function run(Filesystem $files, Application $laravel): void
    {
        $files->copy($this->stubPath('config/app.stub.php'), $laravel->basePath('config/app.php'));
    }

    protected function wasRun(Filesystem $files, Application $laravel): bool
    {
        $configuration = $files->get($laravel->basePath('config/app.php'));

        return str_contains($configuration, '| Autoloaded Service Providers');
    }
}
