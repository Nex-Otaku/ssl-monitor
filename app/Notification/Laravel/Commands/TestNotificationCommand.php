<?php

namespace App\Notification\Laravel\Commands;

use App\Monitoring\DomainName;
use App\Notification\Channel\NotificationChannel;
use App\Notification\Recipient\Recipient;
use Illuminate\Console\Command;

class TestNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected            $description = 'Отправляем тестовые уведомления';

    private NotificationChannel $telegram;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        NotificationChannel $telegram
    )
    {
        $this->telegram = $telegram;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->telegram->sendDomainNotification(
            new Recipient(true),
            DomainName::fromString('test.domain'),
            'Проверка уведомлений! Как слышно?'
        );

        return 0;
    }
}
