<?php

namespace App\Http\Controllers\Mission;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Models\MissionProposal;
use App\Services\HandleProposalService;
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
    public function updateProposal(int $id, Request $request, HandleProposalService $handleService): RedirectResponse
    {
        $request->validate([
            'action' => 'required|string|max:255',
        ]);

        $proposal = MissionProposal::where('id', $id)->with('user')->first();

        $handle = $handleService->handle($request->action, $proposal);

        if ($handle === true || $handle[0] === true) {
            if ($request->action === 'negotiated') {
                return redirect()->route('messaging.show', ['id' => $handle[1]]);
            } else {
                return back();
            }
        } else {
            return redirect()->route('dashboard');
        }
    }
}
