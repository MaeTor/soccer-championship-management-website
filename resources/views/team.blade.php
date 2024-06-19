@extends('base')
    @section('title')
        Matchs de l'équipe
    @endsection
    @section('content')
<table>
    <thead>
    </thead>
    <tbody>
    <!-- Les lignes des matchs -->
    @foreach ($teamMatches as $match)
        <tr>
            <th>{{$match['date']}}</th>
            <th><a href="{{route('teams.show', ['teamId'=>$match['team0'] ] ) }}">{{$match['name0']}}</a></th>
            <th>{{$match['score0']}}</th>
            <th>{{$match['score1']}}</th>
            <th><a href="{{route('teams.show', ['teamId'=>$match['team1'] ] )}}">{{$match['name1']}}</a></th>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
