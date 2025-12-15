@extends('base')
@section('title', 'Authentification')
@section('content')
<form method="POST" action="{{route('login.post')}}" >
@if ($errors->any())
<div class="alert-warning">
    Vous n'avez pas pu être authentifié &#9785;
    </div>
    @endif
    <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" value="{{old('email')}}" aria-describedby="email_feedback" class="form-control @error('email')
        is-invalid @enderror">
        @error('email')
        <div id="email_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" value="{{old('password')}}"
            aria-describedby="password_feedback" class="form-control @error('password')
is-invalid @enderror">
        @error('password')
        <div id="password_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <button type="submit" class="btn-primary">Se connecter</button>
</form>
@endsection