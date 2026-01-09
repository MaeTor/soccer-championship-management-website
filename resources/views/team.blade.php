@extends('base')
@section('title')
Matchs de l'équipe
@endsection
@section('content')
<a class="btn-primary" href="{{ route('teams.follow', ['teamId'=>$rowTeam['team_id']])}}">Suivre</a><br><br>
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
        <!-- La ligne de l'équipe -->
        <tr>
            <th>{{$rowTeam['position']}}</th>
            <th><a href="{{Route('teams.show', ['teamId' => $rowTeam['team_id']] ) }}"
                    class="text-blue-500">{{$rowTeam['name']}}</a></th>
            <th>{{$rowTeam['match_played_count']}}</th>
            <th>{{$rowTeam['match_won_count']}}</th>
            <th>{{$rowTeam['draw_count']}}</th>
            <th>{{$rowTeam['match_lost_count']}}</th>
            <th>{{$rowTeam['goal_for_count']}}</th>
            <th>{{$rowTeam['goal_against_count']}}</th>
            <th>{{$rowTeam['goal_difference']}}</th>
            <th>{{$rowTeam['points']}}</th>
        </tr>
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
            <th><a href="{{route('teams.show', ['teamId'=>$match['team0'] ] ) }}"
                    class="text-blue-500">{{$match['name0']}}</a></th>
            <th>{{$match['score0']}}</th>
            <th>-</th>
            <th>{{$match['score1']}}</th>
            <th><a href="{{route('teams.show', ['teamId'=>$match['team1'] ] )}}"
                    class="text-blue-500">{{$match['name1']}}</a></th>
            <th id="delete-th"
                class="cursor-pointer px-4 py-2 text-left text-sm font-semibold text-gray-700 hover:text-red-600"><svg
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    id="Delete-2--Streamline-Ultimate" height="24" width="24">
                    <desc>
                        Delete 2 Streamline Icon: https://streamlinehq.com
                    </desc>
                    <path fill="#ff808c"
                        d="M12.0002 22.5416c5.8217 0 10.5416 -4.7199 10.5416 -10.5416 0 -5.82177 -4.7199 -10.54169 -10.5416 -10.54169C6.17841 1.45831 1.4585 6.17823 1.4585 12c0 5.8217 4.71991 10.5416 10.5417 10.5416Z"
                        stroke-width="1"></path>
                    <path fill="#ffbfc5"
                        d="M4.54569 19.4544C2.56868 17.4773 1.45801 14.7959 1.45801 12c0 -2.79589 1.11067 -5.47729 3.08768 -7.45431C6.52271 2.56868 9.20411 1.45801 12 1.45801c2.7959 0 5.4773 1.11067 7.4544 3.08768L4.54569 19.4544Z"
                        stroke-width="1"></path>
                    <path stroke="#191919" stroke-linecap="round" stroke-linejoin="round"
                        d="M12.0002 22.5416c5.8217 0 10.5416 -4.7199 10.5416 -10.5416 0 -5.82177 -4.7199 -10.54169 -10.5416 -10.54169C6.17841 1.45831 1.4585 6.17823 1.4585 12c0 5.8217 4.71991 10.5416 10.5417 10.5416Z"
                        stroke-width="1"></path>
                    <path stroke="#191919" stroke-linecap="round" stroke-linejoin="round"
                        d="m7.4165 7.41669 9.1667 9.16671" stroke-width="1"></path>
                    <path stroke="#191919" stroke-linecap="round" stroke-linejoin="round"
                        d="M16.5832 7.41669 7.4165 16.5834" stroke-width="1"></path>
                </svg>
            </th>
        </tr>
        @endforeach
    </tbody>
</table>
        <div id="delete-popover" popover class="
    relative z-9999
    flex items-center justify-center
    bg-black/40 backdrop-blur-sm
  ">
            <div class="
      w-full max-w-md
      rounded-xl bg-white p-6
      shadow-2xl
    ">
                <p class="mb-6 text-base text-gray-800">
                     ⚠️ Are you sure you want to delete this match ?
                </p>

                <div class="flex justify-end gap-3">
                    <!-- Yes -->
                    <button class="
          rounded-md border border-gray-300
          bg-white px-4 py-2 text-sm text-gray-700
          hover:bg-gray-100
        ">
                        Yes
                    </button>

                    <!-- No -->
                    <button class="
          rounded-md bg-red-600
          px-4 py-2 text-sm text-white
          hover:bg-red-700
        ">
                        No
                    </button>
                </div>
            </div>
        </div>
@endsection