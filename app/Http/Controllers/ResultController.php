<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResultRequest;
use App\Models\Matchup;
use App\Models\Result;
use App\Services\ResultService;
use Illuminate\Support\Facades\Gate;

class ResultController extends Controller
{
    public function __construct(protected ResultService $service) {  }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Result::class);
        $data = $this->service->all(['match'], [], 'id');
        return view('result.index', compact('data'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Result::class);
        return view('result.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ResultRequest $request)
    {
        Gate::authorize('create', Result::class);
        $this->service->store($request->validated());
        return redirect()->route('matchups.show', $request->match_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->service->find($id, ['match']);

        Gate::authorize('view', $result);

        if (isset($result) && !empty($result)) {
            return view('result.show', compact('result'));
        }

        return "<h1>RESULTADO NÃO ENCONTRADO!</h1>";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $result = $this->service->find($id, ['match']);

        Gate::authorize('update', $result);

        if (isset($result) && !empty($result)) {
            return view('result.show', compact('result'));
        }

        return "<h1>RESULTADO NÃO ENCONTRADO!</h1>";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ResultRequest $request, string $id)
    {
        $result = $this->service->find($id, ['match']);

        Gate::authorize('update', $result);

        if (isset($result) && !empty($result)) {
            $return = $this->service->update($request->validated(), $id);
            if (!$return) {
                return back()->withErrors('Não foi possível atualizar o resultado.');
            }
            return redirect()->route('matchups.show', $return->match_id);
        }

        return "<h1>RESULTADO NÃO ENCONTRADO!</h1>";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->service->find($id);

        Gate::authorize('delete', $result);

        if (isset($result) && !empty($result)) {
            $this->service->remove($id);
            return redirect()->route('matchups.show', $result->match_id);
        }

        return "<h1>RESULTADO NÃO ENCONTRADO!</h1>";
    }

    public function audit(string $id)
    {
        $result = $this->service->find($id);
        Gate::authorize('delete', $result);


        if (isset($result) && !empty($result)) {
            $data = $this->service->audit($id);
            return view('result.audit', compact(['data']));
        }

        return "<h1>JOGO NÃO ENCONTRADO!</h1>";
    }
}
