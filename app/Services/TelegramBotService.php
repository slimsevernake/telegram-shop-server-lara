<?php


namespace App\Services;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;

class TelegramBotService
{
    private BotMan $bot;

    public function __construct()
    {
        DriverManager::loadDriver(\BotMan\Drivers\Telegram\TelegramDriver::class);
        $this->bot = BotManFactory::create(config('services.botman'));
    }

    public function handle()
    {
        $bot = $this->bot;

        foreach ($this->getCommands() as $name => $command) {
            $bot->hears($name, $command);
        }

        $bot->listen();
    }

    private function getCommands(): array
    {
        return [
            '/start' => function (BotMan $bot) {
                $bot->reply(config('services.telegram.greeting'));
            },
        ];
    }
}
