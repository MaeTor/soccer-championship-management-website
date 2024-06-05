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
            <th>{{$match['name0']}}</th>
            <th>{{$match['score0']}}</th>
            <th>{{$match['score1']}}</th>
            <th>{{$match['name1']}}</th>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
