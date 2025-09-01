<?php declare(strict_types=1);

namespace Masmerise\Revert;

use Illuminate\Console\Command;
use Illuminate\Pipeline\Pipeline;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('revert')]
final class Revert extends Command
{
    protected $description = 'Revert Laravel 11+ installations to their former structure.';

    protected $signature = 'revert';

    public function handle(): int
    {
        if (version_compare($version = $this->laravel->version(), '12.0.0', '<')) {
            $this->error("❌ Laravel 12 is required to run this command. This version is: {$version}");

            return self::FAILURE;
        }

        new Pipeline($this->laravel)->send($this)->through([
            RestoreConsoleKernel::class,
            RestoreHttpKernel::class,
            RestoreExceptionHandler::class,
            RestoreRouteServiceProvider::class,
            RestoreApplicationBootstrapper::class,
            RestoreApplicationConfiguration::class,
            ReconcileBootstrapProvidersWithConfigurationProviders::class,
            RemoveBootstrapProviders::class,
        ])->thenReturn();

        $this->info('✅ Laravel reverted to its former structure!');

        return self::SUCCESS;
    }
}
