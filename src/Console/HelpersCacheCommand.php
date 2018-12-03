<?php

namespace BoomDraw\Helpers\Console;

use Illuminate\Console\Command;
use BoomDraw\Helpers\HelpersFinder;

class HelpersCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'helpers:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a route cache file for faster route registration and compile all of the application\'s Blade templates';

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
     * @return mixed
     */
    public function handle()
    {
        $this->call('helpers:clear');
        (new HelpersFinder())->cacheHelpers();
        $this->info('Helpers cached successfully!');
    }
}
