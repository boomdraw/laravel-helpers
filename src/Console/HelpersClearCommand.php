<?php

namespace BoomDraw\Helpers\Console;

use Illuminate\Console\Command;
use BoomDraw\Helpers\HelpersFinder;

class HelpersClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'helpers:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove helpers from cache';

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
        (new HelpersFinder())->clearHelpers();
        $this->info('Helpers cache cleared!');
    }
}
