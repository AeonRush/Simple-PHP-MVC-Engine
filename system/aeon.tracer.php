<?php

set_error_handler('handler');
function handler ( $errno , $errstr, $errfile, $errline, $errcontext) {

    echo $errfile;
    exit;

    return true;
};

/// 2014 | AeonRUSH |