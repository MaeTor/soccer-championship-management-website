<?php

namespace Tests\Unit;
use App\Repositories\Ranking;
use Tests\TestCase;
class RankingTest extends TestCase
{
    function testGoalDifference():void
    {
        $ranking = new Ranking();
        $this->assertEquals($ranking->goalDifference(2, 3), -1);
        $this->assertEquals($ranking->goalDifference(0, 0), 0);
        $this->assertEquals($ranking->goalDifference(4, 1), 3);

    }

}
