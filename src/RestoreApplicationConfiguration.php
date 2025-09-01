<?php declare(strict_types=1);

namespace Masmerise\Revert;

use Closure;
use Illuminate\Foundation\Application;

final readonly class RestoreApplicationConfiguration
{
    public function handle(Revert $cli, Closure $next): Revert
    {
        $output = '🔄Restoring config/app.php...';

        /** @var Application $laravel */
        $laravel = $cli->getLaravel();

        $configuration = $laravel['files']->get($target = $laravel->basePath('config/app.php'));

        if (str_contains($configuration, '| Autoloaded Service Providers')) {
            $cli->line("{$output} [skipped]");

            return $next($cli);
        }

        $cli->line($output);

        $laravel['files']->copy(__DIR__ . '/../stubs/config/app.stub.php', $target);

        return $next($cli);
    }
}
