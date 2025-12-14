<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Repositories\Repository;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * More precisely, this method is responsible for populating the application's database with initial test or default data.
     * It is executed when running the `php artisan db:seed` command, which is typically used during the development or testing phase
     * to ensure the database is seeded with data to work with.
     * @return void
     */
    public function run()
    {
        touch('database/database.mysql');
        $repository = new Repository();
        $repository->createDatabase();
        $repository->fillDatabase();
        $repository->updateRanking();
        $repository->addUser('user@example.com', 'secret');

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
