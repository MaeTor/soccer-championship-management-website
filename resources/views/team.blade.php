@extends('base')
    @section('title')
        Matchs de l'équipe
    @endsection
    @section('content')
        <table>
            <thead class="bg-gray-800 text-white">
            <tr>
                <th>N°</th>
                <th>Équipe</th>
                <th>MJ</th>
                <th>G</th>
                <th>N</th>
                <th>P</th>
                <th>BP</th>
                <th>BC</th>
                <th>DB</th>
                <th>PTS</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <table class="w-full border border-gray-300 rounded-lg overflow-hidden">
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
