<?php declare(strict_types=1);

namespace Masmerise\Revert;

use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;

final readonly class ReconcileBootstrapProvidersWithConfigurationProviders
{
    public function handle(Revert $cli, Closure $next): Revert
    {
        $output = '🔀Reconciling providers...';

        /** @var Application $laravel */
        $laravel = $cli->getLaravel();

        $configuration = $laravel['files']->get($target = $laravel->basePath('config/app.php'));

        if (! str_contains($configuration, '/** {{$providers}} */')) {
            $cli->line("{$output} [skipped]");

            return $next($cli);
        }

        $cli->line($output);

        $providers = Collection::make(require $laravel->getBootstrapProvidersPath())
            ->merge(['App\\Providers\\RouteServiceProvider'])
            ->unique()
            ->sort()
            ->values()
            ->map(static fn (string $p) => "{$p}::class,")
            ->join("\n        ");

        $config = $laravel['files']->get($target);
        $laravel['files']->put($target, str_replace('/** {{$providers}} */', $providers, $config));

        return $next($cli);
    }
}
