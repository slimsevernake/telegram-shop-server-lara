<?php


namespace App\Bot\Commands;

use App\Models\Product;
use WeStacks\TeleBot\Handlers\CommandHandler;

class BuyProductCommand extends CommandHandler
{
    /**
     * @var string Command Name
     */
    protected static $aliases = [ '/buy', ];

    /**
     * @var string Command Description
     */
    protected static $description = 'Send "/start" or "/s" to get "Hello, World!"';

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $text = $this->getMessageText();
        $id = $this->getIdFromCommand($text);
        $product = Product::whereKey($id)->first();

        $this->sendMessage([
            'text' => "Product $product->name purchased",
        ]);
    }
    private function isCallbackQuery(): bool
    {
        return $this->update->is('callback_query');
    }

    private function getMessageText(): string
    {
        return $this->isCallbackQuery() ? $this->update->callback_query->data : $this->update->message()->text;
    }

    private function getIdFromCommand(string $str): int
    {
        return (int) trim(explode(self::$aliases[0], $str)[1]);
    }
}
