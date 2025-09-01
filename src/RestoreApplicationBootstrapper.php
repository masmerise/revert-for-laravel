<?php declare(strict_types=1);

namespace Masmerise\Revert;

use Closure;
use Illuminate\Foundation\Application;

final readonly class RestoreApplicationBootstrapper
{
    public function handle(Revert $cli, Closure $next): Revert
    {
        $output = '🔄Restoring bootstrap/app.php...';

        /** @var Application $laravel */
        $laravel = $cli->getLaravel();

        $bootstrapper = $laravel['files']->get($target = $laravel->basePath('bootstrap/app.php'));

        if (str_ends_with($bootstrapper, 'return $app;')) {
            $cli->line("{$output} [skipped]");

            return $next($cli);
        }

        $cli->line($output);

        $laravel['files']->copy(__DIR__ . '/../stubs/bootstrap/app.stub.php', $target);

        return $next($cli);
    }
}
