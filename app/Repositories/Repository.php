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



}
