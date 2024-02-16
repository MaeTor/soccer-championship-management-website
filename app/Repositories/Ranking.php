<?php

namespace App\Repositories;

class Ranking
{
    function goalDifference(int $goalFor, int $goalAgainst): int
    {
        return $goalFor - $goalAgainst;
    }
}
