<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Models\Team;
use App\Services\TeamService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TeamController extends Controller
{
    public function __construct(protected TeamService $service) { }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Team::class);
        $data = $this->service->all(['members', 'owner', 'activeMembers', 'tournaments'], [], 'name');
        return view('teams.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Team::class);
        return view('teams.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeamRequest $request)
    {
        Gate::authorize('create', Team::class);
        $data = $request->validated();
        $data['owner_id'] = $request->user()->id;
        $return = $this->service->store($data);

        if (!$return) {
            return back()->withErrors('Não foi possível criar o time.');
        }

        return redirect()->route('teams.show', $return->id)
                         ->with('success', 'Time criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $team = $this->service->find($id, ['members', 'owner', 'activeMembers', 'tournaments']);
        Gate::authorize('view', $team);

        if (isset($team) && !empty($team)) {
            return view('teams.show', compact('team'));
        }

        return "<h1>TIME NÃO ENCONTRADO</h1>";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $team = $this->service->find($id, ['members', 'owner']);
        Gate::authorize('update', $team);

        if (isset($team) && !empty($team)) {
            return view('teams.edit', compact('team'));
        }

        return "<h1>TIME NÃO ENCONTRADO</h1>";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TeamRequest $request, string $id)
    {
        $team = $this->service->find($id, ['members', 'owner']);
        Gate::authorize('update', $team);

        if (isset($team) && !empty($team)) {
            $return = $this->service->update($request->validated(), $id);

            if (!$return) {
                return back()->withErrors('Não foi possível atualizar as informações do time!');
            }

            return redirect()->route('teams.show', $return->id)
                             ->with('success', 'Time atualizado com sucesso!');
        }

        return "<h1>TIME NÃO ENCONTRADO!</h1>";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $team = $this->service->find($id);
        Gate::authorize('delete', $team);

        if (isset($team) && !empty($team)) {
            $this->service->remove($id);
            return redirect()->route('teams.index')
                             ->with('success', 'Time removido com sucesso!');
        }

        return "<h1>TIME NÃO ENCONTRADO!</h1>";
    }

    public function audit(string $id)
    {
        $team = $this->service->find($id);
        Gate::authorize('delete', $team);

        if (isset($team) && !empty($team)) {
            $data = $this->service->audit($id);
            return view('teams.audit', compact(['data']));
        }

        return "<h1>TIME NÃO ENCONTRADO!</h1>";
    }
}