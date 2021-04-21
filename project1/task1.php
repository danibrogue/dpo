<?php
function get_data($path)
{
    //считаем файл в массив
    if(!file_exists($path))exit("Файл не найден");
    $data = file($path);
    //запишем кол-во ставок и отделим массив ставок
    $bets_amount = (int)$data[0];
    $bets_array = array_slice($data, 1, $bets_amount);
    for($i = 0; $i < count($bets_array); $i++)
    {
        $bets_array[$i] = explode(' ', $bets_array[$i]);
        $bets_array[$i] = [
            "id" => (int)$bets_array[$i][0],
            "amount" => (int)$bets_array[$i][1],
            "result" => (string)$bets_array[$i][2]
        ];
    }
    //запишем кол-во игр и отделим массив игр
    $games_amount = (int)$data[$bets_amount + 1];
    $games_array = array_slice($data, $bets_amount + 2, $games_amount);
    for($i = 0; $i < count($games_array); $i++)
    {
        $games_array[$i] = explode(' ', $games_array[$i]);
        $games_array[$i] = [
            "id" => (int)$games_array[$i][0],
            "coef_left" => (float)$games_array[$i][1],
            "coef_right" => (float)$games_array[$i][2],
            "coef_draw" => (float)$games_array[$i][3],
            "result" => (string)$games_array[$i][4]
        ];
    }
    $money = (float)0;
    //проход по массиву ставок
    for($i = 0; $i < $bets_amount; $i++)
    {
        //изменение баланса
        $money = $money - $bets_array[$i]["amount"];
        $game_number = $bets_array[$i]["id"] - 1;
        if($games_array[$game_number]["result"] == $bets_array[$i]["result"])
        {
            switch($games_array[$game_number]["result"])
            {
                case stristr($games_array[$game_number]["result"], "L"):
                    $money = $money + $bets_array[$i]["amount"] * $games_array[$game_number]["coef_left"];
                    break;
                case stristr($games_array[$game_number]["result"], "R"):
                    $money = $money + $bets_array[$i]["amount"] * $games_array[$game_number]["coef_right"];
                    break;
                case stristr($games_array[$game_number]["result"], "D"):
                    $money = $money + $bets_array[$i]["amount"] * $games_array[$game_number]["coef_draw"];
                    break;
            }
        }
    }
    return $money;
}
?>