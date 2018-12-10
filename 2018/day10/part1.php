<?php

require '../core.php';
require 'core.php';

function getPartResult($storageName)
{
    $core = new \Day10\Core($storageName);

    $core->play();
}

getPartResult('real');
