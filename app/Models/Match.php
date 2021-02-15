<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    use HasFactory;

    protected $fillable = [
        'week_id',
        'home_team',
        'away_team',
        'home_team_goal',
        'away_team_goal',
        'status'
    ];
}
