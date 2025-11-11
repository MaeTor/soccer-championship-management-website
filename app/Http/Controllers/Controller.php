<?php

namespace App\Http\Controllers;

use App\Repositories\Repository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Exception;


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

    public function createTeam()
    {
        return view('team_create');
    }

    public function storeTeam(Request $request)
    {
        $messages = [
'team_name.required' => "Vous devez saisir un nom d'équipe.",
'team_name.min' => "Le nom doit contenir au moins :min caractères.",
'team_name.max' => "Le nom doit contenir au plus :max caractères.",
'team_name.unique' => "Le nom d'équipe existe déjà."
];
        $rules = ['team_name' => ['required', 'min:3', 'max:20', 'unique:teams,name']];
        $validatedData = $request->validate($rules,$messages);
        $team = ['name' => $validatedData['team_name']];
        try{
        $teamId = $this->repository->insertTeam($team);
        $this->repository->updateRanking();
        return redirect()->route('teams.show', ['teamId' => $teamId]);
        }catch(Exception $exception){
        return redirect()->route('teams.create')->withErrors("Impossible de créer l'équipe.");
        } 
    }

    public function createMatch()
    {
        $teams=$this->repository->teams();
        return view('match_create',['teams'=>$teams]);
    }
    public function storeMatch(Request $request) {
        return 'TODO';
    }
}

