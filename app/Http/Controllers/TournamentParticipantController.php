<?php

namespace App\Http\Controllers;

use App\Http\Requests\TournamentParticipantRequest;
use App\Models\Tournament;
use App\Models\TournamentParticipant;
use App\Services\TournamentParticipantService;
use Illuminate\Support\Facades\Gate;

class TournamentParticipantController extends Controller
{
    public function __construct(protected TournamentParticipantService $service) { }

    public function index()
    {
        Gate::authorize('viewAny', TournamentParticipant::class);
        $data = $this->service->all(['tournament', 'participant'], [], 'id');
        return view('tournament-participants.index', compact('data'));
    }

    public function create()
    {
        $tournamentId = request('tournament_id');
        $tournament = Tournament::findOrFail($tournamentId);

        $teams = collect();
        if ($tournament->mode === 'team') {
            /** @var \App\Models\User $user */
            $user = request()->user();
            $teams = $user->ownedTeams;
        }

        return view('tournament-participants.create', compact('tournament', 'teams'));
    }

    public function store(TournamentParticipantRequest $request)
    {
        Gate::authorize('create', TournamentParticipant::class);
        $participant = $this->service->store($request->validated());

        return redirect()->route('tournaments.show', $participant->tournament_id)
                         ->with('success', 'Inscrição realizada com sucesso!');
    }

    public function show(string $id)
    {
        $participant = $this->service->find($id, ['tournament', 'participant']);

        if (!isset($participant)) {
            return "<h1>PARTICIPANTE NÃO ENCONTRADO!</h1>";
        }

        Gate::authorize('view', $participant);
        return view('tournament-participants.show', compact('participant'));
    }

    public function edit(string $id)
    {
        $participant = $this->service->find($id, ['tournament', 'participant']);

        if (!isset($participant)) {
            return "<h1>PARTICIPANTE NÃO ENCONTRADO!</h1>";
        }

        Gate::authorize('update', $participant);
        return view('tournament-participants.edit', compact('participant'));
    }

    public function update(TournamentParticipantRequest $request, string $id)
    {
        $participant = $this->service->find($id);

        if (!isset($participant)) {
            return "<h1>PARTICIPANTE NÃO ENCONTRADO!</h1>";
        }

        Gate::authorize('update', $participant);
        $this->service->update($request->validated(), $id);

        return redirect()->route('tournaments.show', $participant->tournament_id)
                         ->with('success', 'Inscrição atualizada com sucesso!');
    }

    public function destroy(string $id)
    {
        $participant = $this->service->find($id);

        if (!isset($participant)) {
            return "<h1>PARTICIPANTE NÃO ENCONTRADO!</h1>";
        }

        Gate::authorize('delete', $participant);
        $this->service->remove($id);

        return redirect()->route('tournaments.show', $participant->tournament_id)
                         ->with('success', 'Inscrição removida com sucesso!');
    }
}