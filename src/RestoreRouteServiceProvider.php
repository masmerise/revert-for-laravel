<?php declare(strict_types=1);

namespace Masmerise\Revert;

use Closure;
use Illuminate\Foundation\Application;

final readonly class RestoreRouteServiceProvider
{
    public function handle(Revert $cli, Closure $next): Revert
    {
        $output = '🔄Restoring App\\Providers\\RouteServiceProvider...';

        /** @var Application $laravel */
        $laravel = $cli->getLaravel();

        if ($laravel['files']->exists($target = $laravel->path('Providers/RouteServiceProvider.php'))) {
            $cli->line("{$output} [skipped]");

            return $next($cli);
        }

        $cli->line($output);

        $stub = $this->isInertia($laravel) ? 'RouteServiceProvider.inertia.stub.php' : 'RouteServiceProvider.stub.php';
        $laravel['files']->copy(__DIR__ . "/../stubs/app/Providers/{$stub}", $target);

        return $next($cli);
    }

    private function isInertia(Application $laravel): bool
    {
        $schema = $laravel['files']->get($laravel->basePath('composer.json'));
        $schema = json_decode($schema, true);

        $name = $schema['name'] ?? null;

        return $name === 'laravel/react-starter-kit'
            || $name === 'laravel/vue-starter-kit';
    }
}
