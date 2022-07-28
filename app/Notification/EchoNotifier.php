<?php

namespace App\Notification;

use App\Monitoring\DomainName;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

class EchoNotifier implements Notifier
{
    private OutputInterface $output;

    public function __construct()
    {
        $this->output = new NullOutput();
    }

    public function notifyDomainOwner(DomainName $domain, string $message): void
    {
        $this->output->info("{$domain->toString()}: {$message}");
    }

    public function setOutput(OutputInterface $output): void
    {
        $this->output = $output;
    }

    public function notifyAdmin(string $message): void
    {
        $this->output->info("Message to admin: {$message}");
    }
}
