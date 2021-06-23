<?php

namespace App\Console\Commands;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;
use Illuminate\Console\Command;

class HandleTelegramShop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shop:telegram';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DriverManager::loadDriver(TelegramDriver::class);
        $bot = BotManFactory::create(config('services.botman'));

        foreach ($this->getCommands() as $command => $function) {
            $bot->hears($command, $function);
        }

        $bot->hears('hello', function (BotMan $bot) {
            $bot->reply('Hello yourself.');
        });


        $bot->listen();
        print(config('services.telegram.greeting')."\n");
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
