<?php

namespace App\Services\Play;

use App\Repositories\FixtureRepository;
use App\Repositories\MatchRepository;

class PlayMatch
{

    protected $fixtureRepository;
    protected $matchRepository;

    public function __construct(FixtureRepository $fixtureRepository, MatchRepository $matchRepository)
    {
        $this->fixtureRepository = $fixtureRepository;
        $this->matchRepository = $matchRepository;
    }

    public function bulk($matches)
    {
        foreach ($matches as $match) {
            $this->scoreSimulate($match);
        }
    }

    public function scoreSimulate($match)
    {

        $home_team = $this->matchRepository->getFixtures()->where('team_id', $match->home_team)->first();
        $away_team = $this->matchRepository->getFixtures()->where('team_id', $match->away_team)->first();

        $homeScore = $this->score(true, $home_team->id);
        $awayScore = $this->score(false, $away_team->id);

        $this->matchRepository->updateScore($homeScore, $awayScore, $home_team, $away_team);
        return $this->matchRepository->resultSaver($match, $homeScore, $awayScore);

    }

    public function score(bool $is_home, int $teamRank)
    {
        return $is_home ? rand(0, 4) : rand(0, 4 - $teamRank);
    }
}
