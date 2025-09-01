<?php declare(strict_types=1);

namespace Masmerise\Revert;

use Closure;
use Illuminate\Foundation\Application;

final readonly class RemoveBootstrapProviders
{
    public function handle(Revert $cli, Closure $next): Revert
    {
        $output = '🧹Removing bootstrap/providers.php...';

        /** @var Application $laravel */
        $laravel = $cli->getLaravel();

        if (! $laravel['files']->exists($target = $laravel->getBootstrapProvidersPath())) {
            $cli->line("{$output} [skipped]");

            return $next($cli);
        }

        $cli->line($output);

        $laravel['files']->delete($target);

        return $next($cli);
    }
}
