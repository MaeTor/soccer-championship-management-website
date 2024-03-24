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


    }












}
