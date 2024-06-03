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
    <!-- Les lignes des équipes seront insérées ici -->
    @foreach ($teamMatches as $match)
        <tr>
            <th>{{$match['date']}}</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
