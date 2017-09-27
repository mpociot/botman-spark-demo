<?php
require_once('vendor/autoload.php');
require_once('PizzaConversation.php');

use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\DoctrineCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\Drivers\CiscoSpark\CiscoSparkDriver;
use Doctrine\Common\Cache\FilesystemCache;
use Dotenv\Dotenv;

$dotenv = new Dotenv(__DIR__);
$dotenv->load();

// Explicitly load Cisco Spark driver
DriverManager::loadDriver(CiscoSparkDriver::class);

$cache = __DIR__ . '/cache/';
if (!is_dir($cache)) {
	mkdir($cache, 0777);
}
$cacheDriver = new FilesystemCache('cache');

$botman = BotManFactory::create([
	'cisco-spark' => [
		'token' => getenv('CISCO_SPARK_TOKEN')
	]
], new DoctrineCache($cacheDriver));

// Simple examples
$botman->hears('Spark is great', function($bot) {
	$bot->reply('We know that already! 🤗');
});

$botman->hears('What about markdown', function($bot) {
	$bot->reply('**Markdown** works _too_');
});

// Patterns
$botman->hears('Call me {name}', function($bot, $name) {
    $bot->reply('Hello '.$name);
});

// Regular expression + user storage
$botman->hears('I am ([0-9]+) years old', function($bot, $age) {
    $bot->reply('Got it - your age is: '.$age);
    $bot->userStorage()->save([
        'age' => $age
    ]);
});

$botman->hears('How old am i', function($bot) {
    $user = $bot->userStorage()->get();
    $bot->reply('You are '.$user->get('age'));
});

// Conversations
$botman->hears('pizza', function($bot) {
	$bot->startConversation(new PizzaConversation());
});

$botman->listen();
