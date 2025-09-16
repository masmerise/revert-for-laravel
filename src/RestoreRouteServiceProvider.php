<?php declare(strict_types=1);

namespace Masmerise\Revert;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;

/** @internal */
final class RestoreRouteServiceProvider extends Action
{
    protected string $description = 'Restoring App\\Providers\\RouteServiceProvider';

    protected function run(Filesystem $files, Application $laravel): void
    {
        $stub = $this->isInertia($files, $laravel) ? 'RouteServiceProvider.inertia.stub.php' : 'RouteServiceProvider.stub.php';

        $files->copy($this->stubPath("app/Providers/{$stub}"), $laravel->path('Providers/RouteServiceProvider.php'));
    }

    protected function wasRun(Filesystem $files, Application $laravel): bool
    {
        return $files->exists($laravel->path('Providers/RouteServiceProvider.php'));
    }

    private function isInertia(Filesystem $files, Application $laravel): bool
    {
        $schema = $files->get($laravel->basePath('composer.json'));
        $schema = json_decode($schema, true);

        $name = $schema['name'] ?? null;

        return $name === 'laravel/react-starter-kit' || $name === 'laravel/vue-starter-kit';
    }
}
