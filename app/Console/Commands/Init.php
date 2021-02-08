<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Init extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minisend:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize application';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        `cp '.env.example' '.env'`;
        Artisan::call('key:generate --ansi');
        Artisan::call('storage:link');
        $this->info('Done! Please configure your environment in .env file.');
        return 0;
    }
}
