<?php

namespace App\Http\Controllers\Messaging;

use App\Http\Controllers\Controller;
use App\Models\MissionMessaging;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MessagingController extends Controller
{
    /**
     * display a messaging page
     */
    public function show(int $id, Request $request): Response|RedirectResponse
    {
        $messaging = MissionMessaging::where('id', $id)->with('message.user', 'mission.user', 'user')->first();

        if ($messaging !== null && ($request->user()->id === $messaging->user_id || $request->user()->id === $messaging->mission->user_id)) {
            return Inertia::render('Messaging/Show', [
                'messaging' => $messaging,
            ]);
        } else {
            return redirect()->route('dashboard');
        }

    }

    /**
     * list all current user messaging
     */
    public function list(Request $request): Response
    {
        $user = $request->user();

        $messagings = [];
        if ($user->role === 'freelance') {
            $messagings = MissionMessaging::where('user_id', $user->id)->with('user', 'mission.user', 'message')->get();
        } elseif ($request->user()->role === 'client') {
            $messagings = MissionMessaging::where('mission_user_id', $user->id)->with('user', 'mission.user', 'message')->get();
        }

        return Inertia::render('Messaging/List', [
            'messagings' => $messagings,
        ]);
    }
}
