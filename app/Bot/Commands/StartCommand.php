<?php


namespace App\Bot\Commands;

use WeStacks\TeleBot\Handlers\CommandHandler;

class StartCommand extends CommandHandler
{
    private const FIRST_COMMAND = '/show 1';

    /**
     * @var string Command Name
     */
    protected static $aliases = [ '/start', '/s' ];

    /**
     * @var string Command Description
     */
    protected static $description = 'Send "/start" or "/s" to get "Hello, World!"';

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $this->sendMessage([
            'text' => config('services.telegram.greeting'),
        ]);

        $this->bot->callHandler(ShowProductCommand::class, $this->update, true);
    }
}
