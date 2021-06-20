<?php

namespace App\Monitoring\Alert\Laravel\Commands;

use App\Monitoring\Alert\AlertChecker;
use App\Notification\EchoNotifier;
use Illuminate\Console\Command;

class AlertDryRunCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alert:dry-run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected            $description = 'Показываем, какие алерты будут отправлены, без реальной отправки';

    private AlertChecker $alertChecker;
    private EchoNotifier $echoNotifier;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        AlertChecker $alertChecker,
        EchoNotifier $echoNotifier
    )
    {
        $this->alertChecker = $alertChecker;
        $this->echoNotifier = $echoNotifier;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->echoNotifier->setOutput($this->output);

        $this->alertChecker
            ->withNotifier($this->echoNotifier)
            ->alertExpiredDomains();

        return 0;
    }
}
