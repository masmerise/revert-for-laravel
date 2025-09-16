<?php declare(strict_types=1);

namespace Masmerise\Revert;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;

/** @internal */
final class RestoreApplicationBootstrapper extends Action
{
    protected string $description = 'Restoring bootstrap/app.php';

    protected function run(Filesystem $files, Application $laravel): void
    {
        $files->copy($this->stubPath('bootstrap/app.stub.php'), $laravel->basePath('bootstrap/app.php'));
    }

    protected function wasRun(Filesystem $files, Application $laravel): bool
    {
        $bootstrapper = $files->get($laravel->basePath('bootstrap/app.php'));

        return str_contains($bootstrapper, 'return $app;');
    }
}
