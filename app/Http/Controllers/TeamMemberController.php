<?php
namespace App\Http\Controllers;
use App\Http\Requests\TeamMemberRequest;
use App\Models\TeamMember;
use App\Services\TeamMemberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
class TeamMemberController extends Controller
{
    public function __construct(protected TeamMemberService $service) { }

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
        Gate::authorize('create', TeamMember::class);
        $users = \App\Models\User::where('role', 'player')->get();
        return view('team-members.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeamMemberRequest $request)
    {
        Gate::authorize('create', TeamMember::class);
        $return = $this->service->store($request->validated());
        if (!$return) {
            return back()->withErrors('Não foi possível adicionar o membro.');
        }
        return redirect()->route('teams.show', $return->team_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $member = $this->service->find($id, ['team', 'user']);
        if (!isset($member)) {
            return "<h1>MEMBRO NÃO ENCONTRADO!</h1>";
        }
        Gate::authorize('view', $member);
        return view('teamMember.view', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $member = $this->service->find($id, ['team', 'user']);
        if (!isset($member)) {
            return "<h1>MEMBRO NÃO ENCONTRADO!</h1>";
        }
        Gate::authorize('update', $member);
        return view('teamMember.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TeamMemberRequest $request, string $id)
    {
        $member = $this->service->find($id);
        if (!isset($member)) {
            return "<h1>MEMBRO NÃO ENCONTRADO!</h1>";
        }
        Gate::authorize('update', $member);
        $this->service->update($request->validated(), $id);
        return redirect()->route('teams.show', $member->team_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $member = $this->service->find($id);
        if (!isset($member)) {
            return "<h1>MEMBRO NÃO ENCONTRADO!</h1>";
        }
        Gate::authorize('delete', $member);
        $this->service->remove($id);
        return redirect()->route('team.show', $member->team_id);
    }
}
