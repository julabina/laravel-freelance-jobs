<?php

namespace App\Http\Controllers\Messaging;

use App\Http\Controllers\Controller;
use App\Http\Requests\Messaging\PostMessageRequest;
use App\Models\Message;
use App\Models\MissionMessaging;
use Illuminate\Http\RedirectResponse;

class MessageController extends Controller
{
    public function create(int $id, PostMessageRequest $request): RedirectResponse
    {
        $messaging = MissionMessaging::where('id', $id)->with('mission.user', 'user')->first();

        if ($messaging !== null && ($request->user()->id === $messaging->user_id || $request->user()->id === $messaging->mission->user_id)) {
            Message::create([
                'mission_messaging_id' => $messaging->id,
                'user_id' => $request->user()->id,
                'message' => $request->message,
            ]);

            return back();
        } else {
            return redirect()->route('dashboard');
        }
    }
}
