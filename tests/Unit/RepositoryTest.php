<?php

use App\Repositories\Data;
use App\Repositories\Ranking;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->ranking = new Ranking();
        $this->data = new Data();
    }




}
