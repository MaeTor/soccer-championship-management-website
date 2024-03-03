<?php

namespace App\Repositories;

class Ranking
{
    function goalDifference(int $goalFor, int $goalAgainst): int
    {
        return $goalFor - $goalAgainst;
    }

    function points(int $matchWonCount, int $drawMatchCount): int
    {
        return $matchWonCount * 3 + $drawMatchCount;
    }

    function teamWinsMatch(int $teamId, array $match): bool
    {

        return ($teamId == $match['team0'] && $match['score0'] > $match['score1']) || ($teamId == $match['team1'] && $match['score1'] > $match['score0']);
        /* if ($teamId == $match['team0']) {
             return $match['score0'] > $match['score1'];
         }

         if ($teamId == $match['team1']) {
             return $match['score1'] > $match['score0'];
         }

         return false; // Return false if the team ID doesn't match either team */
    }

    function teamLosesMatch(int $teamId, array $match): bool
    {
        return ($teamId == $match['team0'] && $match['score0'] < $match['score1']) || ($teamId == $match['team1'] && $match['score1'] < $match['score0'] );
//        if ($teamId == $match['team0']) {
//            return $match['score0'] < $match['score1'];
//        }
//
//        if ($teamId == $match['team1']) {
//            return $match['score1'] < $match['score0'];
//        }
//
//        return false;
    }
        function teamDrawsMatch(int $teamId, array $match): bool
        {
            return ($teamId == $match['team0'] && $match['score1'] == $match['score0']) || ($teamId == $match['team1'] && $match['score1'] == $match['score0'] );

//             if($teamId == $match['team0']){
//                 if($match['score0'] == $match['score1'] ) return true;
//                 else return false;
//             }
//             if($teamId == $match['team1']){
//                 if($match['score1'] == $match['score0'] ) return true;
//                 else return false;
//             }
//             return false;
        }

    function goalForCountDuringAMatch(int $teamId, array $match): int {
        if( $teamId == $match['team0']) return $match['score0'];
        else if( $teamId == $match['team1']) return $match['score1'];
        return 0;

    }

    function goalAgainstCountDuringAMatch(int $teamId, array $match): int {
        if( $teamId == $match['team0']) return $match['score1'];
        else if( $teamId == $match['team1']) return $match['score0'];
        return 0;

    }

    function goalForCount(int $teamId, array $matches): int
    {
        $sumScors = 0;
        foreach ($matches as $match) {
            if($teamId == $match['team0']) $sumScors += $match['score0'];
            else if($teamId == $match['team1']) $sumScors += $match['score1'];
        }
        return $sumScors;
    }

    function goalAgainstCount(int $teamId, array $matches): int
    {

        $sumScors = 0;
        foreach ($matches as $match) {
            if($teamId == $match['team0']) $sumScors += $match['score1'];
            else if($teamId == $match['team1']) $sumScors += $match['score0'];
        }
        return $sumScors;

    }

    function matchWonCount(int $teamId, array $matches): int
    {   $count = 0;
        foreach ($matches as $match) {
            if($this->teamWinsMatch($teamId,$match)) $count+=1;
        }
        return $count;
    }

    function matchLostCount(int $teamId, array $matches): int
    {
        $count = 0;
        foreach ($matches as $match) {
            if($this->teamLosesMatch($teamId,$match)) $count+=1;
        }
        return $count;
    }

    function drawMatchCount(int $teamId, array $matches): int
    {
        $count = 0;
        foreach ($matches as $match) {
            if($this->teamDrawsMatch($teamId,$match)) $count+=1;
        }
        return $count;
    }

    function rankingRow(int $teamId, array $matches): array
    {
        return [
            'team_id'            => $teamId,
            'match_played_count' => $this->matchWonCount($teamId,$matches)+ $this->matchLostCount($teamId,$matches)+ $this->drawMatchCount($teamId,$matches) ,
            'match_won_count'    => $this->matchWonCount($teamId,$matches),
            'match_lost_count'   => $this->matchLostCount($teamId,$matches),
            'draw_count'         => $this->drawMatchCount($teamId,$matches),
            'goal_for_count'     => $this->goalForCount($teamId,$matches),
            'goal_against_count' => $this->goalAgainstCount($teamId,$matches),
            'goal_difference'    => $this->goalDifference($this->goalForCount($teamId,$matches),$this->goalAgainstCount($teamId,$matches) ) ,
            'points'             => $this->points($this->matchWonCount($teamId,$matches),$this->drawMatchCount($teamId,$matches))
        ];
    }

    function unsortedRanking(array $teams, array $matches): array
    {
        $result =[];

        foreach ($teams as $team){
            $result[]=$this->rankingRow($team['id'], $matches);
        }
        return $result;
    }

    static function compareRankingRow(array $row1, array $row2): int
    {
        if( ($row1['points'] > $row2['points'])|| ($row1['points'] == $row2['points'] && $row1['goal_difference'] > $row2['goal_difference']  ) ||($row1['points'] == $row2['points'] && $row1['goal_difference'] == $row2['goal_difference'] && $row1['goal_for_count'] > $row2['goal_for_count'] )  ) return -1;
        elseif( ($row1['points'] < $row2['points'])|| ($row1['points'] == $row2['points'] && $row1['goal_difference'] < $row2['goal_difference']  ) ||($row1['points'] == $row2['points'] && $row1['goal_difference'] == $row2['goal_difference'] && $row1['goal_for_count'] < $row2['goal_for_count'] )  ) return 1;
        return 0;
    }

}
