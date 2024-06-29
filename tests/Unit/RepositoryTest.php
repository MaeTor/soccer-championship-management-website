<?php

use App\Repositories\Data;
use App\Repositories\Ranking;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->ranking = new Ranking();
        $this->data = new Data();
        $this->repository = new Repository();
        $this->repository->createDatabase();
    }

    function testTeamsAndInsertTeam(): void
    {
        $teams = $this->data->teams();
        $this->assertEquals($this->repository->insertTeam($teams[4]), 5);
        $this->assertEquals($this->repository->insertTeam($teams[2]), 3);
        $this->assertEquals($this->repository->insertTeam($teams[7]), 8);
        $this->assertEquals($this->repository->teams(), [$teams[2], $teams[4], $teams[7]]);
    }

    function testMatchesAndInsertMatch(): void
    {
        $teams = $this->data->teams();
        $matches = $this->data->matches();
        $this->assertEquals($this->repository->insertTeam($teams[6]), 7);
        $this->assertEquals($this->repository->insertTeam($teams[18]), 19);
        $this->assertEquals($this->repository->insertTeam($teams[5]), 6);
        $this->assertEquals($this->repository->insertTeam($teams[10]), 11);
        $this->assertEquals($this->repository->insertMatch($matches[5]), 6);
        $this->assertEquals($this->repository->insertMatch($matches[0]), 1);
        $this->assertEquals($this->repository->matches(), [$matches[0], $matches[5]]);
    }

    function testFillDatabase(): void
    {
        $this->repository->fillDatabase();
        $this->assertEquals($this->repository->teams(), $this->data->teams());
        $this->assertEquals($this->repository->matches(), $this->data->matches());
    }

    function testTeam(): void
    {
        $this->repository->fillDatabase();
        foreach ($this->data->teams() as $team) {
            $this->assertEquals($this->repository->team($team['id']), $team);
        }
    }

    function testTeamThrowsExceptionIfTeamDoesNotExist(): void
    {
        $this->repository->fillDatabase();
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Équipe inconnue');
        $this->repository->team(10000);
    }

    function testMatchThrowsExceptionIfMatchDoesNotExist(): void
    {
        //fill with teams and matches
        $this->repository->fillDatabase();
        // Vérifier que l'exception est levée pour un match inexistant
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Match inconnu');
        // Appeler la méthode avec un identifiant inexistant
        $this->repository->match(10000);
    }

    function testMatchIfExists(): void
    {
        // Remplir la base de données avec les équipes et les matchs
        $this->repository->fillDatabase();
        // Récupérer le premier match
        $match = $this->data->matches()[0];
        // Vérifier que la méthode match retourne le bon match
        $this->assertEquals($this->repository->match($match['id']), $match);
    }

    function testUpdateRanking(): void
    {
        $this->repository->updateRanking();
        $this->repository->fillDatabase();
        $this->repository->updateRanking();
        $this->repository->updateRanking();

        // Récupérer le classement trié et convertir les objets en tableaux
        $ranking = DB::table('ranking')->orderBy('position')->get()->map(function ($item) {
            return (array) $item;
        })->toArray();

        // Vérifier que le classement est correct
        $this->assertEquals($ranking, $this->data->expectedSortedRanking());
    }

    function testSortedRanking(): void
    {
        $this->repository->fillDatabase();
        $this->repository->updateRanking();
        // Convertir les objets stdClass en tableaux associatifs avant la comparaison
        $sortedRanking = $this->repository->sortedRanking();
        // Si sortedRanking retourne des stdClass, les convertir en tableaux
        $sortedRanking = array_map(function ($item) {
            return (array) $item;
        }, $sortedRanking);
        $this->assertEquals($sortedRanking, $this->data->expectedSortedRankingWithName());
    }

    function testTeamMatches(): void
    {
        $this->repository->fillDatabase();
        $this->assertEquals($this->repository->teamMatches(4), $this->data->expectedMatchesForTeam());

    }

    function testRankingRow(): void
    {
        $this->repository->fillDatabase();
    }




    }
