<?php

use App\Repositories\Data;
use App\Repositories\Ranking;
use App\Repositories\Repository;
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
    }













    }
