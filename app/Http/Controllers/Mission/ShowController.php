<?php

namespace App\Http\Controllers\Mission;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShowController extends Controller
{
    public function show(int $id, Request $request): RedirectResponse|Response
    {
        $mission = [];

        if ($request->user()->role === 'freelance') {

            $mission = Mission::where('id', $id)->with('mission_like', function ($query) use ($request) {
                $query->where('user_id', '=', $request->user()->id);
            })->with('mission_proposal', function ($query) use ($request) {
                $query->where('user_id', '=', $request->user()->id);
            })->first();

            if ($mission->status === 'closed' || ($mission->status === 'granted' && $mission->mission_proposal[0]['status'] !== 'accepted')) {
                return redirect(RouteServiceProvider::HOME);
            }

        } elseif ($request->user()->role === 'client') {
            $mission = Mission::where('id', $id)->with('mission_like', 'mission_proposal.user')->first();
        }

        if ($mission !== null && ($request->user()->role === 'freelance' || ($request->user()->role === 'client' && ($request->user()->id === $mission->user_id)))) {
            return Inertia::render('Mission/ShowMission', [
                'mission' => $mission,
            ]);
        } else {
            return redirect(RouteServiceProvider::HOME);
        }
    }
}
