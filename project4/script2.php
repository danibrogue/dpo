<?php
    function new_link($link)
    {
        $exp = '/(http:\/\/asozd\.duma\.gov\.ru\/main\.nsf\/\(Spravka\)\?OpenAgent&RN=)((\w|-)+)(&)(\d+)/';
        return preg_replace_callback($exp, 
        function($matches)
        {
            return "http://sozd.parlament.gov.ru/bill/".$matches[2];
        },
        $link);
    }
?>