<?php

namespace App\Http\Controllers;

use App\Repositories\FixtureRepository;
use App\Repositories\MatchRepository;
use App\Services\Play\PlayMatch;

class MainController extends Controller
{
    protected $fixtureRepository;
    protected $matchRepository;

    public function __construct(FixtureRepository $fixtureRepository, MatchRepository $matchRepository)
    {
        $this->fixtureRepository = $fixtureRepository;
        $this->matchRepository = $matchRepository;
    }


    public function lista()
    {

        $this->fixtureRepository->createFixture();

        die;
        $matches = $this->matchRepository->getMatches()->where('week_id', 1);
        (new PlayMatch($this->fixtureRepository, $this->matchRepository))->bulk($matches);
    }

    public function index(): object
    {
        return response()->json([
            'status' => true,
            'data' => [
                'table' => $this->fixtureRepository->getTable(),
                'fixture' => $this->matchRepository->getFixture()
            ]
        ]);
    }
}
