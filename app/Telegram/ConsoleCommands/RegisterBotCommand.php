<?php

namespace App\Telegram\ConsoleCommands;

use Illuminate\Console\Command;
use SergiX44\Nutgram\Nutgram;

class RegisterBotCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Зарегистрировать вебхук и команды бота в Телеграм';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Nutgram $bot)
    {
        $bot->registerMyCommands();
        // TODO Зарегистрировать вебхук

        echo "Бот зарегистрировал команды и вебхук в Телеграм\n";

        return 0;
    }
}
