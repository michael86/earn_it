<?php

function inspect($var): void
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

function inspectAndDie(...$var): void
{
    foreach ($var as $var) {

        inspect($var);
    }
    die();
}
