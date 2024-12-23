<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class Repository
 * Handles database operations for teams, matches, and rankings.
 * Manages datas of the web app
 */
class Repository
{
    /**
     * Creates the database using an SQL script.
     *
     * @return void
     */
    function createDatabase(): void
    {
        DB::unprepared(file_get_contents('database/build.sql'));
    }

    /**
     * Inserts a team into the database. If an 'id' exists, it is used.
     *
     * @param array $team The team data.
     * @return int The ID of the inserted team.
     * @throws Exception if the team cannot be inserted.
     */
    function insertTeam(array $team): int
    {
        if (array_key_exists('id', $team)) {
            DB::table('teams')->insert($team);
            return $team['id'];
        }
        return DB::table('teams')->insertGetId($team);
    }

    /**
     * Inserts a match into the database. If an 'id' exists, it is used.
     *
     * @param array $match The match data.
     * @return int The ID of the inserted match.
     * @throws Exception if the match cannot be inserted.
     */
    function insertMatch(array $match): int
    {
        if (array_key_exists('id', $match)) {
            DB::table('matches')->insert($match);
            return $match['id'];
        }
        return DB::table('matches')->insertGetId($match);
    }
    /**
     * Retrieves all teams from the database.
     *
     * @return array List of teams.
     */
    function teams(): array
    {
        return DB::table('teams')->orderBy('id')->get()->map(function ($team) {
            return (array) $team;
        })->toArray();
    }

    /**
     * Retrieves all matches from the database.
     *
     * @return array List of matches.
     */
    function matches(): array
    {
        return DB::table('matches')->orderBy('id')->get()->map(function ($match) {
            return (array)$match;
        })->toArray();
    }

    /**
     * Fills the database with initial data for teams and matches.
     *
     * @return void
     */
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

    /**
     * Retrieves a specific team by its ID.
     *
     * @param int $teamId The ID of the team.
     * @return array The team data.
     * @throws Exception if the team is not found.
     */
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

    /**
     * Retrieves a specific match by its ID.
     *
     * @param int $matchId The ID of the match.
     * @return array The match data.
     * @throws Exception if the match is not found.
     */
    function match($matchId): array
    {
        $match = DB::table('matches')->where('id', $matchId)->get()->toArray();
        if (empty($match[0])) {
            throw new Exception('Match inconnu');
        }
        return (array)$match[0];
    }

    /**
     * Updates the ranking table by recalculating rankings based on teams and matches.
     *
     * @return void
     */
    function updateRanking(): void{
        DB::table('ranking')->delete();
        $teams = $this->teams();
        $matches = $this->matches();
        $ranking = new Ranking();
        $r = $ranking->sortedRanking($teams, $matches);
        // Insérer le classement trié dans la table ranking
        DB::table('ranking')->insert($r);
    }

    /**
     * Retrieves the sorted ranking with team names.
     *
     * @return array The sorted ranking.
     */
    function sortedRanking(): array
    {
        return DB::table('ranking')
        ->join('teams', 'ranking.team_id', '=', 'teams.id')
            ->orderby('position')
            ->get(['ranking.*', 'teams.name as name'])
            ->toArray();
    }

    /**
     * Retrieves all matches for a specific team by its ID.
     *
     * @param int $teamId The ID of the team.
     * @return array The list of matches the team is involved in.
     */
    function teamMatches($teamId)
    {
        return DB::table('matches')
            ->join('teams as t0', 'matches.team0', '=', 't0.id')
            ->join('teams as t1', 'matches.team1', '=', 't1.id')
            ->where('team0', $teamId)
            ->orWhere('team1', $teamId)
            ->orderby('date')
            ->get(['matches.*', 't0.name as name0', 't1.name as name1'])
            ->map(function ($item) {
                return (array) $item;
            })
            ->toArray();
    }

    function rankingRow(int $teamId)
    {
        $rowteam = DB::table('ranking')
            ->join('teams', 'ranking.team_id', '=', 'teams.id')
            ->where('ranking.team_id', $teamId)
            ->first(['ranking.*', 'teams.name as name']); // Utilisation de 'first()' pour un seul enregistrement

        if (!$rowteam) {
            throw new Exception('Équipe inconnue');
        }

        return (array) $rowteam;  // Retourne un tableau associatif unique
    }



}
