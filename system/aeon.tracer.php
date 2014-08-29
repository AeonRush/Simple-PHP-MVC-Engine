<?php

set_error_handler('handler');
function handler ( $errno , $errstr, $errfile, $errline, $errcontext) {
    header('Location: /error/');
    exit;
};

/// 2014 | AeonRUSH |