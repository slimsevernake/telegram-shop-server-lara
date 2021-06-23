<?php

namespace App\Http\Controllers;

use App\Services\TelegramBotService;
use Illuminate\Http\Request;

class TelegramBotController extends Controller
{
    public function handle(TelegramBotService $service)
    {
        $service->handle();
    }
}
