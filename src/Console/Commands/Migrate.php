<?php

namespace Awobaz\Laracraft\Console\Commands;

class Migrate extends Base
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laracraft:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run database migrations for Laracraft';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('migrate', [
            '--path' => 'vendor/awobaz/laracraft/database/migrations',
        ]);
    }
}
