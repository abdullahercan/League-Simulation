<?php

namespace App\Http\Controllers;

use App\Repositories\FixtureRepository;
use App\Repositories\MatchRepository;
use App\Services\Play\PlayMatch;

class PlayController extends Controller
{
    protected $fixtureRepository;
    protected $matchRepository;

    public function __construct(FixtureRepository $fixtureRepository, MatchRepository $matchRepository)
    {
        $this->fixtureRepository = $fixtureRepository;
        $this->matchRepository = $matchRepository;
    }

    public function playWeek(int $week_id): object
    {
        $matches = $this->matchRepository->getMatches()->where('week_id', $week_id);
        (new PlayMatch($this->fixtureRepository, $this->matchRepository))->bulk($matches);

        return response()->json([
            'status' => true,
            'data' => [
                'table' => $this->fixtureRepository->getTable(),
                'fixture' => $this->matchRepository->getFixture()
            ]
        ]);
    }

    public function playAll(): object
    {
        $matches = $this->matchRepository->getMatches();
        (new PlayMatch($this->fixtureRepository, $this->matchRepository))->bulk($matches);

        return response()->json([
            'status' => true,
            'data' => [
                'table' => $this->fixtureRepository->getTable(),
                'fixture' => $this->matchRepository->getFixture()
            ]
        ]);
    }
}
