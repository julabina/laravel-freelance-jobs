<?php

namespace App\Http\Controllers\Mission;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ShowController extends Controller
{
    /**
     * show one mission
     */
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

    /**
     * list all open missions
     */
    public function list(Request $request): Response
    {
        $user = Auth::user();

        $column = 'created_at';
        $sort = 'ASC';

        $missions = Mission::orderBy('updated_at', 'desc')->with(['mission_like' => function ($query) use ($user) {
            $query->where('user_id', '=', $user->id);
        }])->with('user')->paginate(50)->through(function ($missions) {
            return [
                'id' => $missions->id,
                'title' => $missions->title,
                'remuneration' => $missions->remuneration,
                'proposal_count' => $missions->proposal_count,
                'remote' => $missions->remote,
                'postalcode' => $missions->postalcode,
                'city' => $missions->city,
                'status' => $missions->status,
                'username' => $missions->user->name,
                'mission_like' => $missions->mission_like,
                'created_at' => $missions->created_at,
                'updated_at' => $missions->updated_at,
            ];
        });

        return Inertia::render('Mission/ListMissions', [
            'missions' => $missions,
        ]);
    }
}
