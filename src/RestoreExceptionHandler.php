<?php declare(strict_types=1);

namespace Masmerise\Revert;

use Closure;
use Illuminate\Foundation\Application;

final readonly class RestoreExceptionHandler
{
    public function handle(Revert $cli, Closure $next): Revert
    {
        $output = '🔄Restoring App\\Exceptions\\Handler...';

        /** @var Application $laravel */
        $laravel = $cli->getLaravel();

        if ($laravel['files']->isDirectory($laravel->path('Exceptions'))) {
            $cli->line("{$output} [skipped]");

            return $next($cli);
        }

        $cli->line($output);

        $laravel['files']->makeDirectory($laravel->path('Exceptions'));
        $laravel['files']->copy(__DIR__ . '/../stubs/app/Exceptions/Handler.stub.php', $laravel->path('Exceptions/Handler.php'));

        return $next($cli);
    }
}
