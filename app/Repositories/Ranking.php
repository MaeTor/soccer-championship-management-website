<?php

namespace App\Repositories;

class Ranking
{
    function goalDifference(int $goalFor, int $goalAgainst): int
    {
        return $goalFor - $goalAgainst;
    }

    function points(int $matchWonCount, int $drawMatchCount): int
    {
        return $matchWonCount * 3 + $drawMatchCount;
    }

    function teamWinsMatch(int $teamId, array $match): bool
    {

        return ($teamId == $match['team0'] && $match['score0'] > $match['score1']) || ($teamId == $match['team1'] && $match['score1'] > $match['score0']);
        /* if ($teamId == $match['team0']) {
             return $match['score0'] > $match['score1'];
         }

         if ($teamId == $match['team1']) {
             return $match['score1'] > $match['score0'];
         }

         return false; // Return false if the team ID doesn't match either team */
    }

    function teamLosesMatch(int $teamId, array $match): bool
    {
        return ($teamId == $match['team0'] && $match['score0'] < $match['score1']) || ($teamId == $match['team1'] && $match['score1'] < $match['score0'] );
//        if ($teamId == $match['team0']) {
//            return $match['score0'] < $match['score1'];
//        }
//
//        if ($teamId == $match['team1']) {
//            return $match['score1'] < $match['score0'];
//        }
//
//        return false;
    }
        function teamDrawsMatch(int $teamId, array $match): bool
        {
            return false;
        }

}
