<?php

namespace App\Repositories;

use App\Models\Fixture;
use App\Models\Team;

class FixtureRepository
{
    protected $team;
    protected $fixture;

    public function __construct(Team $team, Fixture $fixture)
    {
        $this->team = $team;
        $this->fixture = $fixture;
    }

    public function createFixture(): bool
    {
        if ($this->fixture->count() > 0)
            return false;

        foreach ($this->team->get() as $team) {
            $this->fixture->create([
                'team_id' => $team->id
            ]);
        }

        return true;
    }

    public function getTable()
    {
        return $this->team->leftJoin('fixtures', 'teams.id', 'fixtures.team_id')
            ->orderBy('points', 'DESC')
            ->get();
    }

}
