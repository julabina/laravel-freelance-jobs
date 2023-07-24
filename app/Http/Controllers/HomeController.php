<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\MissionLike;
use App\Models\MissionProposal;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function show(Request $request): Response
    {
        $fav = null;
        if ($request->user()->role === 'client') {
            $missions = Mission::where('user_id', $request->user()->id)->get();
        } else {
            $missions = MissionProposal::where('user_id', $request->user()->id)->with('mission')->get();
            $fav = MissionLike::where('user_id', $request->user()->id)->with('mission')->get();
        }

        return Inertia::render('Dashboard', [
            'missions' => $missions,
            'fav' => $fav,
        ]);
    }
}
