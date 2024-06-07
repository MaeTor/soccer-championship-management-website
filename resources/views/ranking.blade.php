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
                @foreach ($ranking as $line)
                    <tr>
                        <th>{{$line->position}}</th>
                        <th><a href="{{Route('teams.show', ['teamId' => $line->team_id] ) }}">{{$line->name}}</a></th>
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
            <!-- Les lignes des équipes seront insérées ici -->
            </tbody>
        </table>
    </body>
</html>
