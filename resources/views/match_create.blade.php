@extends('base')
@section('title', 'Création d\'un match')
@section('content')
<form method="POST" action="{{route('matches.store')}}">
    @csrf
    <div class="form-group">
        <label for="team0">Équipe à domicile</label>
        <select class="form-control" id="team0" name="team0">
        </select>
    </div>
    <div class="form-group">
        <label for="team1">Équipe à l'extérieur</label>
        <select class="form-control" id="team1" name="team1">
        </select>
    </div>
    <div class="form-group">
        <label for="date">Date</label>
        <input type="date" class="form-control" id="date" name="date">
    </div>
    <div class="form-group">
        <label for="time">Heure</label>
        <input type="time" class="form-control" id="time" name="time">
    </div>
    <div class="form-group">
        <label for="score0">Nombre de buts de l'équipe à domicile</label>
        <input type="number" class="form-control" id="score0" name="score0" min="0">
    </div>
    <div class="form-group">
        <label for="score1">Nombre de buts de l'équipe à l'extérieur</label>
        <input type="number" class="form-control" id="score1" name="score1" min="0">
    </div>
    <button type="submit" class="btn btn-primary">Soumettre</button>
</form>
@endsection