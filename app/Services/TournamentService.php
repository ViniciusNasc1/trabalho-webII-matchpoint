<?php

namespace App\Services;

use App\Models\Matchup;
use App\Repositories\BaseRepository;
use App\Repositories\TournamentRepository;
use Override;

class TournamentService extends BaseService
{
    public function __construct(protected TournamentRepository $tournamentRepository) { }

    #[Override]
    protected function getRepository(): BaseRepository
    {
        return $this->tournamentRepository;
    }

    public function startTournament(string $tournamentId): bool
    {
        $tournament = $this->find($tournamentId, ['participants']);

        if (!$tournament || $tournament->status !== 'open') {
            return false;
        }

        $participants = $tournament->participants;
        $totalParticipants = $participants->count();

        if ($totalParticipants < 2) {
            return false;
        }

        $shuffled = $participants->shuffle()->values();
        $totalRounds = (int) ceil(log($totalParticipants, 2));
        $roundLabels = $this->generateRoundLabels($totalRounds);

        $matchesInRound = 0;
        for ($i = 0; $i < $totalParticipants; $i += 2) {
            $participantA = $shuffled[$i];
            $participantB = $shuffled[$i + 1] ?? null;

            $match = Matchup::create([
                'tournament_id'      => $tournament->id,
                'round_number'       => 1,
                'round_label'        => $roundLabels[1],
                'participant_a_type' => $participantA->participant_type,
                'participant_a_id'   => $participantA->participant_id,
                'participant_b_type' => $participantB?->participant_type,
                'participant_b_id'   => $participantB?->participant_id,
                'status'             => 'pending',
            ]);

            if (!$participantB) {
                $match->update([
                    'winner_type' => $participantA->participant_type,
                    'winner_id'   => $participantA->participant_id,
                    'status'      => 'finished',
                ]);
            }

            $matchesInRound++;
        }

        for ($round = 2; $round <= $totalRounds; $round++) {
            $matchesInNextRound = (int) ceil($matchesInRound / 2);

            for ($i = 0; $i < $matchesInNextRound; $i++) {
                Matchup::create([
                    'tournament_id'       => $tournament->id,
                    'round_number'        => $round,
                    'round_label'         => $roundLabels[$round],
                    'participant_a_type'  => null,
                    'participant_a_id'    => null,
                    'participant_b_type'  => null,
                    'participant_b_id'    => null,
                    'status'              => 'pending',
                ]);
            }

            $matchesInRound = $matchesInNextRound;
        }

        $this->update(['status' => 'ongoing'], $tournamentId);

        return true;
    }

    private function generateRoundLabels(int $totalRounds): array
    {
        $labels = [];
        $names = ['Final', 'Semifinal', 'Quartas de final', 'Oitavas de final', '16-avos de final'];

        for ($round = $totalRounds; $round >= 1; $round--) {
            $position = $totalRounds - $round;
            $labels[$round] = $names[$position] ?? "Rodada {$round}";
        }

        return $labels;
    }
}