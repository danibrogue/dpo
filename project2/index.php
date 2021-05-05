<?php
    require './Task2.php';
    if(@simplexml_load_file('data.xml')) {
        add_to_db(simplexml_load_file('data.xml'));
    }
    else
    {
        echo "Файл не соответствует стандарту xml".PHP_EOL;
    }
?>