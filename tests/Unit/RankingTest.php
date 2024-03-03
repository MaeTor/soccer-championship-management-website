<?php

namespace Tests\Unit;
use App\Repositories\Ranking;
use App\Repositories\Data;
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
        $this->data = new Data();

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
    function testTeamDrawsMatch(): void
    {
        $this->assertNotTrue($this->ranking->teamDrawsMatch(1, $this->match0));
        $this->assertNotTrue($this->ranking->teamDrawsMatch(3, $this->match0));
        $this->assertTrue($this->ranking->teamDrawsMatch(4, $this->match1));
        $this->assertTrue($this->ranking->teamDrawsMatch(2, $this->match1));
        $this->assertNotTrue($this->ranking->teamDrawsMatch(8, $this->match1));
        $this->assertNotTrue($this->ranking->teamDrawsMatch(3, $this->match2));
        $this->assertNotTrue($this->ranking->teamDrawsMatch(2, $this->match2));
        $this->assertNotTrue($this->ranking->teamDrawsMatch(4, $this->match0));
    }

    function testGoalForCountDuringAMatch(): void
    {
        $this->assertEquals($this->ranking->goalForCountDuringAMatch(1, $this->match0), 3);
        $this->assertEquals($this->ranking->goalForCountDuringAMatch(3, $this->match0), 5);
        $this->assertEquals($this->ranking->goalForCountDuringAMatch(4, $this->match0), 0);
    }

    function testGoalAgainstCountDuringAMatch(): void
    {
        $this->assertEquals($this->ranking->goalAgainstCountDuringAMatch(1, $this->match0),
            5);
        $this->assertEquals($this->ranking->goalAgainstCountDuringAMatch(3, $this->match0),
            3);
        $this->assertEquals($this->ranking->goalAgainstCountDuringAMatch(4, $this->match0),
            0);
    }

    function testGoalForCount(): void
    {
        foreach ($this->data->expectedUnsortedRanking() as $row) {
            $this->assertEquals($this->ranking->goalForCount($row['team_id'], $this->data->matches()), $row['goal_for_count']);
        }

    }

    function testGoalAgainstCount(): void
    {
        foreach ($this->data->expectedUnsortedRanking() as $row) {
            $this->assertEquals($this->ranking->goalAgainstCount($row['team_id'], $this->data->matches()), $row['goal_against_count']);
        }
    }

    function testMatchWonCount(): void
    {
        foreach ($this->data->expectedUnsortedRanking() as $row) {
            $this->assertEquals($this->ranking->matchWonCount($row['team_id'], $this->data->matches()), $row['match_won_count']);
        }
    }

    function testMatchLostCount(): void
    {
        foreach ($this->data->expectedUnsortedRanking() as $row) {
            $this->assertEquals($this->ranking->matchLostCount($row['team_id'], $this->data->matches()), $row['match_lost_count']);
        }
    }

    function testMatchDrawCount(): void
    {
        foreach ($this->data->expectedUnsortedRanking() as $row) {
            $this->assertEquals($this->ranking->drawMatchCount($row['team_id'], $this->data->matches()), $row['draw_count']);
        }
    }

    function testRankingRow(): void
    {
        foreach ($this->data->expectedUnsortedRanking() as $row) {
            $this->assertEquals($this->ranking->rankingRow($row['team_id'], $this->data->matches()), $row);
        }
    }



}
