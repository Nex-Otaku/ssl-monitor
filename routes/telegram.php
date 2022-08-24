<?php
/** @var SergiX44\Nutgram\Nutgram $bot */

use App\Telegram\Commands\Add;
use App\Telegram\Commands\ListSites;
use App\Telegram\Commands\Remove;
use App\Telegram\Commands\Start;
use App\Telegram\Commands\Status;

/*
|--------------------------------------------------------------------------
| Nutgram Handlers
|--------------------------------------------------------------------------
|
| Here is where you can register telegram handlers for Nutgram. These
| handlers are loaded by the NutgramServiceProvider. Enjoy!
|
*/

$bot->onCommand(Start::getName(), Start::class)->description(Start::getDescription());
$bot->onCommand(Status::getName(), Status::class)->description(Status::getDescription());
$bot->onCommand(ListSites::getName(), ListSites::class)->description(ListSites::getDescription());

$bot->onCommand(Add::getName(), [Add::class, 'runCommandByName'])->description(Add::getDescription());
$bot->onText(Add::getPattern(), [Add::class, 'runCommandByPattern']);

$bot->onCommand(Remove::getName(), [Remove::class, 'runCommandByName'])->description(Remove::getDescription());
$bot->onText(Remove::getPattern(), [Remove::class, 'runCommandByPattern']);

$bot->registerMyCommands();
