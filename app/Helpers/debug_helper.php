<?php


/**
 * Returns print_r with pre formatted
 */
function print_array($array)
{
    echo '<pre>'; 
    print_r($array);
    echo '</pre>'; 
}