<?php
use App\Http\Controllers\BotManController;

$botman = resolve('botman');

/*
 * Simple response
 */
$botman->hears('Hi', function ($bot) {
    $bot->reply('Hello!');
});

/*
 * Simple response with user details
 */
// $botman->hears('Hi', function ($bot) {
//     $user = $bot->getUser();
//     $bot->reply('Hello ' . $user->getFirstName());
// });

/*
 * Starting a conversation
 */
$botman->hears('Start conversation', BotManController::class.'@startConversation');
