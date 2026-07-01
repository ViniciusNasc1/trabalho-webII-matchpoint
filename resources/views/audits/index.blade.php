@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-shield-lock-fill me-2" style="color:#a78bfa;"></i>Auditoria
        </h4>
    </div>

    @if ($audits->isEmpty())
        <div class="card-mp text-center py-5">
            <i class="bi bi-clipboard-data" style="font-size:3rem; color:#a78bfa;"></i>
            <p class="mt-3 info-text">Nenhum registro de auditoria encontrado.</p>
        </div>
    @else
        <div class="d-flex flex-column gap-3">
            @foreach ($audits as $audit)
                <div class="card-mp">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <span class="fw-bold">{{ class_basename($audit->auditable_type) }}</span>
                            <span class="status-{{ strtolower($audit->event) }} ms-2">
                                {{ match($audit->event) {
                                    'created' => 'Criado',
                                    'updated' => 'Atualizado',
                                    'deleted' => 'Deletado',
                                    'restored' => 'Restaurado',
                                    default => $audit->event
                                } }}
                            </span>
                        </div>
                        <small class="info-text">
                            {{ $audit->created_at->format('d/m/Y H:i:s') }}
                        </small>
                    </div>

                    <p class="info-text mb-2">
                        <i class="bi bi-person me-1"></i>
                        {{ $audit->user?->name ?? 'Sistema' }}
                    </p>

                    @if (!empty($audit->old_values) || !empty($audit->new_values))
                        <div class="row g-2 mt-1">
                            @if (!empty($audit->old_values))
                                <div class="col-md-6">
                                    <p class="info-text mb-1"><i class="bi bi-arrow-left me-1"></i>Antes:</p>
                                    <div class="participant-row">
                                        @foreach ($audit->old_values as $key => $value)
                                            <small class="d-block info-text">
                                                <span class="fw-bold">{{ $key }}:</span> {{ $value }}
                                            </small>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if (!empty($audit->new_values))
                                <div class="col-md-6">
                                    <p class="info-text mb-1"><i class="bi bi-arrow-right me-1"></i>Depois:</p>
                                    <div class="participant-row">
                                        @foreach ($audit->new_values as $key => $value)
                                            <small class="d-block info-text">
                                                <span class="fw-bold">{{ $key }}:</span> {{ $value }}
                                            </small>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $audits->links() }}
        </div>
    @endif

@endsection