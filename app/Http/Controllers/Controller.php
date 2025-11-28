<?php

namespace App\Http\Controllers;

use App\Repositories\Repository;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
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

        return view('team', ['teamMatches' => $teamMatches, 'rowTeam' => $rowteam]);
    }

    public function createTeam()
    {
        return view('team_create');
    }

    public function storeTeam(Request $request)
    {
        $messages = [
            'team_name.required' => "Vous devez saisir un nom d'équipe.",
            'team_name.min' => 'Le nom doit contenir au moins :min caractères.',
            'team_name.max' => 'Le nom doit contenir au plus :max caractères.',
            'team_name.unique' => "Le nom d'équipe existe déjà.",
        ];
        $rules = ['team_name' => ['required', 'min:3', 'max:20', 'unique:teams,name']];
        $validatedData = $request->validate($rules, $messages);
        $team = ['name' => $validatedData['team_name']];
        try {
            $teamId = $this->repository->insertTeam($team);
            $this->repository->updateRanking();

            return redirect()->route('teams.show', ['teamId' => $teamId]);
        } catch(Exception $exception) {
            return redirect()->route('teams.create')->withErrors("Impossible de créer l'équipe.");
        }
    }

    public function createMatch()
    {
        $teams = $this->repository->teams();

        return view('match_create', ['teams' => $teams]);
    }

    public function storeMatch(Request $request)
    {
        $rules = [
            'team0' => ['required', 'exists:teams,id'],
            'team1' => ['required', 'exists:teams,id'],
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:H:i'],
            'score0' => ['required', 'integer', 'between:0,50'],
            'score1' => ['required', 'integer', 'between:0,50'],
        ];
        $messages = [
            'team0.required' => 'Vous devez choisir une équipe.',
            'team0.exists' => 'Vous devez choisir une équipe qui existe.',
            'team1.required' => 'Vous devez choisir une équipe.',
            'team1.exists' => 'Vous devez choisir une équipe qui existe.',
            'date.required' => 'Vous devez choisir une date.',
            'date.date' => 'Vous devez choisir une date valide.',
            'time.required' => 'Vous devez choisir une heure.',
            'time.date_format' => 'Vous devez choisir une heure valide.',
            'score0.required' => 'Vous devez choisir un nombre de buts.',
            'score0.integer' => 'Vous devez choisir un nombre de buts entier.',
            'score0.between' => 'Vous devez choisir un nombre de buts entre 0 et 50.',
            'score1.required' => 'Vous devez choisir un nombre de buts.',
            'score1.integer' => 'Vous devez choisir un nombre de buts entier.',
            'score1.between' => 'Vous devez choisir un nombre de buts entre 0 et 50.',
        ];
        $validatedData = $request->validate($rules, $messages);

        try {
            $date = $validatedData['date'];
            $time = $validatedData['time'];
            $datetime = "$date $time";

            $this->repository->insertMatch(['team0' => $validatedData['team0'], 'team1' => $validatedData['team1'], 'score0' => $validatedData['score0'], 'score1' => $validatedData['score1'], 'date' => $datetime]);
            $this->repository->updateRanking();

            return redirect()->route('ranking.show');
        } catch (Exception $exception) {
            return redirect()->route('matches.create')->withErrors('Impossible de créer le match.');
        }
    }
}
