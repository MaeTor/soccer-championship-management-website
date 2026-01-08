<?php

namespace App\Http\Controllers;

use App\Repositories\Repository;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

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

    public function createTeam(Request $request)
    {
        if (! $request->session()->has('user')) {
            return redirect(route('login'));
        }

        return view('team_create');
    }

    public function storeTeam(Request $request)
    {
        if (! $request->session()->has('user')) {
            return redirect(route('login'));
        }
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
        } catch (Exception $exception) {
            return redirect()->route('teams.create')->withErrors("Impossible de créer l'équipe.");
        }
    }

    public function createMatch(Request $request)
    {
        if (! $request->session()->has('user')) {
            return redirect(route('login'));
        }
        $teams = $this->repository->teams();

        return view('match_create', ['teams' => $teams]);
    }

    public function storeMatch(Request $request)
    {
        if (! $request->session()->has('user')) {
            return redirect(route('login'));
        }
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

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request, Repository $repository)
    {
        $rules = [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required'],
        ];
        $messages = [
            'email.required' => 'Vous devez saisir un e-mail.',
            'email.email' => 'Vous devez saisir un e-mail valide.',
            'email.exists' => "Cet utilisateur n'existe pas.",
            'password.required' => 'Vous devez saisir un mot de passe.',
        ];
        $validatedData = $request->validate($rules, $messages);
        try {
            // TODO 1: Throw an exception if the user's password is incorrect
            $currentUser = $repository->getUser($validatedData['email'], $validatedData['password']);
            // TODO 2: Remember the user's authentication
            $request->session()->put('user', $currentUser);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors('Impossible de vous authentifier.');
        }

        return redirect()->route('ranking.show');
    }

    public function followTeam(int $teamId)
    {
        return redirect()->route('ranking.show')->cookie('followed_team', $teamId);
    }

    public function logout(Request $request)
    {

        $request->session()->forget('user');

        return redirect()->route('ranking.show');
    }

    public function showPasswordForm()
    {
        return view('password_change');
    }

    public function updatePassword(Request $request, Repository $repository)
    {
        $currentUser = $request->session()->get('user');

        if (! $currentUser) {
            return redirect()->route('login');
        }

        $rules = [
            'old_password' => ['required'],
            'new_password' => ['required', 'min:5'],
            'repeat_new_password' => ['required', 'same:new_password'],
        ];

        $messages = [
            'old_password.required' => 'Veuillez saisir votre mot de passe actuel.',
            'new_password.required' => 'Veuillez saisir un nouveau mot de passe.',
            'new_password.min' => 'Le nouveau mot de passe doit contenir au moins :min caractères.',
            'repeat_new_password.required' => 'Veuillez confirmer le nouveau mot de passe.',
            'repeat_new_password.same' => 'Les deux mots de passe ne correspondent pas.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        /**
         * Conditional validation:
         * old_password is only considered valid if checkOldPassword() returns true
         */
        $validator->after(function ($validator) use ($repository, $currentUser, $request) {
            if (! $repository->checkOldPassword($currentUser['email'], $request->input('old_password'))) {
                $validator->errors()->add(
                    'old_password',
                    'Le mot de passe actuel est incorrect.'
                );
            }
        });

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput([]); // ❗ clears old input
        }

        // Update password
        $repository->changePassword(
            $currentUser['email'],
            $request->input('old_password'),
            $request->input('new_password')
        );

        return redirect('/');
    }
}
