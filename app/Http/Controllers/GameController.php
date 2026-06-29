<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameRequest;
use App\Models\Game;
use App\Services\GameService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GameController extends Controller
{

    public function __construct(protected GameService $service) {  }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Game::class);
        $data = $this->service->all(['tournaments'], [], 'name');
        return view('games.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Game::class);
        return view('games.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GameRequest $request)
    {
        Gate::authorize('create', Game::class);
        $this->service->store($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Gate::authorize('view');

        $game = $this->service->find($id, ['tournament']);

        if (isset($game) && !empty($game)) {
            return view('games.show');
        }

        return "<h1>JOGO NÃO ENCONTRADO!</h1>";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize('update');

        $game = $this->service->find($id);
        if (isset($game) && !empty($game)) {
            return view('games.edit');
        }

        return "<h1>JOGO NÃO ENCONTRADO!</h1>";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GameRequest $request, string $id)
    {
        Gate::authorize('update');

        $game = $this->service->find($id);

        if (isset($game) && !empty($game)) {
            $this->service->update($request->validated(), $id);
            return redirect()->route('games.index');
        }

        return "<h1>JOGO NÃO ENCONTRADO!</h1>";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('delete');

        $game = $this->service->find($id);

        if(isset($game) && !empty($game)) {
            $this->service->remove($id);
            return redirect()->route('game.index');
        }

        return "<h1>JOGO NÃO ENCONTRADO!</h1>";
    }

    public function audit(string $id)
    {

        Gate::authorize('delete');
        $game = $this->service->find($id);

        if (isset($game) && !empty($game)) {
            $data = $this->service->audit($id);
            return view('game.audit', compact(['data']));
        }

        return "<h1>JOGO NÃO ENCONTRADO!</h1>";
    }
}
