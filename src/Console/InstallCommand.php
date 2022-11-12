<?php

namespace Zzexts\Poster\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'admin:poster-install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the zzexts poster database';

    /**
     * Install directory.
     *
     * @var string
     */
    protected $directory = '';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->initDatabase();
    }

    /**
     * Create tables and seed it.
     *
     * @return void
     */
    public function initDatabase()
    {
        $this->call('migrate --path=' . __DIR__ . '../../database/migrations/2022_11_12_143245_create_posters_table.php');
    }

}
