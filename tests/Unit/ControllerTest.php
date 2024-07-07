<?php

namespace Tests\Unit;
use App\Repositories\Data;
use App\Repositories\Repository;
use PHPUnit\Framework\TestCase;
class ControllerTest extends TestCase
{
    public function testShowRanking()
    {
        $this->mock(Repository::class, function ($mock) {
            $mock->shouldReceive('sortedRanking')->once()->andReturn([
                [
                    'rank' => 2,
                    'name' => 'Lyon',
                    'team_id' => 3,
                    'match_played_count' => 38,
                    'won_match_count' => 19,
                    'lost_match_count' => 13,
                    'draw_match_count' => 6,
                    'goal_for_count' => 111,
                    'goal_against_count' => 97,
                    'goal_difference' => 14,
                    'points' => 63
                ]
            ]);
        });
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeTextInOrder(['N°', 'Équipe', 'MJ', 'G', 'N', 'P', 'BP', 'BC', 'DB', 'PTS']);
        $response->assertSeeTextInOrder([2, 'Lyon', 38, 19, 6, 13, 111, 97, 14, 63]);
    }

    public function testShowTeam()
    {
        $this->mock(Repository::class, function ($mock) {
            $data = new Data();
            $mock->shouldReceive('rankingRow')->with(4)->once()->andReturn([
                'rank' => 2,
                'name' => 'Lyon',
                'team_id' => 3,
                'match_played_count' => 38,
                'won_match_count' => 19,
                'lost_match_count' => 13,
                'draw_match_count' => 6,
                'goal_for_count' => 111,
                'goal_against_count' => 97,
                'goal_difference' => 14,
                'points' => 63
            ]);


        }
}

