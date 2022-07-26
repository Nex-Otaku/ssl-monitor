<?php

namespace App\Monitoring\Commands;

use App\Common\Logger\EchoLogger;
use App\Monitoring\SiteChecker;
use App\Ssl\CheckCertificate\CertificateChecker\SpatieCertificateChecker;
use Illuminate\Console\Command;

class CheckSitesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitoring:check-sites';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Проверяем сайты на доступность';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new SiteChecker(new SpatieCertificateChecker()))->checkSites(new EchoLogger());

        return 0;
    }
}
