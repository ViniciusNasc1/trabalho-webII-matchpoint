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
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Matchup::class);
        return view('matchup.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MatchupRequest $request)
    {
        Gate::authorize('create', Matchup::class);
        $this->service->store($request->validated());
        return redirect()->route('tournaments.show', $request->tournament_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $match = $this->service->find($id,
        [
            'participantA',
            'participantB',
            'winner',
            'result',
        ]);
        Gate::authorize('view', Matchup::class);
        if (isset($match) && !empty($match)) {
            return view('match.view', compact('match'));
        }

        return "<h1>PARTIDA NÃO ENCONTRADA!</h1>";

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $match = $this->service->find($id,
        [
            'participantA',
            'participantB',
            'winner',
            'result',
        ]);;
        Gate::authorize('update', $match);
        if (!isset($match) && !empty($match)) {
            return view('match.edit', compact('match'));
        }

        return "<H1>PARTIDA NÃO ENCONTRADA!</H1>";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MatchupRequest $request, string $id)
    {
        $match = $this->service->find($id,
        [
            'participantA',
            'participantB',
            'winner',
            'result',
        ]);;

        Gate::authorize('update', $match);

        if (isset($match)) {
            $this->service->update($request->validated(), $id);
            return redirect()->route('tournaments.show', $match->tournament_id);
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
            return redirect()->route('tournaments.show', $match->tournament_id);
        }

        return "<h1>PARTIDA NÃO ENCONTRADA!</h1>";
    }

    public function audit(string $id)
    {
        $match = $this->service->find($id);
        Gate::authorize('delete', $match);


        if (isset($match) && !empty($match)) {
            $data = $this->service->audit($id);
            return view('match.audit', compact(['data']));
        }

        return "<h1>JOGO NÃO ENCONTRADO!</h1>";
    }
}
