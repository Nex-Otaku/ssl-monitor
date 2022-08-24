<?php
/** @var SergiX44\Nutgram\Nutgram $bot */

use SergiX44\Nutgram\Nutgram;

/*
|--------------------------------------------------------------------------
| Nutgram Handlers
|--------------------------------------------------------------------------
|
| Here is where you can register telegram handlers for Nutgram. These
| handlers are loaded by the NutgramServiceProvider. Enjoy!
|
*/

$bot->onCommand('start', function (Nutgram $bot) {
    return $bot->sendMessage('Start');
})->description('The start command');

$bot->onCommand('status', function (Nutgram $bot) {
    return $bot->sendMessage('Status');
})->description('Status command');

$bot->onCommand('list', function (Nutgram $bot) {
    return $bot->sendMessage('List');
})->description('List command');

$bot->onCommand('add', function (Nutgram $bot) {
    return $bot->sendMessage('Add');
})->description('Add command');

$bot->onCommand('remove', function (Nutgram $bot) {
    return $bot->sendMessage('Remove');
})->description('Remove command');
