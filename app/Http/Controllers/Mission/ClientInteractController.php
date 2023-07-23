<?php

namespace App\Http\Controllers\Mission;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Models\MissionMessaging;
use App\Models\MissionProposal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClientInteractController extends Controller
{
    /**
     * update the mission status
     */
    public function updateStatus(int $id, Request $request): RedirectResponse
    {
        $mission = Mission::find($id);

        if ($mission->user_id === $request->user()->id) {
            if ($mission->status === 'open') {
                $mission->status = 'closed';
            } elseif ($mission->status === 'closed') {
                $mission->status = 'open';
            } else {
                return redirect()->route('dashboard');
            }

            $mission->save();

            return redirect()->route('mission.show', ['id' => $id]);
        }

        return redirect()->route('dashboard');
    }

    /**
     * update the mission status to granted or if granted to open
     */
    public function updateGrantedStatus(int $id, Request $request): RedirectResponse
    {
        $mission = Mission::find($id);

        if ($mission->user_id === $request->user()->id) {
            if ($mission->status === 'granted') {
                $mission->status = 'open';
            } else {
                $mission->status = 'granted';
            }

            $mission->save();

            return redirect()->route('mission.show', ['id' => $id]);
        }

        return redirect()->route('dashboard');
    }

    /**
     * response for one mission proposal
     */
    public function updateProposal(int $id, Request $request): RedirectResponse
    {
        $request->validate([
            'action' => 'required|string|max:255',
        ]);

        $proposal = MissionProposal::where('id', $id)->with('user')->first();

        if ($request->action === 'negotiated') {
            $proposal->status = 'negotiated';
            $proposal->save();

            $mission = Mission::find($proposal->mission_id);

            $messaging = MissionMessaging::create([
                'mission_id' => $proposal->mission_id,
                'mission_user_id' => $mission->user_id,
                'user_id' => $proposal->user_id,
            ]);

            return redirect()->route('messaging.show', ['id' => $messaging->id]);
        } elseif ($request->action === 'refuse') {
            $proposal->status = 'refused';
            $proposal->save();

            $messaging = MissionMessaging::where('user_id', $proposal->user_id)->where('mission_id', $proposal->mission_id)->first();

            if ($messaging !== null) {
                $messaging->status = 'closed';
                $messaging->save();
            }

            return back();
        } elseif ($request->action === 'accept') {
            $mission = Mission::find($proposal->mission_id);

            $proposal->status = 'accepted';
            $proposal->save();

            $mission->status = 'granted';
            $mission->save();

            $messagings = MissionMessaging::whereNot('user_id', $proposal->user_id)->where('mission_id', $proposal->mission_id)->get();

            if ($messagings !== null) {
                foreach ($messagings as $key => $mes) {
                    $mes->status = 'closed';
                    $mes->save();
                }
            }

            return back();
        } elseif ($request->action === 'cancel') {
            $mission = Mission::find($proposal->mission_id);

            $proposal->status = 'waiting';
            $proposal->save();

            $mission->status = 'open';
            $mission->save();

            return back();
        } else {
            return redirect()->route('dashboard');
        }
    }
}
