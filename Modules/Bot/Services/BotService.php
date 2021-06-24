<?php


namespace App\Modules\Bot\Services;

use App\Modules\Bot\Commands\BuyProductCommand;
use App\Modules\Bot\Commands\ShowProductCommand;
use App\Modules\Bot\Commands\StartCommand;
use App\Models\Product;
use WeStacks\TeleBot\Objects\Update;
use WeStacks\TeleBot\TeleBot;

class BotService
{
    private const EMPTY_BUTTONS_DATA = 'none';

    private TeleBot $bot;
    private array $commands;

    public function __construct()
    {
        $this->commands = $this->getCommands();
        $this->bot = new TeleBot([
            'token' => config('telebot.bots.bot.token'),
            'handlers' => array_values($this->commands),
        ]);
    }

    public function handle()
    {
        $bot = $this->bot;
        $bot->setWebhook(['url' => config('telebot.bots.bot.webhook.url')]);
        $update = $bot->handleUpdate();

        if ($update->is('callback_query')) {
            $command = explode(' ', $update->callback_query->data)[0];

            if ($command != self::EMPTY_BUTTONS_DATA) {
                $this->callHandlerByCommand($command,  $update);
            }
        }
    }

    private function callHandlerByCommand(string $command, Update $update): void
    {
        $this->bot->callHandler($this->commands[$command], $update, true);
    }

    private function getCommands(): array
    {
        return [
            '/start' => StartCommand::class,
            '/show' => ShowProductCommand::class,
            '/buy' => BuyProductCommand::class,
        ];
    }
}
