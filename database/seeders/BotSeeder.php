<?php

namespace Database\Seeders;

use App\Models\Bot;
use Illuminate\Database\Seeder;

class BotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bot::create([
            'name' => 'Telegram Shop',
            'greeting' => config('services.telegram.greeting'),
        ]);
    }
}
