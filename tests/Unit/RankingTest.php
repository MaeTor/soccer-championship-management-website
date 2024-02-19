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
        $this->match0 = ['id' => 123, 'team0' => 1, 'team1' => 3, 'score0' => 3, 'score1' => 5,
            'date' => '2048-01-01 00:00:00'];
        $this->match1 = ['id' => 231, 'team0' => 4, 'team1' => 2, 'score0' => 2, 'score1' => 2,
            'date' => '2048-01-01 00:00:00'];
        $this->match2 = ['id' => 222, 'team0' => 3, 'team1' => 2, 'score0' => 1, 'score1' => 3,
            'date' => '2048-01-01 00:00:00'];
    }
    function testGoalDifference():void

    {
        $this->assertEquals($this->ranking->goalDifference(2, 3), -1);
        $this->assertEquals($this->ranking->goalDifference(0, 0), 0);
        $this->assertEquals($this->ranking->goalDifference(4, 1), 3);
    }

    function testPoints(): void
    {
        $this->assertEquals($this->ranking->points(1, 0), 3);
        $this->assertEquals($this->ranking->points(0, 1), 1);
        $this->assertEquals($this->ranking->points(0, 0), 0);
        $this->assertEquals($this->ranking->points(1, 2), 5);
    }

    function testTeamWinsMatch(): void
    {
        $this->assertNotTrue($this->ranking->teamWinsMatch(1, $this->match0));
        $this->assertTrue($this->ranking->teamWinsMatch(3, $this->match0));
        $this->assertNotTrue($this->ranking->teamWinsMatch(4, $this->match1));
        $this->assertNotTrue($this->ranking->teamWinsMatch(2, $this->match1));
        $this->assertNotTrue($this->ranking->teamWinsMatch(3, $this->match2));
        $this->assertTrue($this->ranking->teamWinsMatch(2, $this->match2));
        $this->assertNotTrue($this->ranking->teamWinsMatch(4, $this->match0));
    }
    function testTeamLosesMatch(): void
    {
        $this->assertTrue($this->ranking->teamLosesMatch(1, $this->match0));
        $this->assertNotTrue($this->ranking->teamLosesMatch(3, $this->match0));
        $this->assertNotTrue($this->ranking->teamLosesMatch(4, $this->match1));
        $this->assertNotTrue($this->ranking->teamLosesMatch(2, $this->match1));
        $this->assertTrue($this->ranking->teamLosesMatch(3, $this->match2));
        $this->assertNotTrue($this->ranking->teamLosesMatch(2, $this->match2));
        $this->assertNotTrue($this->ranking->teamLosesMatch(4, $this->match0));
    }



}
