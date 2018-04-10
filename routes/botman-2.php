<?php

$botman = resolve('botman');

/*
 * Get User's ID
 */
$botman->hears('id', function ($bot) {
    $user = $bot->getUser();

    $bot->reply('Your ID is: ' . $user->getId());
});
