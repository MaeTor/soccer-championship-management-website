<?php

namespace Tests\Unit;

use Exception;
use Tests\TestCase;
use App\Repositories\Repository;

class AuthFormTest extends TestCase 
{
    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new Repository();
        $this->repository->createDatabase();
    }

    public function testLogin()
    {
        $this->repository->addUser('test@example.com', 'secret');
        $this->mock(Repository::class, function ($mock) {
            $mock->shouldReceive('getUser')->with('test@example.com', 'secret')
                                           ->once()->andReturn(['id'=>1, 'email' => 'test@example.com']);
        });
        $response = $this->post('/login', ['email' => 'test@example.com', 'password'=>'secret']);
        $response->assertStatus(302);
        $response->assertSessionHas('user', ['id'=>1, 'email' => 'test@example.com']);
        $response->assertRedirect('/');
    }

    public function testLoginRedirectsIfEmailIsAbsent()
    {
        $this->repository->addUser('test@example.com', 'secret');
        $response = $this->withHeader('Referer', '/login')
                         ->post('/login', ['password'=>'secret']);
        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(["email"=>"Vous devez saisir un e-mail."]);
    }

    public function testLoginRedirectsIfEmailIsNotValid()
    {
        $this->repository->addUser('test@example.com', 'secret');
        $response = $this->withHeader('Referer', '/login')
                         ->post('/login', ['email' => 'test', 'password'=>'secret']);
        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(["email"=>"Vous devez saisir un e-mail valide."]);
    }

    public function testLoginRedirectsIfEmailDoesNotExist()
    {
        $response = $this->withHeader('Referer', '/login')
                         ->post('/login', ['email' => 'test@example.com', 'password'=>'secret']);
        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(["email"=>"Cet utilisateur n'existe pas."]);
    }

    public function testLoginRedirectsIfPasswordIsAbsent()
    {
        $this->repository->addUser('test@example.com', 'secret');
        $response = $this->withHeader('Referer', '/login')
                         ->post('/login', ['email' => 'test@example.com']);
        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(["password"=>"Vous devez saisir un mot de passe."]);
    }
    
    public function testLoginRedirectsIfPasswordIsIncorrect()
    {
        $this->repository->addUser('test@example.com', 'secret');
        $response = $this->withHeader('Referer', '/login')
                         ->post('/login', ['email' => 'test@example.com', 'password'=>'secret2']);
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function testLogout() 
    {
        $response = $this->withHeader('Referer', '/login')
                         ->withSession(['user' => ['id'=>1, 'email' => 'test@example.com']])
                         ->post('/logout');
        $response->assertStatus(302);
        $response->assertSessionMissing('user');
        $response->assertRedirect('/');
    }
    
}