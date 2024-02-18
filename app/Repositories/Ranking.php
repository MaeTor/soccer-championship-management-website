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
        return $matchWonCount*3+ $drawMatchCount;
    }

    function teamWinsMatch(int $teamId, array $match): bool
    {
        return false;
    }
    function teamLosesMatch(int $teamId, array $match): bool
    {
        return false;
    }
    function teamDrawsMatch(int $teamId, array $match): bool
    {
        return false;
    }

}
