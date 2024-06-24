<?php

namespace App\Http\Controllers;

use App\Repositories\Repository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }
    public function showRanking()
    {
        $ranking = $this->repository->sortedRanking();
        return view('ranking', ['ranking' => $ranking]);
    }


    public function showTeam(int $teamId)
    {
        $teamMatches = $this->repository->teamMatches($teamId);
        $rowteam = $this->repository->rankingRow($teamId);
        return view('team',['teamMatches' => $teamMatches, 'rowTeam'=>$rowteam]);
    }

}
