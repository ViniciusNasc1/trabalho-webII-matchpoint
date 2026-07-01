<?php

namespace App\Http\Controllers;

use App\Http\Requests\TournamentRequest;
use App\Models\Tournament;
use App\Services\TournamentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use \App\Models\Game;

class TournamentController extends Controller
{
    public function __construct(protected TournamentService $service) { }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Tournament::class);
        $data = $this->service->all(['game', 'creator', 'matches', 'participants'], [], 'created_at');
        return view('tournaments.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Tournament::class);
        $games = Game::all();
        return view('tournaments.create', compact('games'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TournamentRequest $request)
    {
        Gate::authorize('create', Tournament::class);

        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['status'] = 'draft';

        $this->service->store($data);

        return redirect()->route('tournaments.index')
                         ->with('success', 'Torneio criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tournament = $this->service->find($id, ['game', 'creator', 'matches', 'participants']);

        Gate::authorize('view', $tournament);

        if (isset($tournament) && !empty($tournament)) {
            return view('tournaments.show', compact('tournament'));
        }

        return "<h1>TORNEIO NÃO ENCONTRADO</h1>";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tournament = $this->service->find($id, ['game', 'creator', 'matches', 'participants']);

        Gate::authorize('update', $tournament);

        if (isset($tournament) && !empty($tournament)) {
            $games = Game::all();
            return view('tournaments.edit', compact('tournament', 'games'));
        }

        return "<h1>TORNEIO NÃO ENCONTRADO</h1>";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TournamentRequest $request, string $id)
    {
        $tournament = $this->service->find($id, ['game', 'creator', 'matches', 'participants']);

        Gate::authorize('update', $tournament);

        if (isset($tournament) && !empty($tournament)) {
            $this->service->update($request->validated(), $id);
            return redirect()->route('tournaments.index')
                             ->with('success', 'Torneio atualizado com sucesso!');
        }

        return "<h1>TORNEIO NÃO ENCONTRADO</h1>";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tournament = $this->service->find($id);

        Gate::authorize('delete', $tournament);

        if (isset($tournament) && !empty($tournament)) {
            $this->service->remove($id);
            return redirect()->route('tournaments.index')
                             ->with('success', 'Torneio removido com sucesso!');
        }

        return "<h1>TORNEIO NÃO ENCONTRADO</h1>";
    }

    public function audit(string $id)
    {
        $tournament = $this->service->find($id);
        Gate::authorize('delete', $tournament);

        if (isset($tournament) && !empty($tournament)) {
            $data = $this->service->audit($id);
            return view('tournaments.audit', compact(['data']));
        }

        return "<h1>TORNEIO NÃO ENCONTRADO!</h1>";
    }

    public function start(string $id)
    {
        $tournament = $this->service->find($id, ['participants']);
        Gate::authorize('update', $tournament);

        if (!isset($tournament)) {
            return "<h1>TORNEIO NÃO ENCONTRADO</h1>";
        }

        $result = $this->service->startTournament($id);

        if (!$result) {
            return back()->withErrors('Não foi possível iniciar o torneio. Verifique o número de participantes.');
        }

        return redirect()->route('tournaments.show', $id)
                        ->with('success', 'Torneio iniciado! Bracket gerado com sucesso.');
    }
}