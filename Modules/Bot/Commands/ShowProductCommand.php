<?php


namespace App\Modules\Bot\Commands;

use App\Models\Product;
use WeStacks\TeleBot\Handlers\CommandHandler;
use WeStacks\TeleBot\Objects\Update;
use WeStacks\TeleBot\Objects\WebhookInfo;

class ShowProductCommand extends CommandHandler
{
    private const START_COMMAND = '/start';

    /**
     * @var string Command Name
     */
    protected static $aliases = [ '/show', ];

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

        if (str_contains($text, self::$aliases[0])) {
            $id = $this->getIdFromCommand($text);
            $product = Product::whereKey($id)->first();
            if (is_null($product)) {
                return;
            }
            $this->sendProduct($product);
        } elseif (str_contains($text, self::START_COMMAND)) {
            $product = Product::whereKey(1)->first();
            $this->sendProduct($product);
        }
    }

    private function sendProduct(Product $product): void
    {
        $keyboard = $this->makeProductKeyboard($product);

        $this->sendPhoto([
            'reply_markup' => [
                'inline_keyboard' => $keyboard,
            ],
            'caption' => $product->name . "\n" . $product->description,
            'photo' => $product->image,
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

    private function makeProductKeyboard(Product $product): array
    {
        $keyboard = [[]];
        $id = $product->getKey();
        $count = Product::count();

        $keyboard[0][0] = $id > 1 ?
            [
                'text' => '⬅️',
                'callback_data' => '/show '.$id-1,
            ]
            : [
                'text' => '🚫',
                'callback_data' => 'none',
            ];

        $keyboard[0][1] = $product->is_available ?
            [
                'text' => 'Buy',
                'callback_data' => '/buy '.$id,
            ]
            : [
                'text' => 'Not available now',
                'callback_data' => 'none',
            ];

        $keyboard[0][2] = $id < $count ?
            [
                'text' => '➡️',
                'callback_data' => '/show '.$id+1,
            ]
            : [
                'text' => '🚫',
                'callback_data' => 'none',
            ];

        return $keyboard;
    }

    private function getIdFromCommand(string $str): int
    {
        return (int) trim(explode(self::$aliases[0], $str)[1]);
    }
}
