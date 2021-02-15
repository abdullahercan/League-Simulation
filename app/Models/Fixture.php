<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'played',
        'draw',
        'won',
        'lost',
        'goal_drawn',
        'points'
    ];


    public function won($goalDrawn)
    {
        $this->played += 1;
        $this->won += 1;
        $this->points += 3;
        $this->goal_drawn += $goalDrawn;
    }

    public function lost($goalDrawn)
    {
        $this->played += 1;
        $this->goal_drawn += -$goalDrawn;
        $this->lost += 1;
    }

    public function draw()
    {
        $this->played += 1;
        $this->draw += 1;
        $this->points += 1;
    }

}
