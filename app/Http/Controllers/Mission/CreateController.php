<?php

namespace App\Http\Controllers\Mission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mission\StoreRequest;
use App\Models\Mission;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CreateController extends Controller
{
    /**
     * display create mission view
     */
    public function showCreate(): Response
    {
        return Inertia::render('Mission/CreateMission');
    }

    /**
     * store the new mission on DB
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        if ($request->remote === true) {
            $mission = Mission::create([
                'title' => $request->title,
                'user_id' => $request->user()->id,
                'description' => $request->description,
                'remuneration' => $request->remuneration,
                'remote' => true,
            ]);
        } else {
            $mission = Mission::create([
                'title' => $request->title,
                'user_id' => $request->user()->id,
                'description' => $request->description,
                'remuneration' => $request->remuneration,
                'postalcode' => $request->postalCode,
                'city' => $request->city,
            ]);
        }

        if ($mission['id'] !== null) {
            return redirect()->route('mission.show', ['id' => $mission['id']])->with('message', 'Mission créée avec success');
        } else {
            return redirect(RouteServiceProvider::HOME);
        }
    }
}
