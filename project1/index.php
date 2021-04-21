<?php
    require './task1.php';

    $inputs = glob("test/*.dat");
    $outputs = glob("test/*.ans");
    foreach(array_combine($inputs, $outputs) as $input => $output)
    {
        $fs = fopen($output, 'r');
        $expected_answer = fgets($fs);
        $received_answer = get_data($input);
        echo $received_answer;
        if ($expected_answer == $received_answer)
        {
            echo " Correct\n";
        }
        else 
        {
            echo " Incorrect\n";
        }
    }
?>