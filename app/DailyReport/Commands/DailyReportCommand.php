<?php

namespace App\DailyReport\Commands;

use App\DailyReport\DailyReport;
use App\Notification\EchoNotifier;
use Illuminate\Console\Command;

class DailyReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily-report:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected            $description = 'Ежедневный отчёт о работе сервиса';

    private DailyReport  $dailyReport;
    private EchoNotifier $echoNotifier;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        DailyReport $dailyReport,
        EchoNotifier $echoNotifier
    )
    {
        $this->dailyReport  = $dailyReport;
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

        $this->dailyReport
            ->send();

        return 0;
    }
}
