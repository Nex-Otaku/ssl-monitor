<?php

namespace App\Alert\Commands;

use App\Alert\AlertChecker;
use App\Logger\EchoLogger;
use Illuminate\Console\Command;

class AlertSslCertificatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alert:ssl-certificates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected            $description = 'Проверяем домены и алертим';

    private AlertChecker $alertChecker;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        AlertChecker $alertChecker,
    )
    {
        $this->alertChecker = $alertChecker;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->alertChecker
            ->withLogger(new EchoLogger())
            ->alertExpiredDomains();

        return 0;
    }
}
