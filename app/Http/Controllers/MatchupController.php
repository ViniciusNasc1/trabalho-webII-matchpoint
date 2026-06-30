<?php

namespace App\Http\Controllers;

use App\Http\Requests\MatchupRequest;
use App\Models\Matchup;
use App\Services\MatchupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MatchupController extends Controller
{
    public function __construct(protected MatchupService $service) { }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Matchup::class);
        $data = $this->service->all(['tournament', 'participantA', 'participantB', 'winner'], [], 'created_at');
        return view('matchups.index', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MatchupRequest $request)
    {
        Gate::authorize('create', Matchup::class);
        $this->service->store($request->validated());

        return redirect()->route('tournaments.show', $request->tournament_id)
                         ->with('success', 'Partida criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $match = $this->service->find($id, [
            'participantA',
            'participantB',
            'winner',
            'result',
        ]);

        Gate::authorize('view', $match);

        if (isset($match) && !empty($match)) {
            return view('matchups.show', compact('match'));
        }

        return "<h1>PARTIDA NÃO ENCONTRADA!</h1>";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MatchupRequest $request, string $id)
    {
        $match = $this->service->find($id, [
            'participantA',
            'participantB',
            'winner',
            'result',
        ]);

        Gate::authorize('update', $match);

        if (isset($match)) {
            $this->service->update($request->validated(), $id);
            return redirect()->route('tournaments.show', $match->tournament_id)
                             ->with('success', 'Partida atualizada com sucesso!');
        }

        return "<h1>PARTIDA NÃO ENCONTRADA!</h1>";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $match = $this->service->find($id);

        Gate::authorize('delete', $match);

        if (isset($match)) {
            $this->service->remove($id);
            return redirect()->route('tournaments.show', $match->tournament_id)
                             ->with('success', 'Partida removida com sucesso!');
        }

        return "<h1>PARTIDA NÃO ENCONTRADA!</h1>";
    }

    public function audit(string $id)
    {
        $match = $this->service->find($id);
        Gate::authorize('delete', $match);

        if (isset($match) && !empty($match)) {
            $data = $this->service->audit($id);
            return view('matchups.audit', compact(['data']));
        }

        return "<h1>PARTIDA NÃO ENCONTRADA!</h1>";
    }
}