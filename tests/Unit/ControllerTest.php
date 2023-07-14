<?php

namespace Tests\Unit;
use App\Repositories\Data;
use App\Repositories\Repository;
use Mockery;
use Tests\TestCase;
class ControllerTest extends TestCase
{
    public function testShowRanking()
    {
        // Créer un mock de la classe Repository
        $repositoryMock = Mockery::mock(Repository::class);
        $repositoryMock->shouldReceive('sortedRanking')->once()->andReturn([
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
        // Injection du mock dans le conteneur d'application de Laravel
        $this->instance(Repository::class, $repositoryMock);
        // La méthode get de TestCase permet de simuler le traitement d'une requête dont
        //la méthode HTTP est GET .
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeTextInOrder(['N°', 'Équipe', 'MJ', 'G', 'N', 'P', 'BP', 'BC', 'DB', 'PTS']);
        $response->assertSeeTextInOrder([2, 'Lyon', 38, 19, 6, 13, 111, 97, 14, 63]);
    }

    public function testShowTeam()
    {
        $this->mock(Repository::class, function ($mock) {
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

            $mock->shouldReceive('teamMatches')->with(4)->once()->andReturn([
                [
                    'id' => 7,
                    'team0' => 3,
                    'team1' => 18,
                    'score0' => 3,
                    'score1' => 5,
                    'date' => '2048-08-03 00:00:00',
                    'name0' => 'Lyon',
                    'name1' => 'Angers'
                ]
            ]);

        }
    }
        /*$this->mock(Repository::class, function ($mock) {
            $data = new Data();


        });
            $response = $this->get('/teams/4');
            $response->assertStatus(200);
            $response->assertSeeTextInOrder(['N°', 'Équipe', 'MJ', 'G', 'N', 'P', 'BP', 'BC', 'DB', 'PTS']);
            $response->assertSeeTextInOrder([2, 'Lyon', 38, 19, 6, 13, 111, 97, 14, 63]);
            $response->assertSeeTextInOrder(['2048-08-03 00:00:00', 'Lyon', 3, 5, 'Angers']);
    }*/
}


