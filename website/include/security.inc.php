<?php
// security.inc.php - Safe escaping function (only one definition)

if (!function_exists('escape')) {
    function escape($con, $str) {
        return mysqli_real_escape_string($con, trim($str));
    }
}
?>