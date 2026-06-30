<?php

namespace App\Services;

use App\Models\Matchup;
use App\Repositories\BaseRepository;
use App\Repositories\ResultRepository;
use Override;

class ResultService extends BaseService
{
    public function __construct(protected ResultRepository $resultRepository) { }

    #[Override]
    protected function getRepository(): BaseRepository
    {
        return $this->resultRepository;
    }

    #[Override]
    public function store(array $data)
    {
        $result = $this->getRepository()->store($data);

        $match = Matchup::find($data['match_id']);

        if (!$match) {
            return $result;
        }

        $winnerType = $data['score_a'] > $data['score_b']
            ? $match->participant_a_type
            : $match->participant_b_type;

        $winnerId = $data['score_a'] > $data['score_b']
            ? $match->participant_a_id
            : $match->participant_b_id;

        $match->update([
            'winner_type' => $winnerType,
            'winner_id'   => $winnerId,
            'status'      => 'finished',
        ]);

        $this->advanceWinner($match);

        return $result;
    }

    private function advanceWinner(Matchup $match): void
    {
        $nextRound = $match->round_number + 1;

        $nextMatch = Matchup::where('tournament_id', $match->tournament_id)
                             ->where('round_number', $nextRound)
                             ->where(function ($query) {
                                 $query->whereNull('participant_a_id')
                                       ->orWhereNull('participant_b_id');
                             })
                             ->first();

        if (!$nextMatch) {
            return;
        }

        if (!$nextMatch->participant_a_id) {
            $nextMatch->update([
                'participant_a_type' => $match->winner_type,
                'participant_a_id'   => $match->winner_id,
            ]);
        } else {
            $nextMatch->update([
                'participant_b_type' => $match->winner_type,
                'participant_b_id'   => $match->winner_id,
            ]);
        }
    }
}