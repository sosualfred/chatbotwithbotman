<?php
use App\Http\Controllers\BotManController;
use App\Conversations\FallbackConversation;
use App\Conversations\WelcomeConversation;

$botman = resolve('botman');



$botman->hears('.*Hi|Hello.*', function ($bot) {
    $bot->typesAndWaits(1);
    $bot->reply('Hello!');
    $bot->reply('What is your name?');
});

$botman->hears('my name is {name}', function ($bot, $name) {
    $bot->typesAndWaits(1);
    $bot->reply('Nice to meet you: '.$name);
    $bot->startConversation(new WelcomeConversation());
});


$botman->hears('.*Who is your creator.*', function ($bot) {
    $bot->reply('Sosu Alfred is my creator.');
});

$botman->hears('.*commands.*', function ($bot) {
    $bot->typesAndWaits(1);
    $bot->startConversation(new WelcomeConversation());
});

$botman->hears('.*what is your purpose.*', function ($bot) {
    $bot->typesAndWaits(1);
    $bot->reply('I was created in order for Sosu Alfred to be promoted to stage 4.');
});


$botman->fallback(function($bot) {
    $bot->startConversation(new FallbackConversation());
});



$botman->hears('Start conversation', BotManController::class.'@startConversation');
