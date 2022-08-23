<?php

namespace App\Ssl;

use App\Ssl\Commands\CheckCertificateCommand;
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
        $this->app->bind(CertificateChecker::class, SpatieCertificateChecker::class);
        $app = $this->app;

        $this->app->singleton('command.checkCertificate', function () use ($app) {
            return $app->make(CheckCertificateCommand::class);
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
