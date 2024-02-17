<?php

namespace Tests\Unit;
use App\Repositories\Ranking;
use Tests\TestCase;
class RankingTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->ranking = new Ranking();

    }
    function testGoalDifference():void

    {
        $this->assertEquals($this->ranking->goalDifference(2, 3), -1);
        $this->assertEquals($this->ranking->goalDifference(0, 0), 0);
        $this->assertEquals($this->ranking->goalDifference(4, 1), 3);
    }

}
