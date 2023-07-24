<?php

namespace App\Services;

use App\Models\Mission;
use App\Models\MissionMessaging;
use App\Models\MissionProposal;

class HandleProposalService
{
    /**
     * @return bool|array<bool|int>
     */
    public function handle(string $action, MissionProposal $proposal): bool|array
    {
        if ($action === 'negotiated') {
            $proposal->status = 'negotiated';
            $proposal->save();

            $mission = Mission::find($proposal->mission_id);

            $messaging = MissionMessaging::create([
                'mission_id' => $proposal->mission_id,
                'mission_user_id' => $mission->user_id,
                'user_id' => $proposal->user_id,
            ]);

            return [true, $messaging->id];
        } elseif ($action === 'refuse') {
            $proposal->status = 'refused';
            $proposal->save();

            $messaging = MissionMessaging::where('user_id', $proposal->user_id)->where('mission_id', $proposal->mission_id)->first();

            if ($messaging !== null) {
                $messaging->status = 'closed';
                $messaging->save();
            }

            return true;
        } elseif ($action === 'accept') {
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

            return true;
        } elseif ($action === 'cancel') {
            $mission = Mission::find($proposal->mission_id);

            $proposal->status = 'waiting';
            $proposal->save();

            $mission->status = 'open';
            $mission->save();

            return true;
        } else {
            return false;
        }
    }
}
