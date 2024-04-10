<?php

namespace App\Repositories;

use Exception;
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

    function fillDatabase(): void
    {
        $data = new Data();
        foreach ($data->teams() as $team) {
            $this->insertTeam($team);
        }
        foreach ($data->matches() as $match) {
            $this->insertMatch($match);
        }
    }

    function team($teamId): array
    {
            $team =  DB::table('teams')->where('id', $teamId)->get()->toArray();
            if (empty($team[0])) {
                throw new Exception('Équipe inconnue');
            }
            return (array)$team[0];

//        $team = DB::table('teams')
//            ->where('id', $teamId)
//            ->first();
//
//        return (array) $team;

    }

    function match($matchId): array
    {
        $match = DB::table('matches')->where('id', $matchId)->get()->toArray();
        if (empty($match[0])) {
            throw new Exception('Match inconnu');
        }
        return (array)$match[0];
    }

    function updateRanking(): void{
        DB::table('ranking')->delete();
        $teams = $this->teams();
        $matches = $this->matches();
        $ranking = new Ranking();
        $r = $ranking->sortedRanking($teams, $matches);








    }

    }
