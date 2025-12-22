<?php

function inspect($var): void
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

function inspectAndDie($var): void
{
    inspect($var);
    die();
}
