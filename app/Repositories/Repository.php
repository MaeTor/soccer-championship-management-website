<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class Repository
{
    function createDatabase(): void
    {
        DB::unprepared(file_get_contents('database/build.sql'));
    }

    function insertTeam(array $team): int
    {
        if (array_key_exists('id', $team)) {
            DB::table('teams')->insert($team);
            return $team['id'];
        }
        return DB::table('teams')->insertGetId($team);
    }


    function insertMatch(array $match): int
    {
        if (array_key_exists('id', $match)) {
            DB::table('matches')->insert($match);
            return $match['id'];
        }
        return DB::table('matches')->insertGetId($match);
    }

    function teams(): array
    {
        return DB::table('teams')->orderBy('id')->get()->map(function ($team) {
            return (array) $team;
        })->toArray();
    }


    function matches(): array
    {
        return DB::table('matches')->orderBy('id')->get()->map(function ($match) {
            return (array)$match;
        })->toArray();
    }



}
