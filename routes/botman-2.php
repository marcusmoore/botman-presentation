<?php

use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use GuzzleHttp\Client;

$botman = resolve('botman');

function getAttendees()
{
    $client = new Client();
    $response = $client->get('https://api.meetup.com/sandiegophp/events/248518561/rsvps');
    $attendees = collect(json_decode($response->getBody()))->map(function ($item){
        return [
            'response' => $item->response,
            'is_host' => $item->member->event_context->host,
            'name' => $item->member->name,
            'photo' => $item->member->photo,
        ];
    })->filter(function ($member){
        return $member['response'] === 'yes' && $member['is_host'] === false;
    });

    return $attendees;
}

$botman->hears('raffle', function ($bot){
    /*
     * Build suspense...
     */
    $bot->typesAndWaits(1);
    $bot->reply("Let's pick a winner for tonight's PHPStorm License!");
    $bot->typesAndWaits(2);

    /*
     * Fetch the RSVPs...
     */
    $attendees = getAttendees();

    /*
     * Send the count...
     */
    $bot->reply("Looks like we're picking from " . $attendees->count() . " RSVPS");
    $bot->typesAndWaits(2);

    /*
     * Pick the winner...
     */
    $winner = $attendees->random(1)->first();
    $bot->reply('I got the winner!');
    $bot->typesAndWaits(3);

    /*
     * Create attachment with winner's image
     */
    $attachment = new Image($winner['photo']->photo_link, [
        'custom_payload' => true,
    ]);

    /*
     * Build outgoing message and send it
     */
    $message = OutgoingMessage::create('The winner is ' . $winner['name'] . '!!!')->withAttachment($attachment);
    $bot->reply($message);
});

// $botman->hears('quick raffle', function ($bot){
//     $winner = getAttendees()->random(1)->first();
//
//     $attachment = new Image($winner['photo']->photo_link, [
//         'custom_payload' => true,
//     ]);
//
//     $message = OutgoingMessage::create('The winner is ' . $winner['name'] . '!!!')->withAttachment($attachment);
//
//     $bot->reply($message);
// });