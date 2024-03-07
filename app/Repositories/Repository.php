<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class Repository
{
    function createDatabase(): void
    {
        DB::unprepared(file_get_contents('database/build.sql'));
    }


}
