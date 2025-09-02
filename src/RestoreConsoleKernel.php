<?php declare(strict_types=1);

namespace Masmerise\Revert;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;

final class RestoreConsoleKernel extends Action
{
    protected string $description = 'Restoring App\\Console\\Kernel';

    protected string $emoji = '🔄';

    protected function run(Filesystem $files, Application $laravel): void
    {
        if (! $files->isDirectory($dir = $laravel->path('Console'))) {
            $files->makeDirectory($dir);
        }

        $files->copy($this->stubPath('app/Console/Kernel.stub.php'), "{$dir}/Kernel.php");
    }

    protected function wasRun(Filesystem $files, Application $laravel): bool
    {
        return $files->isDirectory($dir = $laravel->path('Console')) && $files->exists("{$dir}/Kernel.php");
    }
}
