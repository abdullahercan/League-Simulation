<?php

namespace App\Repositories;

use App\Models\Fixture;
use App\Models\Match;
use App\Models\Team;
use App\Models\Week;

class MatchRepository
{
    protected $team;
    protected $match;
    protected $week;
    protected $fixture;

    public function __construct(Team $team, Match $match, Week $week, Fixture $fixture)
    {
        $this->team = $team;
        $this->match = $match;
        $this->week = $week;
        $this->fixture = $fixture;
    }

    public function getTeams()
    {
        return $this->team->get();
    }

    public function getMatches()
    {
        return $this->match->get();
    }

    public function getFixtures()
    {
        return $this->fixture->get();
    }

    public function getWeeks()
    {
        return $this->week->get();
    }

    public function createFixture(array $items): bool
    {
        if (!is_array($items) && count($items) == 0)
            return false;

        foreach ($items as $item) {
            $this->match->create([
                'week_id' => $item['week'],
                'home_team' => $item['home']['id'],
                'away_team' => $item['away']['id']
            ]);
        }

        return true;
    }

    public function getFixture(): array
    {
        $list = [];
        foreach ($this->week->get() as $week) {
            $matches = $this->match->select(
                'matches.status',
                'matches.home_team_goal as homeGoal',
                'matches.away_team_goal as awayGoal',
                'home.name as homeTeam',
                'home.logo as homeLogo',
                'away.name as awayTeam',
                'away.logo as awayLogo'
            )
                ->where('matches.week_id', $week->id)
                ->join('teams as home', 'home.id', 'matches.home_team')
                ->join('teams as away', 'away.id', 'matches.away_team')
                ->orderBy('matches.week_id', 'ASC')
                ->get();
            $list[] = [
                'id' => $week->id,
                'title' => $week->name,
                'matches' => $matches
            ];
        }

        return $list;
    }

    public function updateScore($homeScore, $awayScore, $home, $away)
    {
        $goalDrawn = abs($awayScore - $homeScore);

        if ($homeScore > $awayScore) {
            $home->won($goalDrawn);
            $away->lost($goalDrawn);

        } elseif ($awayScore > $homeScore) {
            $away->won($goalDrawn);
            $home->lost($goalDrawn);
        } else {
            $home->draw();
            $away->draw();
        }

        $home->save();
        $away->save();
    }

    public function resultSaver($match, $homeScore, $awayScore)
    {
        $match->home_team_goal = $homeScore;
        $match->away_team_goal = $awayScore;
        $match->status = 1;
        return $match->save();
    }
}
