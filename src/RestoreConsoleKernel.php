<?php declare(strict_types=1);

namespace Masmerise\Revert;

use Closure;
use Illuminate\Foundation\Application;

final readonly class RestoreConsoleKernel
{
    public function handle(Revert $cli, Closure $next): Revert
    {
        $output = '🔄Restoring App\\Console\\Kernel...';

        /** @var Application $laravel */
        $laravel = $cli->getLaravel();

        if ($laravel['files']->isDirectory($laravel->path('Console'))) {
            $cli->line("{$output} [skipped]");

            return $next($cli);
        }

        $cli->line($output);

        $laravel['files']->makeDirectory($laravel->path('Console'));
        $laravel['files']->copy(__DIR__ . '/../stubs/app/Console/Kernel.stub.php', $laravel->path('Console/Kernel.php'));

        return $next($cli);
    }
}
