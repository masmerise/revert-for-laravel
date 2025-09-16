<?php declare(strict_types=1);

namespace Masmerise\Revert;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;

/** @internal */
final class RestoreHttpKernel extends Action
{
    protected string $description = 'Restoring App\\Http\\Kernel';

    protected function run(Filesystem $files, Application $laravel): void
    {
        $files->copy($this->stubPath('app/Http/Kernel.stub.php'), $laravel->path('Http/Kernel.php'));
    }

    protected function wasRun(Filesystem $files, Application $laravel): bool
    {
        return $files->exists($laravel->path('Http/Kernel.php'));
    }
}
