<?php

namespace Awobaz\Laracraft\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;
use Illuminate\Support\Str;

class Install extends Command
{
    use DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laracraft:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Laracraft';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Publishing Laracraft Service Provider...');
        $this->callSilent('vendor:publish', ['--tag' => 'laracraft-provider']);

        $this->comment('Publishing Laracraft Assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'laracraft-assets']);

        $this->comment('Publishing Laracraft Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'laracraft-config']);

        $this->info('Laracraft installed successfully.');
        $this->registerLaracraftServiceProvider();

        $this->info('Laracraft scaffolding installed successfully.');
    }

    /**
     * Register the Laracraft service provider in the application configuration file.
     *
     * @return void
     */
    protected function registerLaracraftServiceProvider()
    {
        $namespace = Str::replaceLast('\\', '', $this->getAppNamespace());

        $appConfig = file_get_contents(config_path('app.php'));

        if (Str::contains($appConfig, $namespace.'\\Providers\\LaracraftServiceProvider::class')) {
            return;
        }

        file_put_contents(config_path('app.php'), str_replace(
            "{$namespace}\\Providers\EventServiceProvider::class,".PHP_EOL,
            "{$namespace}\\Providers\EventServiceProvider::class,".PHP_EOL."        {$namespace}\Providers\LaracraftServiceProvider::class,".PHP_EOL,
            $appConfig
        ));

        file_put_contents(app_path('Providers/LaracraftServiceProvider.php'), str_replace(
            "namespace App\Providers;",
            "namespace {$namespace}\Providers;",
            file_get_contents(app_path('Providers/LaracraftServiceProvider.php'))
        ));
    }
}
