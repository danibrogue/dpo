<?php
    function doubler($string)
    {
        $exp = '/(\')(\d+)(\')/';
        return preg_replace_callback($exp, 
        function ($matches){
            return $matches[1].($matches[2]*2).$matches[3];
        },
        $string);
    }
?>