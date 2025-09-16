<?php declare(strict_types=1);

namespace Masmerise\Revert;

use Closure;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;

/** @internal */
abstract class Action
{
    protected string $description;

    abstract protected function run(Filesystem $files, Application $laravel): void;

    abstract protected function wasRun(Filesystem $files, Application $laravel): bool;

    public function handle(Revert $cli, Closure $next): Revert
    {
        $output = "{$this->description}...";

        /** @var Application $laravel */
        $laravel = $cli->getLaravel();

        /** @var Filesystem $files */
        $files = $laravel['files'];

        if ($this->wasRun($files, $laravel)) {
            $cli->outputComponents()->warn("{$output} [skipped]");

            return $next($cli);
        }

        $cli->outputComponents()->info($output);

        $this->run($files, $laravel);

        return $next($cli);
    }

    protected function stubPath(string $path): string
    {
        return __DIR__ . "/../stubs/{$path}";
    }
}
