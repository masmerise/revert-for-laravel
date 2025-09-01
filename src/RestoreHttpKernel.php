<?php declare(strict_types=1);

namespace Masmerise\Revert;

use Closure;
use Illuminate\Foundation\Application;

final readonly class RestoreHttpKernel
{
    public function handle(Revert $cli, Closure $next): Revert
    {
        $output = '🔄Restoring App\\Http\\Kernel...';

        /** @var Application $laravel */
        $laravel = $cli->getLaravel();

        if ($laravel['files']->exists($target = $laravel->path('Http/Kernel.php'))) {
            $cli->line("{$output} [skipped]");

            return $next($cli);
        }

        $cli->line($output);

        $laravel['files']->copy(__DIR__ . '/../stubs/app/Http/Kernel.stub.php', $laravel->path('Http/Kernel.php'));

        return $next($cli);
    }
}
