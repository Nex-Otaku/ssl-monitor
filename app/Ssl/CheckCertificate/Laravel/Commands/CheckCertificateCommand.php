<?php

namespace App\Ssl\CheckCertificate\Laravel\Commands;

use App\Ssl\CheckCertificate\CertificateChecker\CertificateChecker;
use Illuminate\Console\Command;

class CheckCertificateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ssl:check {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Проверить SSL сертификат на указанном домене';

    private CertificateChecker $certificateChecker;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        CertificateChecker $certificateChecker
    )
    {
        $this->certificateChecker = $certificateChecker;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $info = $this->certificateChecker->check($this->argument('domain'));
        $this->info("Дата истечения сертификата по домену {$info->getDomain()} - {$info->getExpireDate()}");
        $this->info("Сертификат выпущен: {$info->getIssuerOrganization()}");

        return 0;
    }
}
