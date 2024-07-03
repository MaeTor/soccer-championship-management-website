<?php

namespace Tests\Unit;
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


    }
    }

