<?php declare(strict_types=1);

namespace Masmerise\Revert;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Facades\Pipeline;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Process\Process;

#[AsCommand('revert')]
final class Revert extends Command
{
    use ConfirmableTrait;

    protected $description = 'Revert Laravel 12.x installations to the original 5.x structure.';

    protected $signature = 'revert';

    public function handle(): int
    {
        if (version_compare($version = $this->laravel->version(), '12.0.0', '<')) {
            $this->components->error("Laravel 12 is required to run this command. This version is: {$version}");

            return self::FAILURE;
        }

        if (! $this->confirmToProceed('Structural changes will be made.', true)) {
            return self::SUCCESS;
        }

        Pipeline::send($this)->through([
            RestoreConsoleKernel::class,
            RestoreHttpKernel::class,
            RestoreExceptionHandler::class,
            RestoreRouteServiceProvider::class,
            RestoreApplicationBootstrapper::class,
            RestoreApplicationConfiguration::class,
            ReconcileBootstrapProvidersWithConfigurationProviders::class,
            RemoveBootstrapProviders::class,
        ])->thenReturn();

        $this->components->info('Laravel reverted to its former structure!');

        if (! $this->components->confirm('Would you like to remove the package now?')) {
            $this->components->success('Do not forget to remove the package as it is no longer needed!');

            return self::SUCCESS;
        }

        Process::fromShellCommandline('composer remove masmerise/revert-for-laravel --dev')
            ->run(fn (string $_, string $line) => $this->line("    {$line}"));

        $this->components->success('Revert has been removed from your project. Happy Laraveling!');

        return self::SUCCESS;
    }
}
