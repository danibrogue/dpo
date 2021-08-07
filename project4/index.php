<?php
    require './script1.php';
    require './script2.php';

    $string1 = '2aaa\'3\'bbb\'45\'';
    $string2 = 'http://asozd.duma.gov.ru/main.nsf/(Spravka)?OpenAgent&RN=366426-7&11';

    echo doubler($string1);
    echo "\n";
    echo new_link($string2);
?>