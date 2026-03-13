<?php

namespace App\Console;

use Illuminate\Console\Command;

class FilamentLanguageSwitcherInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'filament-language-switcher:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install package and publish assets';

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
        $this->info('Publish Vendor Assets');
        $this->call('migrate');
        $this->call('filament:optimize');
        $this->info('Filament Language Switcher installed successfully.');
    }
}
