<?php

namespace Tests\Unit;

use Exception;
use Tests\TestCase;
use App\Repositories\Repository;
use App\Repositories\Data;

class FormTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new Repository();
        $this->repository->createDatabase();
    }

    public function testStoreTeam()
    {
        $this->mock(Repository::class, function ($mock) {
            $mock->shouldReceive('insertTeam')->with(['name' => 'Marseille'])->once()->andReturn(1);
            $mock->shouldReceive('updateRanking')->once();
        });
        $response = $this->post('/teams', ['team_name' => 'Marseille']);
        $response->assertStatus(302);
        $response->assertRedirect('/teams/1');
    }

    public function testStoreTeamRedirectsIfNameIsAbsent()
    {
        $response = $this->withHeader('Referer', '/teams/create')->post('/teams', []);
        $response->assertStatus(302);
        $response->assertRedirect('/teams/create');
        $response->assertSessionHasErrors(["team_name"=>"Vous devez saisir un nom d'équipe."]);
    }

    public function testStoreTeamRedirectsIfNameIsTooShort()
    {
        $response = $this->withHeader('Referer', '/teams/create')->post('/teams', ['team_name' => 'A']);
        $response->assertStatus(302);
        $response->assertRedirect('/teams/create');
        $response->assertSessionHasErrors(["team_name"=>"Le nom doit contenir au moins 3 caractÃ¨res."]);
    }

    public function testStoreTeamRedirectsIfNameIsTooLong() 
    {
        $response = $this->withHeader('Referer', '/teams/create')->post('/teams', ['team_name' => 'AAAAAAAAAAAAAAAAAAAAA']);
        $response->assertStatus(302);
        $response->assertRedirect('/teams/create');
        $response->assertSessionHasErrors(["team_name"=>"Le nom doit contenir au plus 20 caractÃ¨res."]);
    }

    public function testStoreTeamRedirectsIfNameAlreadyExists() 
    {    
        $this->repository->insertTeam(['name' => 'Marseille']);
        $response = $this->withHeader('Referer', '/teams/create')->post('/teams', ['team_name' => 'Marseille']);
        $response->assertStatus(302);
        $response->assertRedirect('/teams/create');
        $response->assertSessionHasErrors(["team_name"=>"Le nom d'équipe existe déjà ."]);
    }

    public function testStoreTeamRedirectsIfRepositoryThrowsException() 
    {    
        $this->mock(Repository::class, function ($mock) {
            $mock->shouldReceive('insertTeam')->andThrow(new Exception(""));
        });
        $response = $this->withHeader('Referer', '/teams/create')->post('/teams', ['team_name' => 'Marseille']);
        $response->assertStatus(302);
        $response->assertRedirect('/teams/create');
    }

    public function testStoreMatch()
    {
        $this->repository->insertTeam(['name' => 'Marseille']);
        $this->repository->insertTeam(['name' => 'Paris']);
        $this->mock(Repository::class, function ($mock) {
            $mock->shouldReceive('insertMatch')->with(['team0' => 1, 'team1' => 2, 'date'=>'2048-10-05 10:22', 'score0'=>2, 'score1'=>4])->once()->andReturn(1);
            $mock->shouldReceive('updateRanking')->once();
        });
        $response = $this->post('/matches', ['team0' => '1', 'team1' => '2', 'date'=>'2048-10-05', 'time'=>'10:22', 'score0'=>'2', 'score1'=>'4']);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    public function testStoreMatchRedirectsIfTeam0IsAbsent()
    {
        $this->repository->insertTeam(['name' => 'Marseille']);
        $this->repository->insertTeam(['name' => 'Paris']);
        $response = $this->withHeader('Referer', '/matches/create')->post('/matches', ['team1' => '2', 'date'=>'2048-10-05', 'time'=>'10:22', 'score0'=>'2', 'score1'=>'4']);
        $response->assertStatus(302);
        $response->assertRedirect('/matches/create');
        $response->assertSessionHasErrors(["team0"=>"Vous devez choisir une équipe."]);
    }

    public function testStoreMatchRedirectsIfTeam0DoesNotExist()
    {
        $this->repository->insertTeam(['name' => 'Marseille']);
        $this->repository->insertTeam(['name' => 'Paris']);
        $response = $this->withHeader('Referer', '/matches/create')->post('/matches', ['team0' => '3', 'team1' => '2', 'date'=>'2048-10-05', 'time'=>'10:22', 'score0'=>'2', 'score1'=>'4']);
        $response->assertStatus(302);
        $response->assertRedirect('/matches/create');
        $response->assertSessionHasErrors(["team0"=>"Vous devez choisir une équipe qui existe."]);
    }

    public function testStoreMatchRedirectsIfTeam1IsAbsent()
    {
        $this->repository->insertTeam(['name' => 'Marseille']);
        $this->repository->insertTeam(['name' => 'Paris']);
        $response = $this->withHeader('Referer', '/matches/create')->post('/matches', ['team0' => '2', 'date'=>'2048-10-05', 'time'=>'10:22', 'score0'=>'2', 'score1'=>'4']);
        $response->assertStatus(302);
        $response->assertRedirect('/matches/create');
        $response->assertSessionHasErrors(["team1"=>"Vous devez choisir une équipe."]);
    }

    public function testStoreMatchRedirectsIfTeam1DoesNotExist()
    {
        $this->repository->insertTeam(['name' => 'Marseille']);
        $this->repository->insertTeam(['name' => 'Paris']);
        $response = $this->withHeader('Referer', '/matches/create')->post('/matches', ['team0' => '2', 'team1' => '3', 'date'=>'2048-10-05', 'time'=>'10:22', 'score0'=>'2', 'score1'=>'4']);
        $response->assertStatus(302);
        $response->assertRedirect('/matches/create');
        $response->assertSessionHasErrors(["team1"=>"Vous devez choisir une équipe qui existe."]);
    }
    
    public function testStoreMatchRedirectsIfDateIsAbsent()
    {
        $this->repository->insertTeam(['name' => 'Marseille']);
        $this->repository->insertTeam(['name' => 'Paris']);
        $response = $this->withHeader('Referer', '/matches/create')->post('/matches', ['team0'=>'1', 'team1' => '2', 'time'=>'10:22', 'score0'=>'2', 'score1'=>'4']);
        $response->assertStatus(302);
        $response->assertRedirect('/matches/create');
        $response->assertSessionHasErrors(["date"=>"Vous devez choisir une date."]);
    }

    public function testStoreMatchRedirectsIfDateIsNotValid()
    {
        $this->repository->insertTeam(['name' => 'Marseille']);
        $this->repository->insertTeam(['name' => 'Paris']);
        $response = $this->withHeader('Referer', '/matches/create')->post('/matches', ['team0'=>'1', 'team1' => '2', 'date'=>'aaa', 'time'=>'10:22', 'score0'=>'2', 'score1'=>'4']);
        $response->assertStatus(302);
        $response->assertRedirect('/matches/create');
        $response->assertSessionHasErrors(["date"=>"Vous devez choisir une date valide."]);
    }

    public function testStoreMatchRedirectsIfTimeIsAbsent()
    {
        $this->repository->insertTeam(['name' => 'Marseille']);
        $this->repository->insertTeam(['name' => 'Paris']);
        $response = $this->withHeader('Referer', '/matches/create')->post('/matches', ['team0'=>'1', 'team1' => '2', 'date'=>'2048-10-05', 'score0'=>'2', 'score1'=>'4']);
        $response->assertStatus(302);
        $response->assertRedirect('/matches/create');
        $response->assertSessionHasErrors(["time"=>"Vous devez choisir une heure."]);
    }

    public function testStoreMatchRedirectsIfTimeIsNotValid()
    {
        $this->repository->insertTeam(['name' => 'Marseille']);
        $this->repository->insertTeam(['name' => 'Paris']);
        $response = $this->withHeader('Referer', '/matches/create')->post('/matches', ['team0'=>'1', 'team1' => '2', 'date'=>'2048-10-05', 'time'=>'aaa', 'score0'=>'2', 'score1'=>'4']);
        $response->assertStatus(302);
        $response->assertRedirect('/matches/create');
        $response->assertSessionHasErrors(["time"=>"Vous devez choisir une heure valide."]);
    }

    public function testStoreMatchRedirectsIfScore0IsAbsent()
    {
        $this->repository->insertTeam(['name' => 'Marseille']);
        $this->repository->insertTeam(['name' => 'Paris']);
        $response = $this->withHeader('Referer', '/matches/create')->post('/matches', ['team0'=>'1', 'team1' => '2', 'date'=>'2048-10-05', 'time'=>'10:22', 'score1'=>'4']);
        $response->assertStatus(302);
        $response->assertRedirect('/matches/create');
        $response->assertSessionHasErrors(["score0"=>"Vous devez choisir un nombre de buts."]);
    }

    public function testStoreMatchRedirectsIfScore0IsNotInteger()
    {
        $this->repository->insertTeam(['name' => 'Marseille']);
        $this->repository->insertTeam(['name' => 'Paris']);
        $response = $this->withHeader('Referer', '/matches/create')->post('/matches', ['team0'=>'1', 'team1' => '2', 'date'=>'2048-10-05', 'time'=>'10:22', 'score0'=>'a', 'score1'=>'4']);
        $response->assertStatus(302);
        $response->assertRedirect('/matches/create');
        $response->assertSessionHasErrors(["score0"=>"Vous devez choisir un nombre de buts entier."]);
    }

    public function testStoreMatchRedirectsIfScore0IsNegative()
    {
        $this->repository->insertTeam(['name' => 'Marseille']);
        $this->repository->insertTeam(['name' => 'Paris']);
        $response = $this->withHeader('Referer', '/matches/create')->post('/matches', ['team0'=>'1', 'team1' => '2', 'date'=>'2048-10-05', 'time'=>'10:22', 'score0'=>'-1', 'score1'=>'4']);
        $response->assertStatus(302);
        $response->assertRedirect('/matches/create');
        $response->assertSessionHasErrors(["score0"=>"Vous devez choisir un nombre de buts entre 0 et 50."]);
    }

    public function testStoreMatchRedirectsIfScore0IsTooLarge()
    {
        $this->repository->insertTeam(['name' => 'Marseille']);
        $this->repository->insertTeam(['name' => 'Paris']);
        $response = $this->withHeader('Referer', '/matches/create')->post('/matches', ['team0'=>'1', 'team1' => '2', 'date'=>'2048-10-05', 'time'=>'10:22', 'score0'=>'51', 'score1'=>'4']);
        $response->assertStatus(302);
        $response->assertRedirect('/matches/create');
        $response->assertSessionHasErrors(["score0"=>"Vous devez choisir un nombre de buts entre 0 et 50."]);
    }

    public function testStoreMatchRedirectsIfScore1IsAbsent()
    {
        $this->repository->insertTeam(['name' => 'Marseille']);
        $this->repository->insertTeam(['name' => 'Paris']);
        $response = $this->withHeader('Referer', '/matches/create')->post('/matches', ['team0'=>'1', 'team1' => '2', 'date'=>'2048-10-05', 'time'=>'10:22', 'score0'=>'4']);
        $response->assertStatus(302);
        $response->assertRedirect('/matches/create');
        $response->assertSessionHasErrors(["score1"=>"Vous devez choisir un nombre de buts."]);
    }

    public function testStoreMatchRedirectsIfScore1IsNotInteger()
    {
        $this->repository->insertTeam(['name' => 'Marseille']);
        $this->repository->insertTeam(['name' => 'Paris']);
        $response = $this->withHeader('Referer', '/matches/create')->post('/matches', ['team0'=>'1', 'team1' => '2', 'date'=>'2048-10-05', 'time'=>'10:22', 'score0'=>'4', 'score1'=>'a']);
        $response->assertStatus(302);
        $response->assertRedirect('/matches/create');
        $response->assertSessionHasErrors(["score1"=>"Vous devez choisir un nombre de buts entier."]);
    }

    public function testStoreMatchRedirectsIfScore1IsNegative()
    {
        $this->repository->insertTeam(['name' => 'Marseille']);
        $this->repository->insertTeam(['name' => 'Paris']);
        $response = $this->withHeader('Referer', '/matches/create')->post('/matches', ['team0'=>'1', 'team1' => '2', 'date'=>'2048-10-05', 'time'=>'10:22', 'score0'=>'5', 'score1'=>'-1']);
        $response->assertStatus(302);
        $response->assertRedirect('/matches/create');
        $response->assertSessionHasErrors(["score1"=>"Vous devez choisir un nombre de buts entre 0 et 50."]);
    }

    public function testStoreMatchRedirectsIfScore1IsTooLarge()
    {
        $this->repository->insertTeam(['name' => 'Marseille']);
        $this->repository->insertTeam(['name' => 'Paris']);
        $response = $this->withHeader('Referer', '/matches/create')->post('/matches', ['team0'=>'1', 'team1' => '2', 'date'=>'2048-10-05', 'time'=>'10:22', 'score0'=>'5', 'score1'=>'51']);
        $response->assertStatus(302);
        $response->assertRedirect('/matches/create');
        $response->assertSessionHasErrors(["score1"=>"Vous devez choisir un nombre de buts entre 0 et 50."]);
    }

    public function testStoreMatchRedirectsIfRepositoryThrowsException() 
    {    
        $this->repository->insertTeam(['name' => 'Marseille']);
        $this->repository->insertTeam(['name' => 'Paris']);
        $this->mock(Repository::class, function ($mock) {
            $mock->shouldReceive('insertMatch')->andThrow(new Exception(""));
        });
        $response = $this->withHeader('Referer', '/matches/create')->post('/matches', ['team0'=>'1', 'team1' => '2', 'date'=>'2048-10-05', 'time'=>'10:22', 'score0'=>'5', 'score1'=>'5']);
        $response->assertStatus(302);
        $response->assertRedirect('/matches/create');
    }
}