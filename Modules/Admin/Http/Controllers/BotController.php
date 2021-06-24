<?php

namespace App\Modules\Admin\Http\Controllers;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use App\Models\Bot;

class BotController extends Controller
{
    public function getInfo()
    {
        return response()->json([
           'greeting' => Bot::first()->greeting,
        ]);
    }

    public function updateGreeting(Request $request)
    {
        $greeting = $request->validate([
            'greeting' => 'string|required',
        ])['greeting'];

        $updated = Bot::whereKey(1)->update(['greeting' => $greeting]);

        return response()->json([
           'greeting' => $greeting,
        ]);
    }
}
