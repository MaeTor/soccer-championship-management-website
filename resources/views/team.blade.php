@extends('base')
    @section('title')
        Matchs joués par l'équipe
    @endsection

    <!doctype html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th{
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
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
</body>
</html>
