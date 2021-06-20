<?php

namespace App\Ssl\CheckCertificate\Laravel;

use App\Ssl\CheckCertificate\CertificateChecker\SpatieCertificateChecker;
use App\Ssl\CheckCertificate\Laravel\Commands\CheckCertificateCommand;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class CheckCertificateServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('command.checkCertificate', function () {
            return new CheckCertificateCommand(
                new SpatieCertificateChecker()
            );
        });

        $this->commands(['command.checkCertificate']);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['command.checkCertificate'];
    }
}
