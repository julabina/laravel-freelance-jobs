<?php

namespace App\Http\Controllers\Mission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mission\ProposalRequest;
use App\Models\Mission;
use App\Models\MissionLike;
use App\Models\MissionMessaging;
use App\Models\MissionProposal;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FreelanceInteractController extends Controller
{
    /**
     * like one mission
     */
    public function like(int $id, Request $request): RedirectResponse
    {
        $missionLike = MissionLike::where('mission_id', $id)->where('user_id', $request->user()->id)->first();

        if ($missionLike === null) {
            MissionLike::create([
                'mission_id' => $id,
                'user_id' => $request->user()->id,
            ]);
        } else {
            $missionLike->delete();
        }

        return back();
    }

    /**
     * create a proposal for one mission
     */
    public function proposal(ProposalRequest $request): RedirectResponse
    {
        $missionId = $request->id;
        $userId = $request->user()->id;

        $proposal = MissionProposal::where('mission_id', $missionId)
            ->where('user_id', $userId)
            ->first();

        if ($proposal === null) {
            MissionProposal::create([
                'mission_id' => $missionId,
                'user_id' => $userId,
                'message' => $request->message,
            ]);

            $mission = Mission::find($missionId);

            $mission->proposal_count = $mission->proposal_count + 1;
            $mission->save();
        }

        return redirect()->route('mission.show', ['id' => $request->id])->with('message', 'Proposition envoyé avec succes');
    }

    /**
     * remove proposal for one mission
     */
    public function remove(int $id, Request $request): RedirectResponse
    {
        $proposal = MissionProposal::where('mission_id', $id)->where('user_id', $request->user()->id)->first();

        if ($proposal !== null && $proposal->status !== 'granted') {
            $messaging = MissionMessaging::where('mission_id', $id)->where('user_id', $request->user()->id)->first();
            $proposal->delete();

            if ($messaging !== null) {
                $messaging->delete();
            }

            return back();
        } else {
            return redirect(RouteServiceProvider::HOME);
        }
    }
}
