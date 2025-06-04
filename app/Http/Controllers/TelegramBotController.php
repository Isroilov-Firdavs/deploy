<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TelegramBotController extends Controller
{
    //code
    public function handle(Request $request)
    {
        $telegram = new Api(config('telegram.bot_token'));

        $update = $telegram->getWebhookUpdate();

        $message = $update->getMessage();

        if ($message && $message->getText() === '/start') {
            $chatId = $message->getChat()->getId();

            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => 'Hello world',
            ]);
        }

        return response('OK', 200);
    }
}
