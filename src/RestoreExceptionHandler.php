<?php declare(strict_types=1);

namespace Masmerise\Revert;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;

final class RestoreExceptionHandler extends Action
{
    protected string $description = 'Restoring App\\Exceptions\\Handler';

    protected string $emoji = '🔄';

    protected function run(Filesystem $files, Application $laravel): void
    {
        if (! $files->isDirectory($dir = $laravel->path('Exceptions'))) {
            $files->makeDirectory($dir);
        }

        $files->copy($this->stubPath('app/Exceptions/Handler.stub.php'), "{$dir}/Handler.php");
    }

    protected function wasRun(Filesystem $files, Application $laravel): bool
    {
        return $files->isDirectory($dir = $laravel->path('Exceptions')) && $files->exists("{$dir}/Handler.php");
    }
}
