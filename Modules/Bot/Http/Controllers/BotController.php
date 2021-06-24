<?php

namespace App\Modules\Bot\Http\Controllers;

use App\Modules\Bot\Services\BotService;
use Illuminate\Http\Request;
use App\Modules\Bot\Http\Controllers\Controller;

class BotController extends Controller
{
    public function handle(BotService $service)
    {
        $service->handle();
    }
}
