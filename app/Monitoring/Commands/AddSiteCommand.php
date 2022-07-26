<?php

namespace App\Monitoring\Commands;

use App\Monitoring\Entities\MonitoringSite;
use Illuminate\Console\Command;

class AddSiteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitoring:add-site {domain} {userTgId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Добавить сайт в отслеживание';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        MonitoringSite::create($this->argument('domain'), $this->argument('userTgId'));

        return 0;
    }
}
