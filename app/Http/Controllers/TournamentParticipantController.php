<?php
namespace App\Http\Controllers;
use App\Http\Requests\TournamentParticipantRequest;
use App\Models\TournamentParticipant;
use App\Services\TournamentParticipantService;
use Illuminate\Support\Facades\Gate;
class TournamentParticipantController extends Controller
{
    public function __construct(protected TournamentParticipantService $service) { }

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
        Gate::authorize('create', TournamentParticipant::class);
        return view('tournamentParticipant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TournamentParticipantRequest $request)
    {
        Gate::authorize('create', TournamentParticipant::class);
        $participant = $this->service->store($request->validated());
        return redirect()->route('tournament.show', $participant->tournament_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $participant = $this->service->find($id, [
            'tournament',
            'participant',
        ]);
        if (!isset($participant)) {
            return "<h1>PARTICIPANTE NÃO ENCONTRADO!</h1>";
        }
        Gate::authorize('view', $participant);
        return view('tournamentParticipant.view', compact('participant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $participant = $this->service->find($id, [
            'tournament',
            'participant',
        ]);
        if (!isset($participant)) {
            return "<h1>PARTICIPANTE NÃO ENCONTRADO!</h1>";
        }
        Gate::authorize('update', $participant);
        return view('tournamentParticipant.edit', compact('participant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TournamentParticipantRequest $request, string $id)
    {
        $participant = $this->service->find($id);
        if (!isset($participant)) {
            return "<h1>PARTICIPANTE NÃO ENCONTRADO!</h1>";
        }
        Gate::authorize('update', $participant);
        $this->service->update($request->validated(), $id);
        return redirect()->route('tournament.show', $participant->tournament_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $participant = $this->service->find($id);
        if (!isset($participant)) {
            return "<h1>PARTICIPANTE NÃO ENCONTRADO!</h1>";
        }
        Gate::authorize('delete', $participant);
        $this->service->remove($id);
        return redirect()->route('tournament.show', $participant->tournament_id);
    }
}
