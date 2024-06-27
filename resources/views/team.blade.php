@extends('base')
    @section('title')
        Matchs de l'équipe
    @endsection
    @section('content')
        <table class="w-full border border-gray-300 rounded-lg overflow-hidden">
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
            <!-- Les lignes des équipes -->
            @foreach($rowTeam as $line)
                <tr>
                    <th>{{$line->position}}</th>
                    <th><a href="{{Route('teams.show', ['teamId' => $line->team_id] ) }}" class="text-blue-500">{{$line->name}}</a></th>
                    <th>{{$line->match_played_count}}</th>
                    <th>{{$line->match_won_count}}</th>
                    <th>{{$line->draw_count}}</th>
                    <th>{{$line->match_lost_count}}</th>
                    <th>{{$line->goal_for_count}}</th>
                    <th>{{$line->goal_against_count}}</th>
                    <th>{{$line->goal_difference}}</th>
                    <th>{{$line->points}}</th>
                </tr>
            @endforeach
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
            <th><a href="{{route('teams.show', ['teamId'=>$match['team0'] ] ) }}" class="text-blue-500">{{$match['name0']}}</a></th>
            <th>{{$match['score0']}}</th>
            <th>{{$match['score1']}}</th>
            <th><a href="{{route('teams.show', ['teamId'=>$match['team1'] ] )}}" class="text-blue-500">{{$match['name1']}}</a></th>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
