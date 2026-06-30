<?php

namespace App\Http\Controllers;

use App\Http\Requests\TournamentRequest;
use App\Models\Tournament;
use App\Services\TournamentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TournamentController extends Controller
{
    public function __construct(protected TournamentService $service) {  }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Tournament::class);
        $data = $this->service->all(['game', 'creator', 'matches', 'participants'], [], 'created_at');
        return view('tournament.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Tournament::class);
        return view('tournament.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(TournamentRequest $request)
    {
        Gate::authorize('create', Tournament::class);
        $this->service->store($request->validated());
        return redirect()->route('tournament.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tournament = $this->service
        ->find($id, ['game', 'creator', 'matches', 'participants']);

        Gate::authorize('view', $tournament);

        if (isset($tournament) && !empty($tournament)) {
            return view('tournament.view', compact('tournament'));
        }

        return "<h1>TORNEIO NÃO ENCONTRADO</h1>";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tournament = $this->service
        ->find($id, ['game', 'creator', 'matches', 'participants']);

        Gate::authorize('update', $tournament);

        if (isset($tournament) && !empty($tournament)) {
            return view('tournament.edit', compact('tournament'));
        }

        return "<h1>TORNEIO NÃO ENCONTRADO</h1>";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id, TournamentRequest $request)
    {
        $tournament = $this->service
        ->find($id, ['game', 'creator', 'matches', 'participants']);

        Gate::authorize('update', $tournament);

        if (isset($tournament) && !empty($tournament)) {
            $this->service->update($request->validated(), $id);
            return redirect()->route('tournaments.index');
        }

        return "<h1>TORNEIO NÃO ENCONTRADO</h1>";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tournament = $this->service
        ->find($id);

        Gate::authorize('delete', $tournament);

        if (isset($tournament) && !empty($tournament)) {
            $this->service->remove($id);
            return redirect()->route('tournaments.index');
        }
        return "<h1>TORNEIO NÃO ENCONTRADO</h1>";
    }

        public function audit(string $id)
    {
        $tournament = $this->service->find($id);
        Gate::authorize('delete', $tournament);


        if (isset($tournament) && !empty($tournament    )) {
            $data = $this->service->audit($id);
            return view('tournament.audit', compact(['data']));
        }

        return "<h1>TORNEIO NÃO ENCONTRADO!</h1>";
    }
}
