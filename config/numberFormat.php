<?php
    function number_format_short($n) {
        // first strip any formatting;
        $n = (0+str_replace(",", "", $n));
        // is this a number?
        if (!is_numeric($n)) return false;
         // now filter it;
        if ($n > 1000000000000) return round(($n/1000000000000), 2).'T';
        elseif ($n > 1000000000) return round(($n/1000000000), 2).'B';
        elseif ($n > 1000000) return round(($n/1000000), 2).'M';
        elseif ($n > 1000) return round(($n/1000), 2).'K';
 
        return number_format($n);
    }
?>